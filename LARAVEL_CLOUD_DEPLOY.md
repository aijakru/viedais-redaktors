# 🚀 Laravel Cloud Deployment - Viedais Teksta Redaktors

## ✅ Viss Ir Gatavs Git Push'ošanai!

Projekts ir pilnībā sagatavots un commit'ots. Tagad jāpush'o uz GitHub un jākonfigurē Laravel Cloud.

---

## 📤 1. Push uz GitHub

### Variants A: Caur Terminal

```bash
cd "/Users/aija.krutaine/Desktop/Viedais redaktors/viedais-redaktors"

# Ja izmantojat HTTPS:
git push origin main

# Ja izmantojat SSH:
git push origin main
```

**Ja prasa autentifikāciju:**
- Username: `aijakru`
- Password: Jūsu GitHub Personal Access Token

**Kā iegūt Personal Access Token:**
1. Dodieties uz: https://github.com/settings/tokens
2. Generate new token (classic)
3. Izvēlieties scope: `repo` (viss)
4. Kopējiet token un izmantojiet kā password

### Variants B: Caur GitHub Desktop

1. Atveriet GitHub Desktop
2. Izvēlieties repository: `viedais-redaktors`
3. Visi faili jau ir committed
4. Nospiediet: **"Push origin"**

### Variants C: Caur VS Code / Cursor

1. Git panelis (Ctrl/Cmd + Shift + G)
2. Visi faili jau ir committed
3. Klikšķiniet uz "..." → Push

---

## ☁️ 2. Laravel Cloud Konfigurācija

### A. Izveidojiet Projektu Laravel Cloud

1. Dodieties uz: https://cloud.laravel.com/
2. Klikšķiniet: **"New Project"**
3. Izvēlieties: **"Connect GitHub Repository"**
4. Izvēlieties: `aijakru/viedais-redaktors`
5. Branch: `main`

### B. Environment Variables (.env)

Laravel Cloud dashboard → **Environment** → Pievienojiet:

```env
APP_NAME="Viedais Teksta Redaktors"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://jūsu-domēns.laravel.app

DB_CONNECTION=sqlite
DB_DATABASE=/var/www/database/database.sqlite

GEMINI_API_KEY=AIzaSyBe1bUfcEXU8I4O9_Jscuu1lpx_vk6KmLQ
GEMINI_MODEL=gemini-2.0-flash-exp

SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database

LOG_CHANNEL=stack
LOG_LEVEL=info
```

### C. Build Configuration

Laravel Cloud automātiski detektēs:
- ✅ `composer.json` - PHP dependencies
- ✅ `package.json` - NPM dependencies
- ✅ `vite.config.js` - Asset building
- ✅ Database migrations

**Build komandas** (ja nepieciešams manuāli konfigurēt):

