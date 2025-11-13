# ▶️ SĀCIET ŠEIT! - Viedais Teksta Redaktors

## 🎯 Ātrā Palaišana (2 Soļi)

### Solis 1: Instalācija (Tikai pirmoreiz)
Atveriet Terminal un palaidiet:

```bash
cd "/Users/aija.krutaine/Desktop/Viedais redaktors/viedais-redaktors"
bash setup.sh
```

⏱️ **Ilgums:** 30-40 minūtes (atkarībā no interneta ātruma)

**Šis skripts automātiski:**
- ✅ Instalēs Homebrew (ja nav)
- ✅ Instalēs PHP 8.2
- ✅ Instalēs Composer
- ✅ Instalēs Node.js 18
- ✅ Instalēs visus projekta dependencies
- ✅ Konfigurēs .env failu
- ✅ Izpildīs datubāzes migrācijas
- ✅ Sagatavos projektu darbam

**Piezīme:** Instalācijas laikā var prasīt administratora paroli!

---

### Solis 2: Palaišana
Pēc instalācijas, palaidiet:

```bash
bash run-dev.sh
```

**VAI manuāli 2 termināļos:**

**Terminālī #1:**
```bash
npm run dev
```

**Terminālī #2:**
```bash
php artisan serve
```

---

## 🌐 Atveriet Aplikāciju

Kad abi serveri darbojas, atveriet pārlūkprogrammā:

### Galvenā lapa (Teksta analīze):
```
http://localhost:8000
```

### Admin panelis (Iestatījumi):
```
http://localhost:8000/admin/settings
```

---

## ✅ Viss Darbojas, Ja Redzat:

1. **Terminālī:**
   - ✅ "VITE v5.x.x ready in Xms"
   - ✅ "Laravel development server started: http://127.0.0.1:8000"

2. **Pārlūkā:**
   - ✅ Galveno lapu ar teksta ievadi
   - ✅ Valodas izvēli (Latviešu/Русский/English)
   - ✅ "Analizēt Tekstu" pogu

---

## 🧪 Pirmā Testēšana

1. Iekopējiet šo testa tekstu:
```
Šodien Rīgā notika svarīga konference par mākslīgo intelektu. 
Konferencē piedalījās vairāk nekā 200 dalībnieku no dažādām valstīm. 
Eksperti apsprieda AI nākotni un tās ietekmi uz sabiedrību.
```

2. Izvēlieties:
   - **Valoda:** Latviešu
   - **Kategorija:** Ziņa

3. Nospiediet: **"Analizēt Tekstu"**

4. Gaidiet 5-10 sekundes

5. Redzēsiet:
   - ✅ Vārdu skaits: ~30
   - ✅ Teikumu skaits: 3
   - ✅ Lasāmības indekss: 60-70
   - ✅ AI ieteikumi uzlabojumiem

---

## 🐛 Ja Kaut Kas Nedarbojas

### 1. Kļūda: "command not found: php/composer/node"
**Risinājums:**
```bash
# Pārstartējiet termināli vai:
source ~/.zprofile

# Pārbaudiet:
php --version
composer --version
node --version
```

### 2. Kļūda: "composer install" neizdevās
**Risinājums:**
```bash
# Notīriet cache un mēģiniet vēlreiz:
composer clear-cache
composer install
```

### 3. Kļūda: "npm install" neizdevās
**Risinājums:**
```bash
# Notīriet node_modules un cache:
rm -rf node_modules package-lock.json
npm cache clean --force
npm install
```

### 4. Kļūda: "SQLSTATE[HY000]"
**Risinājums:**
```bash
# Atjaunojiet datubāzi:
rm database/database.sqlite
touch database/database.sqlite
php artisan migrate:fresh
```

### 5. Kļūda: "Vite manifest not found"
**Risinājums:**
```bash
# Build assets:
npm run build
```

### 6. AI analīze nedarbojas
**Risinājums:**
```bash
# Pārbaudiet .env failu:
cat .env | grep GEMINI_API_KEY

# Ja nav vai ir nepareiza, rediģējiet:
nano .env

# Pievienojiet:
GEMINI_API_KEY=jūsu_api_atslēga
```

**Iegūstiet API atslēgu:**
https://aistudio.google.com/app/apikey

---

## 📚 Papildus Dokumentācija

- **INSTALL_INSTRUCTIONS.md** - Detalizētas instalācijas instrukcijas
- **QUICKSTART.md** - Ātrās sākšanas pamācība
- **README.md** - Pilna projekta dokumentācija
- **PROJECT_SUMMARY.md** - Tehniskais kopsavilkums
- **TESTING.md** - Testēšanas vadlīnijas

---

## 🎓 Video Pamācības (Ieteikums)

Ja neesat strādājis ar Laravel/Vue iepriekš:

1. **Laravel Basics:** https://laracasts.com/series/laravel-8-from-scratch
2. **Vue 3 Basics:** https://vuejs.org/tutorial/
3. **Tailwind CSS:** https://tailwindcss.com/docs

---

## 🆘 Nepieciešama Palīdzība?

1. **Pārbaudiet logus:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Pārbaudiet browser console:**
   - Nospiediet F12
   - Skatiet "Console" tabu

3. **Pārbaudiet terminal error messages**

---

## 🎉 Veiksmīga Palaišana!

Ja redzat galveno lapu un varat analizēt tekstu - viss darbojas!

**Tālākās darbības:**

1. ✅ Dodieties uz `/admin/settings`
2. ✅ Pievienojiet savas redakcionālās vadlīnijas
3. ✅ Pielāgojiet sistēmas promptu
4. ✅ Izveidojiet kategoriju specifiskus promptus
5. ✅ Pievienojiet labos rakstu piemērus

---

**Veiksmi hakatonā! 🚀**

**Izstrādāts:** Delfi Hakatons 2024  
**Tehnoloģijas:** Laravel 11 + Vue 3 + Google Gemini AI

