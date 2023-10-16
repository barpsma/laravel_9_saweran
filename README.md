<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Project

project sederhana penerapan payment gateway midtrans di laravel 9

Simple project implementing MidTrans payment gateway in Laravel 9

## Demo

![1](https://github.com/barpsma/laravel_9_saweran/blob/main/ss/1.PNG?raw=true)

## Installation

Clone this repo

```bash
git clone
```

Open directory

```bash
cd nyawer
```

configure .env

```bash
cp .env.example .env
```

```bash
nano .env
```

run migrate

```bash
php artisan migrate
```

run app

```bash
php artisan serve
```

setting ngrok
example :

```bash
ngrok http 127.0.0.1:8000
```

copy forwarded url to configurations midtrans in your account

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