```bash
# Install dependencies
composer install --no-dev --optimize-autoloader
npm install

# Build assets
npm run build

# Run migrations
php artisan migrate --force

# Create storage link
php artisan storage:link

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### D. Deployment Settings

**Web Server:** Nginx + PHP 8.2  
**Node Version:** 18.x  
**Database:** SQLite (iekļauts projekta failos)

---

## 🔐 3. Storage Permissions

Laravel Cloud vajadzēs write access:

```
storage/
storage/app/
storage/app/uploads/
storage/app/uploads/guidelines/
storage/app/uploads/knowledge_base/
storage/logs/
storage/framework/
storage/framework/cache/
storage/framework/sessions/
storage/framework/views/
```

Laravel Cloud to konfigurē automātiski, bet ja nepieciešams:

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

---

## 🎯 4. Pēc Deployment Pārbaude

### A. Pārbaudiet Aplikāciju

```
https://jūsu-projekts.laravel.app
```

**Jāredzēt:**
- ✅ Galvenā lapa ar teksta ievadi
- ✅ Valodas izvēle (LV/RU/EN)
- ✅ "Analizēt Tekstu" poga

### B. Pārbaudiet Admin Paneli

```
https://jūsu-projekts.laravel.app/admin/settings
```

**Jāredzēt:**
- ✅ 4 tabi (Sistēmas Prompts, Vadlīnijas, Zināšanu Bāze, Kategorijas)
- ✅ Visi funkciju pieejami

### C. Testējiet Analīzi

**Testa teksts:**
```
Šodien Rīgā notika svarīga konference par mākslīgo intelektu. 
Eksperti apsprieda AI nākotni un tās ietekmi uz sabiedrību.
```

1. Iekopējiet tekstapieturā
2. Izvēlieties: Valoda: Latviešu, Kategorija: Ziņa
3. Nospiediet: "Analizēt Tekstu"
4. Sagaidiet 5-10 sekundes

**Sagaidāmais rezultāts:**
- ✅ Vārdu skaits: ~18
- ✅ Teikumu skaits: 2
- ✅ Lasāmības indekss: 60-70
- ✅ AI ieteikumi

---

## 🔧 5. Troubleshooting

### Kļūda: "Route [login] not defined"

Pievienojiet `.env`:
```env
APP_URL=https://jūsu-domēns.laravel.app
```

### Kļūda: "Class not found"

Izpildiet:
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

### Kļūda: "Vite manifest not found"

Pārbūvējiet assets:
```bash
npm run build
```

### Kļūda: "SQLSTATE[HY000]"

Pārbaudiet database ceļu `.env`:
```env
DB_DATABASE=/var/www/database/database.sqlite
```

Izpildiet migrācijas:
```bash
php artisan migrate:fresh --force
```

### AI analīze nedarbojas

Pārbaudiet `.env`:
```env
GEMINI_API_KEY=AIzaSyBe1bUfcEXU8I4O9_Jscuu1lpx_vk6KmLQ
```

Pārbaudiet logus:
```bash
tail -f storage/logs/laravel.log
```

---

## 📊 6. Logs un Monitoring

### Laravel Cloud Dashboard:

- **Deployments** - Skatīt deployment vēsturi
- **Logs** - Real-time aplikācijas logi
- **Metrics** - Performance metriku
- **Database** - Database pārvaldība
- **Environment** - Environment variables

### Manual Log Access:

```bash
# Laravel Cloud CLI
laravel logs tail

# Vai caur SSH:
tail -f /var/www/storage/logs/laravel.log
```

---

## 🔄 7. Turpmākie Deployments

Kad veiciet izmaiņas:

1. **Veiciet izmaiņas lokāli**
2. **Commit:**
   ```bash
   git add .
   git commit -m "Your message"
   ```
3. **Push:**
   ```bash
   git push origin main
   ```
4. **Laravel Cloud automātiski deploy'o!** 🚀

---

## ⚙️ 8. Laravel Cloud Komandas (CLI)

Ja izmantojat Laravel Cloud CLI:

```bash
# Deploy manuāli
laravel deploy

# Skatīt logus
laravel logs

# Izpildīt artisan komandas
laravel artisan migrate

# SSH pieslēgšanās
laravel ssh

# Environment variables
laravel env:set GEMINI_API_KEY=your_key
```

---

## 📱 9. Custom Domain (Neobligāti)

Ja vēlaties pievienot savu domēnu:

1. Laravel Cloud dashboard → **Domains**
2. Klikšķiniet: **"Add Domain"**
3. Ievadiet: `viedais-redaktors.delfi.lv`
4. Konfigurējiet DNS:
   ```
   Type: CNAME
   Name: viedais-redaktors
   Value: jūsu-projekts.laravel.app
   ```
5. SSL sertifikāts tiks izveidots automātiski

---

## ✅ Deployment Checklist

- [ ] Kods push'ots uz GitHub
- [ ] Laravel Cloud projekts izveidots
- [ ] Repository savienots
- [ ] Environment variables iestatīti
- [ ] GEMINI_API_KEY pievienots
- [ ] Pirmais deployment veiksmīgs
- [ ] Migrācijas izpildītas
- [ ] Aplikācija pieejama
- [ ] Admin panelis darbojas
- [ ] Teksta analīze darbojas
- [ ] Visu 3 valodu tests veiksmīgs

---

## 🎉 Kad Viss Darbojas

Jūsu aplikācija būs pieejama:

```
https://jūsu-projekts.laravel.app
```

Ar pilnu funkcionalitāti:
- ✅ Teksta analīze 3 valodās
- ✅ Google Gemini AI
- ✅ Admin panelis
- ✅ Vadlīniju pārvaldība
- ✅ Zināšanu bāze

---

**Veiksmi ar Laravel Cloud deployment! 🚀**

**Izstrādāts:** Delfi Hakatons 2024  
**Repository:** https://github.com/aijakru/viedais-redaktors

