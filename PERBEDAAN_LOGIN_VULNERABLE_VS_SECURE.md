# 🔒 Perbedaan Login: VULNERABLE vs SECURE

## Ringkasan Singkat
Halaman login Anda ada **2 versi**:
1. **LOGIN VULNERABLE** (Rawan SQL Injection) - `Login.php`
2. **LOGIN SECURE** (Aman dari SQL Injection) - `SecureLogin.php`

Perbedaannya hanya di **satu baris kode**. Mari kita lihat!

---

## ⚠️ Login Vulnerable (Rawan Diserang)

### File: `code/app/Controllers/Login.php`

#### Potongan Kode Yang Bermasalah (Baris 25-27):
```php
// CARA YANG SALAH (Vulnerable)
$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
$query = $db->query($sql);
```

### Mengapa Ini Berbahaya? 🚨

**Bayangkan Anda adalah seorang teller bank:**
- Pelanggan berkata: *"Ambilkan uang saya!"*
- Anda percaya dan langsung mengambil uang tanpa verifikasi

Begitu pula kode di atas. Dia **langsung percaya** pada input username dan password dari form, tanpa memeriksa apakah input itu "aman" atau "berbahaya".

### Contoh Serangan SQL Injection 💉

**Misalnya attacker mengetik di form:**

| Input Field | Apa yang dikirim |
|---|---|
| Username | `admin' OR '1'='1` |
| Password | `anything` |

**SQL yang terbentuk akan menjadi:**
```sql
SELECT * FROM users WHERE username = 'admin' OR '1'='1' AND password = 'anything'
```

**Penjelasan:**
- Bagian `'1'='1'` **selalu benar**
- Karena kondisi `OR` digunakan, filter username bisa **diolesi**
- Query ini akan **memberikan akses** meski password salah!

---

## ✅ Login Secure (Aman dari Serangan)

### File: `code/app/Controllers/SecureLogin.php`

#### Potongan Kode Yang Aman (Baris 25-28):
```php
// CARA YANG BENAR (Secure)
$user = $db->table('users')
           ->where('username', $username)
           ->where('password', $password)
           ->get()
           ->getRow();
```

### Mengapa Ini Aman? 🛡️

**Bayangkan lagi Anda adalah teller bank:**
- Pelanggan berkata: *"Ambilkan uang saya!"*
- Anda **memverifikasi dulu**: Apakah ini benar-benar pemilik rekening?
- Hanya setelah aman, baru Anda ambilkan uang

Begitu pula kode di atas. **CodeIgniter Query Builder** secara otomatis:
1. **Membersihkan** input yang berbahaya
2. **Memisahkan** antara perintah SQL dan data
3. Input apapun akan dianggap sebagai **data biasa**, bukan perintah

### Contoh Serangan yang Gagal 💪

**Attacker mengetik sama seperti sebelumnya:**

| Input Field | Apa yang dikirim |
|---|---|
| Username | `admin' OR '1'='1` |
| Password | `anything` |

**SQL Query Builder akan mengubahnya menjadi:**
```sql
SELECT * FROM users WHERE username = 'admin\' OR \'1\'=\'1' AND password = 'anything'
```

**Penjelasan:**
- `'` (kutip) akan di-**escape** menjadi `\'`
- Input `admin' OR '1'='1'` akan dianggap sebagai **nama username yang literal**
- Tidak ada **cara lain** untuk user masuk tanpa username & password yang benar
- **Serangan gagal total!** ❌

---

## 📊 Perbandingan Baris Demi Baris

| Aspek | Vulnerable | Secure |
|-------|-----------|--------|
| **Metode** | `$db->query()` dengan Raw SQL | `$db->table()` dengan Query Builder |
| **Escaping** | ❌ Tidak ada | ✅ Otomatis |
| **Keamanan Input** | ❌ Sangat Rawan | ✅ Sangat Aman |
| **Jumlah Baris** | 1 baris | 4 baris |
| **Performa** | Sedikit lebih cepat | Sedikit lebih lambat (tapi aman!) |

---

## 🧪 Cara Menguji

### Test di Login Vulnerable:
1. Buka: `http://localhost/login`
2. Username: `admin' OR '1'='1`
3. Password: `apasaja`
4. **Hasil:** ✅ MASUK TANPA PASSWORD BENAR (RAWAN!)

### Test di Login Secure:
1. Buka: `http://localhost/secure-login`
2. Username: `admin' OR '1'='1`
3. Password: `apasaja`
4. **Hasil:** ❌ DITOLAK (AMAN!)

---

## 📝 Kesimpulan Untuk Orang Awam

### Jangan Gunakan Vulnerable:
```php
❌ $sql = "SELECT * FROM users WHERE username = '$username'";
```

### Gunakan Secure:
```php
✅ $db->table('users')->where('username', $username)->get();
```

**Alasan:** Secure memberitahu database bahwa `$username` adalah **data biasa**, bukan **perintah**. Jadi attacker tidak bisa **"menipu"** database dengan syntax SQL.

---

## 🎓 Analogi Mudah

**Vulnerable** seperti:
> "Terima surat dari siapa saja tanpa buka, langsung percaya isinya"

**Secure** seperti:
> "Buka surat, cek kepala surat, cek tanda tangan, baru percaya isinya"

---

**Dibuat untuk:** Tugas Perancangan Keamanan Sistem & Jaringan
**Fokus:** SQL Injection (SQLi) pada Login Form
