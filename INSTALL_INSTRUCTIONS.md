# 🛠️ Instalācijas Instrukcijas - Viedais Teksta Redaktors

## ⚠️ Svarīgi!
Jūsu datorā nav instalēti nepieciešamie rīki. Sekojiet šīm instrukcijām, lai tos instalētu.

---

## 📋 Nepieciešamie Rīki

### 1️⃣ Homebrew (Package Manager)

**Instalēšana:**
1. Atveriet Terminal
2. Iekopējiet un palaidiet:
```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```
3. Sekojiet ekrāna instrukcijām (prasīs administratora paroli)
4. Pēc instalācijas, pievienojiet Homebrew PATH:
```bash
echo 'eval "$(/opt/homebrew/bin/brew shellenv)"' >> ~/.zprofile
eval "$(/opt/homebrew/bin/brew shellenv)"
```

**Verificējiet:**
```bash
brew --version
```

---

### 2️⃣ PHP 8.2+

**Instalēšana caur Homebrew:**
```bash
brew install php@8.2
```

**Pievienojiet PATH:**
```bash
echo 'export PATH="/opt/homebrew/opt/php@8.2/bin:$PATH"' >> ~/.zprofile
source ~/.zprofile
```

**Verificējiet:**
```bash
php --version
```
Jābūt: PHP 8.2.x vai jaunākam

---

### 3️⃣ Composer (PHP Package Manager)

**Instalēšana:**
```bash
brew install composer
```

**Verificējiet:**
```bash
composer --version
```

---

### 4️⃣ Node.js 18+

**Instalēšana:**
```bash
brew install node@18
```

**Verificējiet:**
```bash
node --version
npm --version
```

---

## 🚀 Projekta Uzstādīšana

Kad visi rīki ir instalēti, uzstādiet projektu:

### Solis 1: Atveriet Terminal projektā
```bash
cd "/Users/aija.krutaine/Desktop/Viedais redaktors/viedais-redaktors"
```

### Solis 2: Instalējiet PHP dependencies
```bash
composer install
```
⏱️ Ilgums: 2-5 minūtes

### Solis 3: Instalējiet JavaScript dependencies
```bash
npm install
```
⏱️ Ilgums: 3-7 minūtes

### Solis 4: Konfigurējiet .env failu
Fails jau ir izveidots, bet pārbaudiet API atslēgu:
```bash
cat .env | grep GEMINI
```

Ja nepieciešams, rediģējiet:
```bash
nano .env
```

### Solis 5: Ģenerējiet Laravel atslēgu
```bash
php artisan key:generate
```

### Solis 6: Izpildiet datubāzes migrācijas
```bash
php artisan migrate
```

### Solis 7: Izveidojiet storage linkus
```bash
php artisan storage:link
```

---

## 🎯 Projekta Palaišana

### Nepieciešami 2 termināļi:

**Terminālī #1 - Frontend (Vite):**
```bash
cd "/Users/aija.krutaine/Desktop/Viedais redaktors/viedais-redaktors"
npm run dev
```

**Terminālī #2 - Backend (Laravel):**
```bash
cd "/Users/aija.krutaine/Desktop/Viedais redaktors/viedais-redaktors"
php artisan serve
```

### Atveriet pārlūkprogrammā:
```
http://localhost:8000
```

---

## ✅ Pārbaudes Checklist

Pirms sākat, pārliecinieties:

- [ ] Homebrew instalēts un darbojas
- [ ] PHP 8.2+ instalēts (`php --version`)
- [ ] Composer instalēts (`composer --version`)
- [ ] Node.js 18+ instalēts (`node --version`)
- [ ] `composer install` izpildīts veiksmīgi
- [ ] `npm install` izpildīts veiksmīgi
- [ ] `.env` fails eksistē un satur `GEMINI_API_KEY`
- [ ] `php artisan key:generate` izpildīts
- [ ] `php artisan migrate` izpildīts
- [ ] Abi serveri (npm un php) darbojas

---

## 🐛 Bieži Sastopamās Problēmas

