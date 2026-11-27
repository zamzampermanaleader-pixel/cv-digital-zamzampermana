# Deploy ke Vercel dengan MySQL Filess.io (tanpa Docker)

## Batasan runtime

PHP tidak termasuk runtime Function resmi Vercel. Konfigurasi ini memakai `vercel-php@0.9.0`, runtime komunitas dengan PHP 8.5 dan ekstensi `pdo_mysql`. Repositorinya sudah diarsipkan dan tidak didukung Vercel; artinya deploy tanpa Docker ini bergantung pada integrasi komunitas tersebut. Opsi PHP yang saat ini didokumentasikan Vercel menggunakan container, dan tidak dipakai di sini.

Function menyimpan file sementara Laravel di `/tmp`. Konfigurasi ini hanya menghubungkan database dan tidak menyiapkan object storage persisten. Filesystem Vercel tidak permanen; foto, sertifikat, dan PDF yang diunggah tidak dapat diandalkan antar-request atau antar-deploy.

## Pengaturan project Vercel

1. Import repository Git ke Vercel dan atur **Root Directory** ke root repository.
2. Pilih framework preset **Other**. `vercel.json` menetapkan output directory `public`, runtime PHP, build Vite, serta routing request dan aset statis. Jika dashboard masih menampilkan Output Directory `dist`, ubah menjadi `public` atau nonaktifkan override-nya. File terkait Docker dikecualikan dari upload Vercel.
3. Gunakan Node.js 22 untuk proses build (`.nvmrc` sudah berisi `22`). Output directory harus `public`; nilai ini juga ditetapkan oleh `vercel.json`.
4. Tambahkan variabel di bawah melalui **Project → Settings → Environment Variables**. Atur untuk Production; aktifkan Preview hanya jika preview deployment memang boleh mengakses database ini.
5. Deploy. `vercel.json` menjalankan `npm run build`; runtime PHP menginstal dependency Composer.
6. Setelah memasang custom domain, ubah `APP_URL` menjadi domain HTTPS tersebut lalu deploy ulang.

### Environment variables Vercel

| Variable | Value |
| --- | --- |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_KEY` | Buat dengan `php artisan key:generate --show`; simpan hanya di Vercel dan gunakan nilai yang sama untuk setiap deployment. |
| `APP_URL` | `https://<domain-vercel-anda>` |
| `LOG_CHANNEL` | `stderr` |
| `DB_CONNECTION` | `mysql` |
| `DB_HOST` | Host MySQL dari halaman detail database Filess.io |
| `DB_PORT` | Port MySQL dari halaman detail database Filess.io (umumnya `3306`; gunakan nilai yang ditampilkan Filess) |
| `DB_DATABASE` | Nama database persis dari Filess.io |
| `DB_USERNAME` | Username persis dari Filess.io |
| `DB_PASSWORD` | Password database Filess.io |
| `MYSQL_ATTR_SSL_CA` | Opsional: path sertifikat CA jika Filess.io menyediakan file CA yang perlu digunakan runtime |
| `SESSION_DRIVER` | `database` |
| `CACHE_STORE` | `database` |
| `QUEUE_CONNECTION` | `sync` |

Salin host, port, nama database, dan username persis dari detail koneksi Filess.io—jangan menebaknya. Pastikan database mengizinkan koneksi dari Vercel dan ikuti pengaturan TLS/firewall yang diberikan Filess. Jangan gunakan variabel `VITE_` untuk kredensial.

## Migrasi dan inisialisasi Filess.io

Jalankan migrasi satu kali dari mesin tepercaya yang sudah dikonfigurasi dengan detail koneksi Filess.io; jangan jalankan otomatis pada setiap build Vercel:

```bash
php artisan migrate --force
```

Pastikan koneksi MySQL Filess.io dapat dijangkau dari komputer yang menjalankan migrasi maupun dari function Vercel. Migrasi yang ada membuat tabel session dan cache yang dibutuhkan oleh pengaturan di atas.

Data SQLite lokal tidak otomatis disalin. Impor data yang sudah ada secara terpisah jika ingin dipertahankan. Jangan jalankan `DatabaseSeeder` default di production: seeder tersebut membuat akun test umum, bukan administrator. Buat akun administrator awal melalui proses satu kali yang tepercaya setelah migrasi.

## References

- [Vercel PHP runtime list](https://vercel.com/docs/functions/runtimes)
- [Community PHP runtime for Vercel](https://github.com/vercel-community/php)
- [Filess.io](https://filess.io/)
- [Filess.io platform and networking overview](https://docs.filess.io/docs/about-the-platform)
