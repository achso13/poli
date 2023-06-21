# Sisfo Pelayanan Kesehatan Klinik (Skripsi)

Sistem informasi dengan 5 tipe pengguna, pasien, dokter, admin, lab, dan apoteker. Fitur utamanya adalah untuk pasien membuat perjanjian berobat dan konsultasi online dengan dokter.

## Cara menjalankan project

1. `composer install`
2. Ubah .env.example menjadi .env
3. Buat database sesuai dengan nama database yang ada di .env dengan cara `php spark db:create nama_db`
4. `php spark migrate`
5. `php spark db:seed`
6. `php spark serve`
