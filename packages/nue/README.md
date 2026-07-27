# Nue Boilerplate

[![Packagist](https://img.shields.io/packagist/l/novay/nue.svg?maxAge=2592000)](https://packagist.org/packages/novay/nue)
[![Total Downloads](https://img.shields.io/packagist/dt/novay/nue.svg?style=flat-square)](https://packagist.org/packages/novay/nue)
[![Pull request welcome](https://img.shields.io/badge/pr-welcome-green.svg?style=flat-square)]()


[Baca Dokumentasi Disini](https://nue.btekno.id/docs)

## Screenshot

![nue-package.png](https://raw.githubusercontent.com/novay/imagehost/master/nue-package.png)

## Documentation

- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Components](#components)
    - [Alert](#alert)
- [License](#license)

## Requirements

- Laravel
- Iconify must be called to use icons, simply use CDN

## Installation

Require the package via composer:


```bash
composer require novay/nue -vvv
```

Install with:

```bash
php artisan nue:install --force
```

And you are ready to go!

## Configuration

Make sure to check out our config files at `config/nue.php`. Here you can :
- Change the default application name
- Customize brands or assets files like favicon and the application logo.
- Disable some built in features like `registration`, `account deletion` etcetera.
- And others configurations which you can play with.

## Components (Coming Soon! Unstable)

### Alert

A Nue alert:

```html
<x-nue::alert
    :label="__('It was successful!')"
    color="info"
    dismissible
/>
```

#### Available Props & Slots

- `icon`: Iconify icon to show before label e.g. `icon-park-twotone:add-one`, `heroicons-solid:badge-check`
- `label`: label to display, can also be placed in the `slot`
- `color`: Available color e.g. `primary`, `danger`, `success`, `warning`, `soft-*`
- `dismissible`: set the alert to be dismissible

---

...

License
------------
Licensed under [The MIT License (MIT)](LICENSE).