#!/usr/bin/env sh
# Build creadigol.zip from the theme folder. Includes fonts if they are present locally.
set -e
cd "$(dirname "$0")/../wp-content/themes"
rm -f ../../creadigol.zip
zip -rq ../../creadigol.zip creadigol -x "creadigol/README.md" -x "*/.DS_Store"
echo "Wrote creadigol.zip ($(du -h ../../creadigol.zip | cut -f1))"
