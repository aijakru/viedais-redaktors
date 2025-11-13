#!/bin/bash

# Viedais Teksta Redaktors - Automatizēts Setup Skripts
# Palaidiet: bash setup.sh

set -e

echo "🚀 Viedais Teksta Redaktors - Instalācija"
echo "=========================================="
echo ""

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Check if Homebrew is installed
echo "📦 Pārbaude: Homebrew..."
if command -v brew &> /dev/null; then
    echo -e "${GREEN}✓ Homebrew jau ir instalēts${NC}"
else
    echo -e "${YELLOW}! Homebrew nav atrasts. Instalēju...${NC}"
    /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
    
    # Add Homebrew to PATH
    if [[ $(uname -m) == 'arm64' ]]; then
        echo 'eval "$(/opt/homebrew/bin/brew shellenv)"' >> ~/.zprofile
        eval "$(/opt/homebrew/bin/brew shellenv)"
    else
        echo 'eval "$(/usr/local/bin/brew shellenv)"' >> ~/.zprofile
        eval "$(/usr/local/bin/brew shellenv)"
    fi
    echo -e "${GREEN}✓ Homebrew instalēts${NC}"
fi

echo ""

# Check if PHP is installed
echo "🐘 Pārbaude: PHP..."
if command -v php &> /dev/null; then
    PHP_VERSION=$(php -v | head -n 1 | cut -d " " -f 2 | cut -d "." -f 1,2)
    echo -e "${GREEN}✓ PHP $PHP_VERSION ir instalēts${NC}"
else
    echo -e "${YELLOW}! PHP nav atrasts. Instalēju PHP 8.2...${NC}"
    brew install php@8.2
    echo 'export PATH="/opt/homebrew/opt/php@8.2/bin:$PATH"' >> ~/.zprofile
    export PATH="/opt/homebrew/opt/php@8.2/bin:$PATH"
    echo -e "${GREEN}✓ PHP instalēts${NC}"
fi

echo ""

# Check if Composer is installed
echo "🎼 Pārbaude: Composer..."
if command -v composer &> /dev/null; then
    echo -e "${GREEN}✓ Composer jau ir instalēts${NC}"
else
    echo -e "${YELLOW}! Composer nav atrasts. Instalēju...${NC}"
    brew install composer
    echo -e "${GREEN}✓ Composer instalēts${NC}"
fi

echo ""

# Check if Node.js is installed
echo "📗 Pārbaude: Node.js..."
if command -v node &> /dev/null; then
    NODE_VERSION=$(node -v)
    echo -e "${GREEN}✓ Node.js $NODE_VERSION ir instalēts${NC}"
else
    echo -e "${YELLOW}! Node.js nav atrasts. Instalēju Node.js 18...${NC}"
    brew install node@18
    echo -e "${GREEN}✓ Node.js instalēts${NC}"
fi

echo ""
echo "=========================================="
echo -e "${GREEN}✓ Visi nepieciešamie rīki ir instalēti!${NC}"
echo ""

# Navigate to project directory
cd "$(dirname "$0")"

echo "📦 Instalēju projekta dependencies..."
echo ""

# Install Composer dependencies
echo "1️⃣ Composer dependencies..."
if [ -f "composer.json" ]; then
    composer install --no-interaction
    echo -e "${GREEN}✓ Composer dependencies instalēti${NC}"
else
    echo -e "${RED}✗ composer.json nav atrasts!${NC}"
fi

echo ""

# Install NPM dependencies
echo "2️⃣ NPM dependencies..."
if [ -f "package.json" ]; then
    npm install
    echo -e "${GREEN}✓ NPM dependencies instalēti${NC}"
else
    echo -e "${RED}✗ package.json nav atrasts!${NC}"
fi

echo ""

# Setup .env file
echo "3️⃣ .env konfigurācija..."
if [ ! -f ".env" ]; then
    if [ -f ".env.example" ]; then
        cp .env.example .env
        echo -e "${GREEN}✓ .env fails izveidots${NC}"
    else
        echo -e "${RED}✗ .env.example nav atrasts!${NC}"
    fi
else
    echo -e "${GREEN}✓ .env fails jau eksistē${NC}"
fi

echo ""

# Generate app key
echo "4️⃣ Laravel aplikācijas atslēga..."
if [ -f "artisan" ]; then
    php artisan key:generate --force
    echo -e "${GREEN}✓ Aplikācijas atslēga ģenerēta${NC}"
else
    echo -e "${RED}✗ artisan fails nav atrasts!${NC}"
fi

echo ""

# Run migrations
echo "5️⃣ Datubāzes migrācijas..."
if [ -f "database/database.sqlite" ]; then
    php artisan migrate --force
    echo -e "${GREEN}✓ Migrācijas izpildītas${NC}"
else
    echo -e "${YELLOW}! database.sqlite nav atrasts, bet tas ir OK (tiks izveidots)${NC}"
    php artisan migrate --force
    echo -e "${GREEN}✓ Migrācijas izpildītas${NC}"
fi

echo ""

# Create storage link
echo "6️⃣ Storage links..."
php artisan storage:link
echo -e "${GREEN}✓ Storage links izveidoti${NC}"

echo ""
echo "=========================================="
echo -e "${GREEN}🎉 Instalācija pabeigta!${NC}"
echo ""
echo "📝 Nākamie soļi:"
echo ""
echo "1. Pārbaudiet .env failu un pievienojiet GEMINI_API_KEY:"
echo "   nano .env"
echo ""
echo "2. Palaidiet development serverus (2 termināļi):"
echo ""
echo "   Terminālī #1:"
echo "   cd \"$(pwd)\""
echo "   npm run dev"
echo ""
echo "   Terminālī #2:"
echo "   cd \"$(pwd)\""
echo "   php artisan serve"
echo ""
echo "3. Atveriet pārlūkprogrammā:"
echo "   http://localhost:8000"
echo ""
echo -e "${GREEN}Veiksmi! 🚀${NC}"

