<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<h1>ページが見つかりません</h1>
<p>指定されたページはありません。<a href="<?= site_url('/') ?>">MyFushi のホーム</a>へ戻ってください。</p>
<?= $this->endSection() ?>
