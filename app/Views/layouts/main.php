<?php
$documentTitle = trim((string) ($title ?? ''));

if ($documentTitle === '') {
    $documentTitle = 'MyFushi';
} elseif (! str_ends_with($documentTitle, 'MyFushi')) {
    $documentTitle .= ' | MyFushi';
}

$metaDescription = trim((string) ($description ?? ''));
$canonicalUrl    = trim((string) ($canonical ?? ''));
$robotsContent   = trim((string) ($robots ?? ''));
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($documentTitle) ?></title>
<?php if ($metaDescription !== ''): ?>
    <meta name="description" content="<?= esc($metaDescription) ?>">
<?php endif; ?>
<?php if ($canonicalUrl !== ''): ?>
    <link rel="canonical" href="<?= esc($canonicalUrl) ?>">
<?php endif; ?>
<?php if ($robotsContent !== ''): ?>
    <meta name="robots" content="<?= esc($robotsContent) ?>">
<?php endif; ?>
<?php if ($canonicalUrl !== ''): ?>
    <meta property="og:title" content="<?= esc($documentTitle) ?>">
<?php if ($metaDescription !== ''): ?>
    <meta property="og:description" content="<?= esc($metaDescription) ?>">
<?php endif; ?>
    <meta property="og:url" content="<?= esc($canonicalUrl) ?>">
<?php endif; ?>
    <link rel="preload" href="<?= base_url('fonts/shippori-mincho-500-japanese.woff2') ?>" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="<?= base_url('css/site.css') ?>">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3320427785368951" crossorigin="anonymous"></script>
</head>
<body>
    <div class="sky" aria-hidden="true"></div>
    <a class="skip" href="#content">本文へ</a>
    <header class="site-header">
        <a class="brand" href="<?= site_url('/') ?>">MyFushi</a>
        <nav class="site-nav" aria-label="主なページ">
            <a href="<?= site_url('tools/honmei-kichihoi') ?>">本命星</a>
            <span class="nav-sep" aria-hidden="true">/</span>
            <a href="<?= site_url('tools/kichijitsu') ?>">吉日</a>
            <span class="nav-sep" aria-hidden="true">/</span>
            <a href="<?= site_url('tools/kimon-qa') ?>">鬼門Q&A</a>
            <span class="nav-sep" aria-hidden="true">/</span>
            <a href="#articles">記事</a>
        </nav>
    </header>
    <main id="content">
        <?= $this->renderSection('content') ?>
    </main>
    <footer class="site-footer">
        <p class="footer-mark" aria-hidden="true">
            <svg viewBox="0 0 80 80" focusable="false">
                <polygon points="40,14 65.4,32.5 55.7,62.5 24.3,62.5 14.6,32.5" fill="none" stroke="currentColor" stroke-width="0.9"/>
                <circle cx="40" cy="14" r="2.15" fill="currentColor"/>
                <circle cx="65.4" cy="32.5" r="2.15" fill="currentColor"/>
                <circle cx="55.7" cy="62.5" r="2.15" fill="currentColor"/>
                <circle cx="24.3" cy="62.5" r="2.15" fill="currentColor"/>
                <circle cx="14.6" cy="32.5" r="2.15" fill="currentColor"/>
            </svg>
        </p>
        <p class="footer-brand">MyFushi</p>
        <nav class="quiet-nav" id="articles" aria-label="記事">
            <a href="<?= site_url('genkan') ?>">玄関</a>
            <span class="nav-sep" aria-hidden="true">/</span>
            <a href="<?= site_url('mizumawari') ?>">水回り</a>
            <span class="nav-sep" aria-hidden="true">/</span>
            <a href="<?= site_url('hikkoshi') ?>">引越</a>
        </nav>
        <p class="footer-domain">MyFushi（myfushi.com）</p>
        <?= $this->include('partials/disclaimer') ?>
    </footer>
</body>
</html>
