#!/bin/bash
# Jalankan script ini SETELAH DNS biaraloresa.my.id mengarah ke server
# Pastikan A record: biaraloresa.my.id dan www.biaraloresa.my.id -> IP server Anda

sudo certbot --nginx -d biaraloresa.my.id -d www.biaraloresa.my.id --non-interactive --agree-tos --email admin@biaraloresa.my.id --redirect

echo ""
echo "SSL berhasil! Situs tersedia di https://biaraloresa.my.id"
