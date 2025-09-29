#!/bin/sh

if [ ! -d "node_modules" ] || [ ! -f "node_modules/.bin/nuxt" ]; then
  echo "Instalando dependências..."
  npm install
fi

exec "$@"
