# apliasi-web-absensi
APLIKASI ABSENSI KARYAWAN BERBASIS WEB

# Requirement:
PHP >= 8

## Note: 
Untuk aplikasi menggunakan template argon bootstrap

# Installasi dan configurasi
1. Clone project berikut
2. Masuk ke directory aplikasi
3. Jalankan script berikut "php config/seed.php". Script berikut untuk membuat akun admin dan satu data dummy karyawan.
4. Setelah berada di directory aplikasi, masuk ke direcory public "cd /public", lalu jalankan script berikut di command "php localhost:8080" untuk menjalankan aplikasi di lokal server.
5. Buka aplikasi dengan url "localhost:8008" pada web browser untuk menjalankan aplikasi.
6. Selesai.

# User guide
1. Masuk ke menu admin untuk mendaftarkan karyawan.
2. Masuk ke menu admin dashboard untuk melihat data absensi karyawan.
3. Masuk ke login untuk masuk, jika anda sudah login anda dapat checkin ataupun checkout

# END POINT
## "/employees/admin" -> endpoint admin dashboard, untuk melihat data absensi karyawan
## "/employees/admin/register" -> endpoint untuk mendaftarkan karyawan
## "/employees/login" -> endpoint untuk untuk login

# LOGIN FORM URL: "/employees/login"
![login_form_attendance](https://user-images.githubusercontent.com/61643826/172020336-1c9ee223-7445-4b6f-9cd8-23360d135337.png)

# CHECKIN/CHECKOUT DISPLAY
![checkinout](https://user-images.githubusercontent.com/61643826/172020519-06dc5946-faf4-4edf-abdc-8285365e564c.png)

# ADMIN DASHBORD DISPLAY
![admindashbord](https://user-images.githubusercontent.com/61643826/172020612-d4dc05c3-7cc4-4919-9568-d7e24226b747.png)

# FORM DAFTAR KARYAWAN
![registeremplyee](https://user-images.githubusercontent.com/61643826/172020689-78179be3-723f-4b93-b04f-248276dbd638.png)