### Problēma: "command not found: brew"
**Risinājums:**
```bash
# Pievienojiet Homebrew PATH
eval "$(/opt/homebrew/bin/brew shellenv)"
# Vai
eval "$(/usr/local/bin/brew shellenv)"
```

### Problēma: "composer: command not found"
**Risinājums:**
```bash
# Pārstartējiet termināli vai:
source ~/.zprofile
```

### Problēma: "Class 'PDO' not found"
**Risinājums:**
PHP extensions trūkst. Instalējiet:
```bash
brew install php@8.2
```

### Problēma: "SQLSTATE[HY000]: could not find driver"
**Risinājums:**
```bash
# Pārbaudiet PHP extensions
php -m | grep -i sqlite
# Ja nav, reinstalējiet PHP
brew reinstall php@8.2
```

### Problēma: "npm ERR! code EACCES"
**Risinājums:**
```bash
# Mainiet npm permissions
sudo chown -R $(whoami) ~/.npm
sudo chown -R $(whoami) /opt/homebrew/lib/node_modules
```

### Problēma: "Vite manifest not found"
**Risinājums:**
```bash
# Build assets
npm run build
```

### Problēma: "Port 8000 already in use"
**Risinājums:**
```bash
# Izmantojiet citu portu
php artisan serve --port=8001
```

---

## 🎓 Alternatīvā Instalācija (bez Homebrew)

Ja nevēlaties izmantot Homebrew:

### PHP - manuāla instalācija:
1. Lejupielādējiet no: https://www.php.net/downloads
2. Vai izmantojiet MAMP: https://www.mamp.info/

### Composer - manuāla instalācija:
1. Lejupielādējiet no: https://getcomposer.org/download/
2. Sekojiet oficālajām instrukcijām

### Node.js - manuāla instalācija:
1. Lejupielādējiet no: https://nodejs.org/
2. Instalējiet .pkg failu

---

## 📱 Kontakti un Palīdzība

**Projekta dokumentācija:**
- `README.md` - Pilna dokumentācija
- `QUICKSTART.md` - Ātrā sākšana
- `PROJECT_SUMMARY.md` - Projekta kopsavilkums
- `TESTING.md` - Testēšanas instrukcijas

**Oficiālā dokumentācija:**
- Laravel: https://laravel.com/docs
- Vue.js: https://vuejs.org/guide/
- Tailwind CSS: https://tailwindcss.com/docs

**Gemini API:**
- Console: https://aistudio.google.com/
- Docs: https://ai.google.dev/docs

---

## 🎉 Pēc Veiksmīgas Instalācijas

Kad viss darbojas, jūs redzēsiet:

1. ✅ `npm run dev` rāda: "VITE ready"
2. ✅ `php artisan serve` rāda: "Server running on [http://127.0.0.1:8000]"
3. ✅ Browser (http://localhost:8000) rāda galveno lapu
4. ✅ Varat ievadīt tekstu un analizēt

---

## 🚀 Pirmā Testēšana

**Testa teksts (iekopējiet galvenajā lapā):**
```
Šodien Rīgā notika svarīga konference par mākslīgo intelektu. 
Konferencē piedalījās vairāk nekā 200 dalībnieku no dažādām valstīm. 
Eksperti apsprieda AI nākotni un tās ietekmi uz sabiedrību.
```

**Izvēlieties:**
- Valoda: Latviešu
- Kategorija: Ziņa

**Nospiediet:** "Analizēt Tekstu"

**Sagaidāmais rezultāts:**
- Vārdu skaits: ~30
- Teikumu skaits: 3
- Lasāmības indekss: 60-70
- AI ieteikumi

---

## ⏱️ Paredzamais Instalācijas Laiks

- Homebrew instalācija: 5-10 minūtes
- PHP, Composer, Node.js: 10-15 minūtes
- Composer install: 2-5 minūtes
- NPM install: 3-7 minūtes
- Laravel setup: 2-3 minūtes

**Kopā: ~30-40 minūtes**

---

Veiksmi! 🎊

