# MyFushi

Japanese-first reference site for everyday home feng shui ([myfushi.com](https://myfushi.com)). The app is [CodeIgniter 4](https://codeigniter.com/) (PHP 8.2+, staging runs PHP 8.3). The web root is `public/`.

This repository is a skeleton: a home page and three tool stubs. Article bodies are not written yet. Tool screens accept input and stop there. They do not calculate a result. Every page says the content is reference only.

## Routes

| Path | Page |
| --- | --- |
| `/` | Home |
| `/tools/honmei-kichihoi` | 本命星／今年吉方位 |
| `/tools/kichijitsu` | 吉日日暦 |
| `/tools/kimon-qa` | 鬼門問答 |

Default locale is `ja`. HTML is `lang="ja"`.

## Run locally

Requirements: PHP 8.2 or newer (with `intl`, `mbstring`, `xml`), Composer 2.

```bash
composer install
cp env.example .env
php spark serve
```

Open <http://localhost:8080/>.

`env.example` has placeholders only. Do not commit `.env`. Do not put passwords, API tokens, or an encryption key in git. On a server, set `CI_ENVIRONMENT = production` and set `app.baseURL` to that site's origin (trailing slash). Generate an encryption key on the server with `php spark key:generate` when you actually need one.

```bash
composer test
```

## Hostinger document root

The domain document root must be this app's `public/` directory (`public/index.php` is the front controller). Do not point the domain at the repository root. `app/`, `.env`, `writable/`, and `vendor/` must not be served as static files.

For staging (`https://staging.myfushi.com`), when this project is deployed later, set that site's document root to `public/`. If the project tree is uploaded into the current Hostinger web folder, change the document root from that folder to its `public/` subdirectory.

This branch does not deploy. Production (`https://myfushi.com`) is out of scope.

Stub responses send `X-Robots-Tag: noindex, nofollow`, a matching robots meta tag, and `public/robots.txt` disallows all crawlers. Remove those three before a public launch.

## Content seed

`app/Database/Seeds/data/content-seed-stub.csv` lists outline topics for 玄関 / 水回り / 引越. It is not imported and not rendered. Write page copy for the site itself. Do not paste outside video scripts, captions, or covers into the site.
