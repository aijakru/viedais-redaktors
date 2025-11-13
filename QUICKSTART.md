# 🚀 Quick Start Guide - Viedais Teksta Redaktors

## Ātrā Sākšana (5 minūtes)

### 1️⃣ Pirmsprasības
```bash
# Pārbaudiet, vai ir instalēts PHP 8.2+
php --version

# Pārbaudiet, vai ir instalēts Composer
composer --version

# Pārbaudiet, vai ir instalēts Node.js 18+
node --version
```

Ja kaut kas trūkst:
- **PHP:** https://www.php.net/downloads
- **Composer:** https://getcomposer.org/download/
- **Node.js:** https://nodejs.org/

### 2️⃣ Instalācija (3 komandas)

```bash
# 1. Instalējiet dependencies
composer install && npm install

# 2. Uzstādiet .env un ģenerējiet atslēgu
cp .env.example .env
php artisan key:generate

# 3. Palaidiet migrācijas
touch database/database.sqlite
php artisan migrate
```

### 3️⃣ Konfigurācija

Rediģējiet `.env` failu un pievienojiet savu Gemini API atslēgu:

```env
GEMINI_API_KEY=jūsu_api_atslēga_šeit
```

**Kur iegūt API atslēgu?**
https://aistudio.google.com/app/apikey

### 4️⃣ Palaišana (2 termināļi)

**Terminālī #1 - Frontend:**
```bash
npm run dev
```

**Terminālī #2 - Backend:**
```bash
php artisan serve
```

**Gatavs!** Atveriet: http://localhost:8000

---

## 💡 Pirmā Lietošana

### Teksta Analīze
1. Iekopējiet tekstu tekstapieturā
2. Izvēlieties valodu (Latviešu/Русский/English)
3. Izvēlieties kategoriju (pēc izvēles)
4. Nospiediet "Analizēt Tekstu"
5. Gaidiet 5-10 sekundes
6. Skatiet rezultātus!

### Administratora Iestatījumi
1. Dodieties uz: http://localhost:8000/admin/settings
2. Izvēlieties tabu:
   - **Sistēmas Prompts** - Pielāgojiet AI instrukcijas
   - **Vadlīnijas** - Augšupielādējiet PDF/TXT failus
   - **Zināšanu Bāze** - Pievienojiet labus rakstu piemērus
   - **Kategorijas** - Izveidojiet jaunas kategorijas

---

## 🧪 Ātrā Testēšana

### Testa Teksts (Latviešu):
```
Šodien Latvijas basketbola izlase izcīnīja uzvaru pret Igauniju. 
Spēle bija spraiga un ļoti aizraujoša. Komandas kapteinis guva 25 punktus. 
Treneris bija ļoti apmierināts ar rezultātu un komandas sniegumu kopumā.
```

**Sagaidāmie rezultāti:**
- Vārdu skaits: ~30
- Teikumu skaits: 4
- Lasāmības indekss: 60-70 (Labs)
- AI ieteikumi uzlabojumiem

---

## 🐛 Problēmu Risināšana

### Kļūda: "Class not found"
```bash
composer dump-autoload
```

### Kļūda: "SQLSTATE[HY000]"
```bash
touch database/database.sqlite
php artisan migrate:fresh
```

### Kļūda: "Vite manifest not found"
```bash
npm run build
```

### Kļūda: "Permission denied" (storage/)
```bash
chmod -R 777 storage bootstrap/cache
```

### AI analīze nedarbojas
1. Pārbaudiet `.env` failu - vai `GEMINI_API_KEY` ir iestatīts?
2. Pārbaudiet interneta savienojumu
3. Pārbaudiet API atslēgas limitus: https://aistudio.google.com/

---

## 📚 Noderīgas Komandas

```bash
# Notīrīt cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Atjaunot datubāzi
php artisan migrate:fresh

# Skatīt route sarakstu
php artisan route:list

# Skatīt logus
tail -f storage/logs/laravel.log

# Production build
npm run build
```

---

## 🎯 Nākamie Soļi

1. ✅ Pievienojiet savas redakcionālās vadlīnijas (`/admin/settings`)
2. ✅ Izveidojiet kategoriju specifiskus promptus
3. ✅ Pievienojiet labos rakstu piemērus zināšanu bāzē
4. ✅ Testējiet visas 3 valodas
5. ✅ Pielāgojiet sistēmas promptu savām vajadzībām

---

## 📖 Pilna Dokumentācija

- **README.md** - Pilna instalācijas instrukcija
- **PROJECT_SUMMARY.md** - Detalizēts projekta apraksts
- **TESTING.md** - Testēšanas vadlīnijas
- **viedais.plan.md** - Oriģinālais plāns

---

## 🆘 Palīdzība

**Problēmas?**
1. Pārbaudiet `storage/logs/laravel.log`
2. Pārbaudiet browser console (F12)
3. Pārbaudiet terminal error messages

**Kontakti:**
- GitHub: https://github.com/aijakru/viedais-redaktors
- Izstrādāts: Delfi Hakatons 2024

---

## 🎉 Veiksmīgi!

Ja viss darbojas, jūs redzēsiet:
- ✅ Galveno lapu ar teksta ievadi
- ✅ Valodas un kategorijas izvēli
- ✅ "Analizēt Tekstu" pogu
- ✅ Admin paneli `/admin/settings`

**Prieka programmēšanu!** 🚀

