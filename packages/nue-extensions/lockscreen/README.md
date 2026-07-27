Lock-Screen untuk Nue
======

Tambahkan halaman lock-screen ke aplikasi Nue kamu.

![ss-lockscreen](https://raw.githubusercontent.com/novay/imagehost/master/github/nue-extensions-lockscreen.png)

## Instalasi

```bash
composer require nue-extensions/lockscreen
```

Terus munculin menu Lock-Screen ini di sidebar Nue, eksekusi perintah berikut:

```bash
php artisan nue:import lock
```

## Konfigurasi

Tambahin middleware `nue.lock` di dalam file konfigurasi `config/nue.php` kayak gini:

```php

'route' => [

    'prefix' => 'nue',

    // Tambahin `nue.lock` disini
    'middleware'    => ['web', 'nue', 'nue.lock'],
],

```

## Penggunaan

Buat ngaktifin halaman lock-screen ini, coba klik pada menu Lock-Screen yang barusan di-install. Setelah dikunjungi, semua halaman dalam cakupan middleware `nue.lock` bakal ke-direct kehalaman Lockscreen sampai kamu masukin password kamu yang bener.

## Lisensi

**Lock-Screen** ini dikembangin dengan [Lisensi MIT](LICENSE.md). Artinya kamu bebas menggunakannya baik untuk kepentingan pribadi maupun komersil. Enjoy!