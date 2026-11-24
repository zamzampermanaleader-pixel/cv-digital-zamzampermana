<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index()
    {
        $educations = Education::orderBy('sort_order')
            ->orderByDesc('start_date')
            ->get();

        return view('admin.educations.index', compact('educations'));
    }

    public function create()
    {
        return view('admin.educations.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateEducation($request);

        Education::create($validated);

        return redirect()
            ->route('admin.content.index', ['module' => 'educations'])
            ->with('success', 'Pendidikan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = \App\Models\Education::findOrFail($id);

        return view('admin.content.form', [
            'module' => 'educations',
            'config' => [
                'title' => 'Pendidikan',
                'model' => \App\Models\Education::class,
            ],
            'item' => $item,
        ]);
    }

    public function update(Request $request, Education $education)
    {
        $validated = $this->validateEducation($request);

        $education->update($validated);

        return redirect()
            ->route('admin.content.index', ['module' => 'educations'])
            ->with('success', 'Pendidikan berhasil diperbarui.');
    }

    public function destroy(Education $education)
    {
        $education->delete();

        return redirect()
            ->route('admin.content.index', ['module' => 'educations'])
            ->with('success', 'Pendidikan berhasil dihapus.');
    }

    private function validateEducation(Request $request): array
    {
        return $request->validate([
            'institution' => 'required|string|max:255',
            'degree' => 'required|string|max:100',
            'field_of_study' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'nullable|boolean',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_visible' => 'nullable|boolean',
        ]);
    }
}
