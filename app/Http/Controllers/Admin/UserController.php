<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.form', [
            'user' => new User,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:10', 'confirmed'],
            'is_admin' => ['nullable', 'boolean'],
        ]);

        $data['is_admin'] = $request->boolean('is_admin');

        User::create($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun berhasil dibuat.');
    }

    public function edit(int $id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.form', compact('user'));
    }

    public function update(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => ['nullable', 'string', 'min:10', 'confirmed'],
            'is_admin' => ['nullable', 'boolean'],
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $data['is_admin'] = $request->boolean('is_admin');

        if ((int) $user->id === (int) auth()->id()) {
            $data['is_admin'] = true;
        }

        DB::transaction(function () use ($user, $data) {
            $target = User::query()
                ->whereKey($user->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($target->is_admin && ! $data['is_admin']) {
                $adminCount = User::query()
                    ->where('is_admin', true)
                    ->count();

                if ($adminCount <= 1) {
                    throw ValidationException::withMessages([
                        'is_admin' => 'Administrator terakhir tidak boleh dinonaktifkan.',
                    ]);
                }
            }

            $target->update($data);
        });

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        if ((int) $id === (int) auth()->id()) {
            return back()->with(
                'error',
                'Akun administrator yang sedang digunakan tidak dapat dihapus.'
            );
        }

        $deleted = DB::transaction(function () use ($id) {
            $target = User::query()
                ->whereKey($id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($target->is_admin) {
                $adminCount = User::query()
                    ->where('is_admin', true)
                    ->count();

                if ($adminCount <= 1) {
                    return false;
                }
            }

            $target->delete();

            return true;
        });

        if (! $deleted) {
            return back()->with(
                'error',
                'Administrator terakhir tidak boleh dihapus.'
            );
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun berhasil dihapus.');
    }
}
