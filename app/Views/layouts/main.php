<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title><?= esc($title) ?> | MyFushi</title>
    <link rel="stylesheet" href="<?= base_url('css/site.css') ?>">
</head>
<body>
    <a class="skip" href="#content">本文へ</a>
    <header class="site-header">
        <a class="brand" href="<?= site_url('/') ?>">MyFushi</a>
        <nav aria-label="テーマ">
            <a href="<?= site_url('genkan') ?>">玄関</a>
            <a href="<?= site_url('mizumawari') ?>">水回り</a>
            <a href="<?= site_url('hikkoshi') ?>">引越</a>
        </nav>
        <nav aria-label="ツール">
            <a href="<?= site_url('tools/honmei-kichihoi') ?>">本命星／今年吉方位</a>
            <a href="<?= site_url('tools/kichijitsu') ?>">吉日日暦</a>
            <a href="<?= site_url('tools/kimon-qa') ?>">鬼門問答</a>
        </nav>
    </header>
    <main id="content">
        <?= $this->renderSection('content') ?>
    </main>
    <footer class="site-footer">
        <p>MyFushi（myfushi.com）</p>
        <?= $this->include('partials/disclaimer') ?>
    </footer>
</body>
</html>
