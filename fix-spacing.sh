#!/bin/bash
find frontend/mfp-app/src -name "*.vue" -o -name "*.ts" | while read file; do
  sed -i 's/  /    /g' "$file"
done
