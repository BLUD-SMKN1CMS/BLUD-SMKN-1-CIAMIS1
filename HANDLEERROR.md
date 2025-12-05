**Avast lagi ya?** Tenang, kita sudah tau solusinya. Mari kita perbaiki:

## 🚨 **SOLUSI CEPAT:**

### **1. Matikan Avast Shields**
```bash
# Cek apakah Avast running
Get-Process | Where-Object {$_.ProcessName -like "*avast*"}

# Jika ada:
# 1. Klik kanan icon Avast di system tray
# 2. Pilih "Avast shields control"
# 3. Pilih "Disable for 10 minutes" 
#    ATAU
#    "Disable until computer is restarted"
```

### **2. Reinstall Vendor Lagi (karena mungkin corrupt)**
```bash
# Hapus vendor
Remove-Item -Path "vendor" -Recurse -Force -ErrorAction SilentlyContinue

# Install fresh dengan optimasi
php composer.phar install --no-interaction --optimize-autoloader

# Generate key
php artisan key:generate
```

### **3. PAKAI XAMPP SAJA - TANPA ARTISAN SERVE**
**Ini solusi paling aman!**

```bash
# 1. Jangan pakai artisan serve
# 2. Akses langsung via XAMPP:

# Buka browser ke:
http://localhost/tefa_smkn1_ciamis/public/
```

### **4. Tambahkan Exception di Avast**
Jika mau permanen:
1. Buka Avast → Menu → Settings
2. Protection → Core Shields
3. File Shield → Exclusions
4. Tambahkan folder: `D:\xampp_new\htdocs\tefa_smkn1_ciamis\`

## 🎯 **ACTION SEKARANG:**

**Pilih salah satu:**
- **Option A:** Matikan Avast sementara, lalu `php artisan key:generate`
- **Option B:** Pakai XAMPP langsung tanpa artisan serve

**Saya rekomendasikan Option B** - lebih stabil dan tidak terganggu Avast.

**Coba akses via browser dulu:**
```
http://localhost/tefa_smkn1_ciamis/public/
```

**Apa yang muncul?** Jika error, screenshot/tulis pesan errornya.

Detail:

Header/Navbar → app.blade.php (line 71-115)

Carousel → home.blade.php (line 7-46)

Section TEFA → home.blade.php (line 49-110)

Section Produk → home.blade.php (line 113-180)

Section Layanan → home.blade.php (line 183-250)

Section Kontak → home.blade.php (line 253-380)

Footer → app.blade.php (line 206-250)