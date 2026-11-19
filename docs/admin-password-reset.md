# Reset password admin

Di halaman `/admin/login`, pilih **Lupa password?**, masukkan email admin,
lalu buka tautan dari email dan buat password baru. Tautan berlaku 60 menit,
hanya dapat digunakan sekali, dan permintaan dibatasi. Reset juga mengganti
token ingat-saya dan menghapus sesi akun jika session driver menggunakan database.

## Pengembangan lokal

Dengan `MAIL_MAILER=log`, email tidak dikirim ke kotak masuk. Isi email dan
tautan reset tersimpan di `storage/logs/laravel.log`. Jangan membagikan log
tersebut karena memuat token reset. Akun contoh `admin@example.com` hanya
untuk pengujian lokal; gunakan alamat yang benar-benar dimiliki admin sebelum
mengaktifkan pengiriman email.

## Pengiriman email

Isi `.env` dengan konfigurasi penyedia SMTP yang dipakai:

```dotenv
APP_URL=https://domain-website-anda
MAIL_MAILER=smtp
MAIL_SCHEME=smtp
MAIL_HOST=host-smtp-anda
MAIL_PORT=587
MAIL_USERNAME=username-smtp
MAIL_PASSWORD=password-smtp
MAIL_FROM_ADDRESS=alamat-pengirim-terverifikasi
MAIL_FROM_NAME="Cakrawala Geosurvey"
```

Sesuaikan port dan skema dengan penyedia (misalnya `smtps` untuk port 465).
Jalankan `php artisan config:clear` setelah mengubah konfigurasi. Pastikan
`APP_URL` memakai alamat publik HTTPS yang benar saat dipasang di hosting.
Konfirmasi pengiriman nyata ke kotak masuk admin setelah SMTP dikonfigurasi.

## Firebase

Implementasi ini menggunakan akun dan password Laravel. Reset password Firebase
hanya mengubah password akun Firebase Authentication; akun Laravel tidak berubah
otomatis. Penggunaan Firebase memerlukan integrasi login dan pemetaan akun terlebih
dahulu, bukan sekadar mengganti layanan pengiriman email.
