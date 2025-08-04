# 📝 To-Do List Web Application

Aplikasi web sederhana untuk mengelola daftar tugas (to-do list) dengan sistem login dan register.

## ✨ Fitur

- 🔐 **Sistem Login & Register**: Autentikasi user dengan password hashing
- ➕ **Tambah Tugas**: Buat tugas baru dengan prioritas (High/Medium/Low)
- ✅ **Kelola Status**: Start, Cancel, Done, atau Delete tugas
- 📊 **Tampilan Terorganisir**: Sorting berdasarkan prioritas dan status
- 🎨 **UI Responsif**: Menggunakan Bootstrap dan CSS custom

## 🚀 Cara Menjalankan

### Persiapan

1. **Install XAMPP**
   - Download dari: https://www.apachefriends.org/
   - Install dan jalankan **Apache** + **MySQL**

2. **Setup Database**
   - Buka phpMyAdmin: `http://localhost/phpmyadmin`
   - Import file `database.sql` atau jalankan query di dalamnya

3. **Copy Project**
   - Pindahkan semua file ke: `C:\xampp\htdocs\To-Do-List-Web\`

4. **Akses Website**
   - Buka browser: `http://localhost/To-Do-List-Web/`

### Struktur Database

```sql
-- Tabel users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel tbl_tugas
CREATE TABLE tbl_tugas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    priority ENUM('High', 'Medium', 'Low') NOT NULL,
    tugas TEXT NOT NULL,
    status VARCHAR(50) DEFAULT 'No Status',
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## 📁 Struktur File

```
To-Do-List-Web/
├── index.php          # Halaman utama (welcome)
├── login.php           # Halaman login
├── register.php        # Halaman register
├── todo.php            # Halaman utama to-do list
├── start.php           # Update status ke "On Progress"
├── cancel.php          # Update status ke "Cancelled"
├── delete.php          # Hapus tugas
├── style.css           # Styling CSS
├── database.sql        # Setup database
└── README.md           # Dokumentasi ini
```

## 🔧 Konfigurasi Database

Aplikasi menggunakan konfigurasi database berikut:
- **Host**: localhost
- **Username**: root
- **Password**: (kosong)
- **Database**: todo

Jika perlu mengubah konfigurasi, edit di setiap file PHP:
```php
$koneksi = mysqli_connect("localhost", "root", "", "todo");
```

## 📱 Cara Penggunaan

1. **Register**: Daftar akun baru di halaman register
2. **Login**: Masuk dengan username dan password
3. **Tambah Tugas**: 
   - Isi form "New To Do"
   - Pilih prioritas (High/Medium/Low)
   - Klik "Add"
4. **Kelola Tugas**:
   - **Start**: Ubah status ke "On Progress"
   - **Cancel**: Ubah status ke "Cancelled"
   - **Delete**: Hapus tugas
   - **Checkbox**: Tandai sebagai "Done"

## 🎨 Fitur UI

- Responsive design dengan Bootstrap 5
- Color palette yang menarik
- Table view untuk menampilkan tugas
- Form validation
- Error handling dan pesan status

## 🔒 Keamanan

- Password hashing menggunakan `password_hash()`
- Input sanitization dengan `mysqli_real_escape_string()`
- Session management untuk autentikasi
- SQL injection protection

## 📋 Status Tugas

- **No Status**: Tugas baru yang belum dimulai
- **On Progress**: Tugas sedang dikerjakan
- **Cancelled**: Tugas dibatalkan
- **Done**: Tugas selesai

## 🛠️ Troubleshooting

### Database Connection Error
```
Koneksi database gagal: Access denied for user 'root'@'localhost'
```
**Solusi**: Pastikan MySQL service berjalan di XAMPP

### File Not Found
```
The requested URL /To-Do-List-Web/ was not found on this server
```
**Solusi**: Pastikan semua file ada di folder `C:\xampp\htdocs\To-Do-List-Web\`

### Login Failed
**Solusi**: Register akun baru atau gunakan akun default:
- Username: `admin`
- Password: `password`

## 📞 Support

Jika ada pertanyaan atau masalah, silakan buat issue di repository ini.

---
🌟 **Happy Coding!** 🌟
