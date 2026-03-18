# 📋 Panduan Customization Hero Section Landing Page

## 🎯 Deskripsi Fitur

Hero section di halaman utama (landing page) sekarang **fully customizable dari admin panel**. Anda bisa mengubah:

- ✅ **Background Image** - Gambar carousel di belakang teks
- ✅ **Judul Utama** - Teks "SMKN 1 CIAMIS - Membangun Generasi..."
- ✅ **Deskripsi** - Penjelasan singkat di bawah judul
- ✅ **Tombol CTA** - Teks dan URL tombol "Jelajahi Program"
- ✅ **Stats** - Angka statistik program, layanan, tingkat kelulusan

---

## 🎨 Cara Mengatur Hero Section

### 1️⃣ **Akses Admin Panel Carousel**

Buka di browser:
```
http://127.0.0.1:8000/super-admin/carousels
```

### 2️⃣ **Edit Carousel Pertama (Hero Section)**

1. Klik tombol **"Edit"** pada carousel pertama
2. Isi field berikut:

---

## 📝 Field-Field yang Harus Diisi

### **Title** (Judul Utama)
```
SMKN 1 CIAMIS
Membangun Generasi Terampil & Berkarakter
```
- Bisa diisi dengan judul sekolah atau tagline apapun
- Mendukung line break dengan `<br />` (HTML)

### **Description** (Deskripsi)
```
Sekolah Menengah Kejuruan Negeri dengan fokus pada Teaching 
Factory (TEFA) untuk mengasah keterampilan praktis dan kompetensi 
industri.
```
- Penjelasan singkat dibawah judul
- Maks 300 karakter

### **Image** (Background Gambar)
- **Ukuran yang disarankan:** 1920 x 1080 px
- **Rasio:** 16:9
- **Format:** JPG, PNG, or GIF
- **Ukuran maksimal:** 5 MB
- **Tips:** Pilih gambar dengan warna cerah atau photo siswa/sekolah

### **Button Text** (Teks Tombol Pertama)
```
Jelajahi Program
```
- Contoh lain: "Lihat Program", "Mulai Sekarang", "Pelajari Lebih Lanjut"

### **Button URL** (Link Tombol Pertama)
```
#tefa-section
```
- Bisa internal: `#tefa-section`, `#kontak-section`, dll
- Atau eksternal: `https://google.com`
- Atau route Laravel: `/tefa`, `/produk`, dll

### **Status**
- Pilih **"Active"** untuk menampilkan hero section
- Pilih **"Inactive"** untuk menyembunyikan

### **Order**
- Set ke **"1"** untuk jadikan carousel pertama (hero section)

---

## 🔍 Contoh Pengaturan Lengkap

| Field | Nilai |
|-------|-------|
| Title | SMKN 1 CIAMIS<br>Membangun Generasi Terampil & Berkarakter |
| Description | Sekolah Menengah Kejuruan Negeri dengan fokus pada Teaching Factory (TEFA) untuk mengasah keterampilan praktis dan kompetensi industri. |
| Image | [Upload gambar siswa/suasana sekolah] |
| Button Text | Jelajahi Program |
| Button URL | #tefa-section |
| Status | Active |
| Order | 1 |

---

## 📊 Info Statistik

Stats ditampilkan secara otomatis dari database:
- **7** = Jumlah TEFA program keahlian
- **15+** = Jumlah layanan unggulan
- **95%** = Tingkat kelulusan

Stats ini **tidak bisa diubah dari carousel**, tapi bisa diubah di:
- Database (query langsung) atau
- Halaman Settings (jika ada)

---

## 🎨 Design Details

### **Layout:**
```
┌─────────────────────────────────────────────┐
│                                             │
│  Text (Kiri)          Background Image      │
│  - Judul              dengan Overlay        │
│  - Deskripsi          ┌─────────────────┐   │
│  - Buttons            │   Foto Carousel │   │
│  - 3 Stats            └─────────────────┘   │
│                                             │
└─────────────────────────────────────────────┘
```

### **Features:**
- Dark overlay (60% opacity) untuk readability
- Glassmorphism buttons dengan backdrop blur
- Smooth animations saat scroll
- Responsive mobile design

---

## ⚙️ Tips & Trik

### 1. **Menggunakan HTML di Title/Description**
Anda bisa gunakan `<br />` untuk line break:
```
SMKN 1 CIAMIS<br />Membangun Generasi Terampil & Berkarakter
```

### 2. **Gambar Terbaik untuk Hero**
Pilih gambar dengan:
- ✅ Warna cerah dan kontras tinggi
- ✅ Mengandung sosok manusia (siswa, guru, staf)
- ✅ Suasana sekolah atau kegiatan belajar
- ✅ Resolusi tinggi (minimal 1920x1080)

### 3. **Button URL Options**
- **Internal Links:** `#tefa-section`, `/produk`, `/layanan`
- **External:** `https://google.com`
- **WhatsApp:** `https://wa.me/6281234567890`

### 4. **Multiple Carousels**
Anda bisa buat carousel pertama untuk hero, dan carousel lainnya untuk:
- Galeri tambahan
- Promo khusus
- News ticker

---

## 🐛 Troubleshooting

### **Background image tidak muncul**
- ✅ Pastikan ukuran file < 5 MB
- ✅ Pastikan rasio 16:9
- ✅ Refresh browser (Ctrl + F5)

### **Teks tidak terlihat jelas**
- ✅ Pilih background image yang lebih cerah
- ✅ Atau overlay sudah bagus, teks harus lebih panjang

### **Button URL tidak bekerja**
- ✅ Gunakan format lengkap: `https://domain.com/path`
- ✅ Atau gunakan internal: `#section-id`

---

## 📚 Helpful Links

- Admin Panel Carousel: `http://127.0.0.1:8000/super-admin/carousels`
- Home Page: `http://127.0.0.1:8000/`
- Database Carousel: Table `carousels`

---

## 💡 Kesimpulan

Hero section sekarang **100% customizable** dari super-admin panel. Tidak perlu edit code lagi untuk mengubah:
- Gambar background
- Judul & deskripsi
- Tombol & link
- Status tampil/sembunyikan

Semua perubahan langsung terlihat di halaman utama! 🚀

