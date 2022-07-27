# Notes
Notes adalah aplikasi catatan
Develop by Vembri Riyan Diansah, S.Tr.Kom
Github : https://github.com/vembririyan/Notes

Library dan Framework yang digunakan pada aplikasi ini
- Framework Codeigniter v4.2.1
- Tailwind CSS
- Vanilla Js

Cara Install Lewat Zip/Rar
1. Siapkan file dengan mendownloadnya dari repository, kemudian extract file rar/zip ke folder yang dituju
2. Siapkan database dengan nama 'notes' (atau bisa kalian kasih nama sendiri)
3. Buka folder Notes
4. Buka Terminal/ Command Line Interface yang kalian punya (Saya pakai Terminalnya Git, bisa kalian download di https://git-scm.com/downloads )
5. Untuk migrate tabel database yang sudah ada pada aplikasi, gunakan perintah 'php spark migrate' (command lainnya yang di sediakan CI bisa kalian lihat dengan mengetik 'php spark'
6. Jika sudah jalankan aplikasi dengan perintah/command 'php spark serve' atau jika kalian menaruh aplikasi di htdocs bisa kalian akses dengan' http://localhost/nama_folder_aplikasi/public


Cara Install Lewat Git
1. Ketikkan perintah pada Terminal 'git clone https://github.com/vembririyan/Notes'
2. Siapkan database dengan nama 'notes' (atau bisa kalian kasih nama sendiri)
3. Buka folder Notes / folder dari hasil clone
4. Buka Terminal/ Command Line Interface yang kalian punya (Saya pakai Terminalnya Git, bisa kalian download di https://git-scm.com/downloads )
5. Untuk migrate tabel database yang sudah ada pada aplikasi, gunakan perintah 'php spark migrate' (command lainnya yang di sediakan CI bisa kalian lihat dengan mengetik 'php spark'
6. Jika sudah jalankan aplikasi dengan perintah/command 'php spark serve' atau jika kalian menaruh aplikasi di htdocs bisa kalian akses dengan' http://localhost/nama_folder_aplikasi/public


Catatan: 
- Jika kalian memiliki nama folder yang berbeda jangan lupa ubah Base Url nya di app/Config/App.php
- Jika kalian memiliki nama database yang berbeda ubah database di app/Config/Database.php

Atau bisa juga diatur melalui file env

Happy Coding :sunglasses:
