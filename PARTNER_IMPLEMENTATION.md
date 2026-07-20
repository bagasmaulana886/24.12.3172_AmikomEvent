# PERTEMUAN 7 - RESPONSI PRA UTS: Implementasi Modul Partner

## Status: SELESAI ✓

Semua tugas telah diimplementasikan sesuai dengan spesifikasi assignment.

---

## Tugas 1: Git & GitHub Workflow ✓

**Branch dibuat:** `fitur-partner-3183`

```bash
git branch fitur-partner-3183
git checkout fitur-partner-3183
```

Semua perubahan telah di-commit ke branch ini.

---

## Tugas 2: Database Migration & Seeding ✓

### 2.1 Migration File

**File:** `database/migrations/2026_05_12_000001_create_partners_table.php`

Struktur tabel `partners`:

- `id` (Primary Key, Auto-increment)
- `name` (String, nama pihak partner)
- `logo_url` (String, URL logo eksternal)
- `timestamps` (created_at, updated_at)

### 2.2 Seeder dengan Faker

**File:** `database/seeders/PartnerSeeder.php`

- Menggunakan Faker untuk generate nama perusahaan random
- Membuat minimal 5 data partner fiktif
- Setiap partner memiliki logo dari placeholder service (https://placehold.co/200x200)

### 2.3 Integrasi ke DatabaseSeeder

**File:** `database/seeders/DatabaseSeeder.php`

PartnerSeeder dipanggil dalam method `run()` untuk menjalankan seeding data.

**Menjalankan migrasi:**

```bash
php artisan migrate
php artisan db:seed
```

---

## Tugas 3: Routing, Controller & Read Data ✓

### 3.1 Model Partner

**File:** `app/Models/Partner.php`

- Model Eloquent untuk tabel partners
- Fillable fields: name, logo_url

### 3.2 PartnerController

**File:** `app/Http/Controllers/Admin/PartnerController.php`

Methods yang diimplementasikan:

1. **index()** - Menampilkan daftar semua partners (dengan pagination 10 per halaman)
    - Route: GET `/admin/partners`
    - View: `admin.partners.index`

2. **create()** - Menampilkan form input partner baru
    - Route: GET `/admin/partners/create`
    - View: `admin.partners.create`

3. **store()** - Menyimpan data partner baru ke database
    - Route: POST `/admin/partners`
    - Validasi: name, logo_url (required)
    - Redirect ke halaman index setelah berhasil

### 3.3 Routes

**File:** `routes/web.php`

Routes untuk Partner module:

```php
Route::resource('partners', PartnerController::class, ['only' => ['index', 'create', 'store']]);
```

Routes yang dihasilkan:

- `GET  /admin/partners` → partners.index
- `GET  /admin/partners/create` → partners.create
- `POST /admin/partners` → partners.store

### 3.4 View: List Partners

**File:** `resources/views/admin/partners/index.blade.php`

Fitur:

- Tabel dengan kolom: Logo, Nama Partner, URL Logo, Tanggal Dibuat
- Menampilkan preview logo dari URL
- Pagination untuk navigasi data
- Tombol "Tambah Partner" untuk membuat partner baru
- Success message setelah data ditambahkan
- Empty state ketika tidak ada data

---

## Tugas 4: Form & Create Data ✓

### 4.1 View: Form Input Partner

**File:** `resources/views/admin/partners/create.blade.php`

Form fields:

- **Nama Partner** (Text input, required)
- **URL Logo** (Text input, required)
    - Contoh: https://placehold.co/200x200

Fitur tambahan:

- Validasi error display
- Tombol Submit dan Cancel
- Breadcrumb navigasi kembali ke list

### 4.2 Form Submission & Validation

- Validasi di PartnerController::store()
- Error handling dengan display pesan validasi
- Redirect ke halaman list setelah berhasil
- Success message ditampilkan di halaman list

---

## Integrasi UI: Admin Sidebar

**File:** `resources/views/layouts/admin.blade.php`

Menu baru "Manajemen Partner" ditambahkan ke sidebar admin dengan:

- Icon yang sesuai
- Active state ketika di halaman partners
- Link ke `/admin/partners`

---

## Struktur Folder yang Dibuat

```
resources/views/admin/partners/
├── index.blade.php      (List Partners)
└── create.blade.php     (Form Tambah Partner)

app/Http/Controllers/Admin/
└── PartnerController.php (Controller logic)

app/Models/
└── Partner.php          (Model Eloquent)

database/migrations/
└── 2026_05_12_000001_create_partners_table.php

database/seeders/
└── PartnerSeeder.php    (Seeder dengan Faker)
```

---

## Alur Aplikasi

### Untuk Menampilkan Data Partner:

1. User membuka `/admin/partners`
2. Route memanggil `PartnerController@index()`
3. Controller mengambil data: `Partner::latest()->paginate(10)`
4. Data dikirim ke view `admin.partners.index`
5. View menampilkan tabel dengan foreach loop

### Untuk Menambah Partner Baru:

1. User klik tombol "Tambah Partner" di halaman list
2. Dibuka form di `/admin/partners/create`
3. Route memanggil `PartnerController@create()`
4. User input data (name, logo_url)
5. Form di-submit dengan method POST ke `/admin/partners`
6. Route memanggil `PartnerController@store()`
7. Controller validasi data dengan `request->validate()`
8. Data disimpan dengan `Partner::create($data)`
9. Redirect kembali ke `/admin/partners` dengan success message

---

## Testing Checklist

- [x] Migration file dibuat dan struktur tabel benar
- [x] Seeder dengan Faker menghasilkan 5+ data dummy
- [x] Model Partner dengan fillable attributes
- [x] PartnerController index/create/store methods
- [x] Routes untuk GET /admin/partners (index, create) dan POST
- [x] View index menampilkan data dalam tabel
- [x] View create dengan form input
- [x] Form validation di controller
- [x] Redirect dan success message setelah create
- [x] Admin sidebar menu updated
- [x] Semua files dalam 1 feature branch: fitur-partner-3183

---

## Perintah untuk Testing

### Jalankan Migration:

```bash
php artisan migrate
```

### Jalankan Seeder:

```bash
php artisan db:seed
```

### Test di Browser:

- Dashboard Admin: http://localhost/admin
- List Partners: http://localhost/admin/partners
- Create Partner Form: http://localhost/admin/partners/create

### Push ke Repository:

```bash
git add .
git commit -m "Menyelesaikan Fitur CRUD Partner untuk Kuis"
git push origin fitur-partner-3183
```

---

## Catatan Implementasi

Semua implementasi mengikuti pola yang sama dengan module Event yang sudah ada:

- Struktur folder dan naming convention konsisten
- Menggunakan Eloquent ORM untuk database operations
- Blade templating dengan Tailwind CSS styling
- Validasi input di controller
- Pagination untuk list data
- Error handling dan success messaging

Modul Partner siap untuk di-demo dan di-grade oleh tim korektor!
