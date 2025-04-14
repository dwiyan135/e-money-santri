## ✅ Bahasa Indonesia (`README.md`) 

# 💳 E-Money Santri

**E-Money Santri** adalah aplikasi web berbasis CodeIgniter 4 yang dirancang untuk membantu pengelolaan keuangan di lingkungan pesantren. Aplikasi ini menyediakan fitur manajemen data santri, pencatatan transaksi, dan laporan keuangan secara terstruktur.

## 🧩 Fitur Utama

- Manajemen data santri  
- Pencatatan transaksi keuangan  
- Laporan dan histori transaksi  
- Dashboard informasi keuangan  
- Sistem login pengguna  
- Dibangun dengan CodeIgniter 4

## 🛠️ Langkah Instalasi

1. **Clone Repositori**
```
git clone https://github.com/dwiyan135/e-money-santri.git
cd e-money-santri
```

2. **Install Dependensi**
```
composer install
```

3. **Salin dan Ubah Konfigurasi `.env`**
```
cp env .env
```
Edit pengaturan koneksi database di file `.env`:
```
database.default.hostname = localhost
database.default.database = e_money_db
database.default.username = root
database.default.password =
```

4. **Buat Database & Jalankan Migrasi**
```
php spark migrate
```

5. **Jalankan Server Lokal**
```
php spark serve
```
Akses melalui browser: `http://localhost:8080`

## 🔐 Login Awal (Jika Tersedia)

Jika tidak ada sistem registrasi, data admin bisa dimasukkan langsung ke database.

Contoh:
- Username: `admin`  
- Password: `admin123` *(pastikan terenkripsi jika login aktif)*

## 🧯 Troubleshooting

- Perintah `spark` tidak dikenali:
```
php vendor/bin/spark
```

- Folder `vendor` tidak ada:
```
composer install
```

- Error koneksi database:
  - Periksa file `.env`
  - Pastikan database sudah dibuat dan terhubung

## 📄 Lisensi

Proyek ini menggunakan lisensi **MIT License**.

---

## ✅ English (`README.md`) 

# 💳 E-Money Santri

**E-Money Santri** is a web application built using CodeIgniter 4, designed to help manage financial operations in Islamic boarding schools (pesantren). It features student management, transaction logging, and structured reporting.

## 🧩 Key Features

- Student data management  
- Financial transaction logging  
- Transaction history and reports  
- Financial dashboard  
- User authentication system  
- Built with CodeIgniter 4

## 🛠️ Installation Steps

1. **Clone the Repository**
```
git clone https://github.com/dwiyan135/e-money-santri.git
cd e-money-santri
```

2. **Install Dependencies**
```
composer install
```

3. **Copy and Configure `.env`**
```
cp env .env
```
Update your database config in the `.env` file:
```
database.default.hostname = localhost
database.default.database = e_money_db
database.default.username = root
database.default.password =
```

4. **Create Database & Run Migrations**
```
php spark migrate
```

5. **Start the Development Server**
```
php spark serve
```
Visit in your browser: `http://localhost:8080`

## 🔐 Default Login (If Available)

If there's no registration system, you can manually insert an admin user in the database.

Example:
- Username: `admin`  
- Password: `admin123` *(make sure it's hashed properly)*

## 🧯 Troubleshooting

- `spark` not recognized:
```
php vendor/bin/spark
```

- Missing `vendor/` folder:
```
composer install
```

- Database connection errors:
  - Check your `.env` file
  - Make sure the database exists and credentials are correct

## 📄 License

This project is licensed under the **MIT License**.

