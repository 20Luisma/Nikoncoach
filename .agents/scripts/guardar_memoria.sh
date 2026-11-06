#!/bin/bash
# Script de backup inmutable con timestamp para MEMORY.md de NikonCoach
set -e

DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
TIMESTAMP=$(date +"%Y-%m-%d_%H-%M")
BACKUP_DIR="$DIR/memory_backups"
BACKUP_FILE="$BACKUP_DIR/MEMORY_$TIMESTAMP.md"

mkdir -p "$BACKUP_DIR"
cp "$DIR/MEMORY.md" "$BACKUP_FILE"

echo "✅ Backup guardado en: memory_backups/MEMORY_$TIMESTAMP.md"

