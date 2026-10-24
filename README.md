# MyFushi

Japanese-first reference site for everyday home feng shui ([myfushi.com](https://myfushi.com)). The app is [CodeIgniter 4](https://codeigniter.com/) (PHP 8.2+, staging runs PHP 8.3). The web root is `public/`.

This repository is a skeleton: a home page, three tool stubs, disclaimer and privacy pages, and three content clusters with one sample article each (A7, B1, C1). Tool screens accept a form and echo it. They do not calculate a result. Every page says the content is reference only.

Branch `fe/myfushi-ci4-skeleton-20261022` is the frontend pass on `be/myfushi-ci4-skeleton-20261022`. This branch does not deploy. Production (`https://myfushi.com`) is out of scope. Staging, when someone deploys later, is [staging.myfushi.com](https://staging.myfushi.com).

## Routes

| Path | Page |
| --- | --- |
| `/` | Home |
| `/disclaimer` | 免責事項 |
| `/privacy` | プライバシー |
| `/tools/honmei-kichihoi` | 本命星／今年吉方位（GET form, POST echo） |
| `/tools/kichijitsu` | 吉日日暦（GET form, POST echo） |
| `/tools/kimon-qa` | 鬼門問答（GET form, POST echo） |
| `/genkan/` | 玄関 index |
| `/genkan/a7` | A7 玄関セルフチェックリスト |
| `/mizumawari/` | 水回り index |
| `/mizumawari/b1` | B1 トイレの位置と風水でよく聞く注意点 |
| `/hikkoshi/` | 引越 index |
| `/hikkoshi/c1` | C1 引越しの吉日の見方 |

The same pages answer without the trailing slash. Default locale is `ja`. HTML is `lang="ja"`.

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

Search indexing is open. `public/robots.txt` allows crawlers. Normal pages omit a robots meta tag and do not send `X-Robots-Tag`. `public/ads.txt` publishes the AdSense line, and the site layout loads AdSense Auto ads for myfushi.com. Stock error templates may still send `noindex`.

## Staging copy (do not run as a production deploy)

When someone later copies this tree to the staging host, the document root stays `public/`. Leave out `.git` and `.env`. `vendor/` can be uploaded, or installed on the server.

1. `composer install --no-dev --optimize-autoloader`
2. `cp env.example .env`, then set `CI_ENVIRONMENT = production` and `app.baseURL = 'https://staging.myfushi.com/'` (trailing slash).
3. Make `writable/` writable by the PHP user.
4. Confirm `public/robots.txt` allows crawlers and `public/ads.txt` is in `public/`.

```bash
rsync -av --exclude .git --exclude .env --exclude tests --exclude build \
  ./ USER@HOST:~/staging.myfushi.com/
```

## Tool contract

Forms POST back to the same path. The page echoes the input and shows 「結果＝参考・計算未實作」. There is no JSON API yet. Proposed shapes for a later API are in `docs/fe-api-contract-stub.md`. A GET with `submit=1` still hits the same controller.

## Content seed

`app/Database/Seeds/data/content-seed-stub.csv` is the outline for 玄関 / 水回り / 引越. Cluster index pages read it. Only A7, B1, and C1 have sample articles. Those bodies are short originals written for the site. Do not paste outside video scripts, captions, or covers into the site.
