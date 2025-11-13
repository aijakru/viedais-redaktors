# Viedais Teksta Redaktors

AI-powered teksta analīzes rīks žurnālistiem un redaktoriem. Izmanto Google Gemini AI, lai analizētu tekstus pēc redakcionālajām vadlīnijām un sniegtu konkrētus uzlabojumus.

## Funkcionalitāte

### 4 Galvenās Komponentes

1. **Teksta Ievietošana** - Ērti iekopējiet vai ielīmējiet tekstu analīzei
2. **Teksta Iestatījumi** - Izvēlieties valodu (LV/RU/EN), kategoriju un stilu
3. **Analīzes Rezultāti** - Detalizēta analīze ar metrikām un ieteikumiem
4. **Sistēmas Iestatījumi** - Pilna kontrole pār AI promptiem, vadlīnijām un zināšanu bāzi

### Galvenās Iespējas

- ✅ Teksta metriku aprēķināšana (vārdu skaits, teikumu skaits, vidējais vārdu skaits teikumā)
- ✅ Lasāmības indeksa aprēķins
- ✅ Sarežģītu teikumu identificēšana (>25 vārdi)
- ✅ AI-powered ieteikumi uzlabojumiem
- ✅ Lieku/atkārtotu frāžu identificēšana
- ✅ Automātisks kopsavilkums
- ✅ 3 valodu atbalsts (Latviešu, Krievu, Angļu)
- ✅ Kategoriju specifiskas vadlīnijas
- ✅ Redakcionālo vadlīniju augšupielāde (PDF, TXT, DOCX)
- ✅ Zināšanu bāze ar labiem rakstu piemēriem
- ✅ Pilnībā pielāgojams sistēmas prompts

## Tehnoloģiju Stack

- **Backend:** Laravel 11 (PHP 8.2+)
- **Frontend:** Vue 3 + Inertia.js
- **Styling:** Tailwind CSS
- **AI:** Google Gemini 2.0 Flash
- **Database:** SQLite (dev), PostgreSQL/MySQL (production)

## Instalācija

### Prasības

- PHP 8.2+
- Composer
- Node.js 18+
- NPM vai Yarn

### Soļi

1. **Klonējiet repozitoriju:**
```bash
git clone https://github.com/aijakru/viedais-redaktors.git
cd viedais-redaktors
```

2. **Instalējiet PHP dependencies:**
```bash
composer install
```

3. **Instalējiet JavaScript dependencies:**
```bash
npm install
```

4. **Izveidojiet .env failu:**
```bash
cp .env.example .env
```

5. **Konfigurējiet .env:**
```env
APP_NAME="Viedais Teksta Redaktors"
DB_CONNECTION=sqlite

GEMINI_API_KEY=your_api_key_here
GEMINI_MODEL=gemini-2.0-flash-exp
```

6. **Izveidojiet datubāzi:**
```bash
touch database/database.sqlite
```

7. **Palaidiet migrācijas:**
```bash
php artisan migrate
```

8. **Ģenerējiet aplikācijas atslēgu:**
```bash
php artisan key:generate
```

9. **Izveidojiet storage linkus:**
```bash
php artisan storage:link
```

10. **Kompilējiet frontend:**
```bash
npm run dev
```

11. **Palaidiet serveri:**
```bash
php artisan serve
```

Aplikācija būs pieejama: http://localhost:8000

## Lietošana

### Teksta Analīze

1. Atveriet galveno lapu
2. Iekopējiet tekstu tekstapieturā
3. Izvēlieties valodu un kategoriju
4. Nospiediet "Analizēt Tekstu"
5. Pārskatiet rezultātus labajā pusē

### Administratora Funkcijas

Atveriet `/admin/settings` lai:

- **Sistēmas Prompts** - Pielāgojiet AI analīzes instrukcijas
- **Vadlīnijas** - Augšupielādējiet redakcionālās vadlīnijas
- **Zināšanu Bāze** - Pievienojiet labus rakstu piemērus
- **Kategorijas** - Pārvaldiet kategorijas un to specifiskos promptus

## API Endpoints

### Teksta Analīze
- `POST /analyze` - Analizēt tekstu

### Administratora
- `GET/POST /admin/guidelines` - Vadlīniju pārvaldība
- `GET/POST /admin/knowledge-base` - Zināšanu bāzes pārvaldība
- `GET/POST /admin/settings/prompt` - Prompta rediģēšana
- `GET/POST /admin/categories` - Kategoriju pārvaldība

## Izstrādes Komanda

Izstrādāts Delfi hakatonā 2024

## Licence

MIT License


