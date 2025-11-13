#!/bin/bash

# Viedais Teksta Redaktors - Development Serveru Palaišana
# Palaidiet: bash run-dev.sh

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}🚀 Viedais Teksta Redaktors - Development Mode${NC}"
echo "=============================================="
echo ""

# Navigate to project directory
cd "$(dirname "$0")"

# Check if dependencies are installed
if [ ! -d "vendor" ]; then
    echo -e "${YELLOW}⚠️  Composer dependencies nav instalēti!${NC}"
    echo "Palaidiet vispirms: bash setup.sh"
    exit 1
fi

if [ ! -d "node_modules" ]; then
    echo -e "${YELLOW}⚠️  NPM dependencies nav instalēti!${NC}"
    echo "Palaidiet vispirms: bash setup.sh"
    exit 1
fi

echo -e "${GREEN}✓ Dependencies ir instalēti${NC}"
echo ""

# Check .env
if [ ! -f ".env" ]; then
    echo -e "${YELLOW}⚠️  .env fails nav atrasts!${NC}"
    echo "Palaidiet vispirms: bash setup.sh"
    exit 1
fi

echo -e "${GREEN}✓ .env fails ir konfigurēts${NC}"
echo ""

# Function to cleanup on exit
cleanup() {
    echo ""
    echo -e "${YELLOW}🛑 Apstādinu serverus...${NC}"
    kill $VITE_PID 2>/dev/null
    kill $LARAVEL_PID 2>/dev/null
    echo -e "${GREEN}✓ Serveri apturēti${NC}"
    exit 0
}

trap cleanup SIGINT SIGTERM

echo -e "${BLUE}📦 Palaižu Vite development server...${NC}"
npm run dev &
VITE_PID=$!
echo -e "${GREEN}✓ Vite darbojas (PID: $VITE_PID)${NC}"

# Wait a bit for Vite to start
sleep 3

echo ""
echo -e "${BLUE}🐘 Palaižu Laravel development server...${NC}"
php artisan serve &
LARAVEL_PID=$!
echo -e "${GREEN}✓ Laravel darbojas (PID: $LARAVEL_PID)${NC}"

echo ""
echo "=============================================="
echo -e "${GREEN}🎉 Abi serveri darbojas!${NC}"
echo ""
echo -e "${BLUE}📱 Aplikācija pieejama:${NC}"
echo "   http://localhost:8000"
echo ""
echo -e "${BLUE}📱 Admin panelis:${NC}"
echo "   http://localhost:8000/admin/settings"
echo ""
echo -e "${YELLOW}💡 Nospiediet Ctrl+C lai apturētu abus serverus${NC}"
echo "=============================================="
echo ""

# Wait for both processes
wait $VITE_PID $LARAVEL_PID

