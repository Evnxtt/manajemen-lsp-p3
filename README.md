# Panduan Penamaan Ketika Upload
- Jika Frontend Melalkukan Push Maka Penamaanya Style-(Nama_Fitur)
- Jika Backend Melalkukan Push Maka Penamaanya Feature-(Nama_Fitur)

# Panduan Instalasi
1. Create Database name db_dcs
2. Clone this project (branch develop for development)
3. Run command "composer install" to cloned project folder
4. Run command "cp .env.example .env"
5. Run command "php artisan key:generate"
6. Run command "php artisan migrate:fresh --seed"
7. Run command "php artisan serve"
8. Open browser to url "http://127.0.0.1:8000/login" and Login with admin Account
