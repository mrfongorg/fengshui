<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php
$item   = $article['item'];
$sample = $article['sample'];
?>
<p class="crumbs">
    <a href="<?= site_url('/') ?>">ホーム</a>
    /
    <a href="<?= site_url($article['cluster_key']) ?>"><?= esc($article['cluster_title']) ?></a>
    /
    <?= esc($item['id']) ?>
</p>
<p class="tag">サンプル下書き <?= esc($item['id']) ?></p>
<h1><?= esc($item['title']) ?></h1>
<?= $this->include('partials/ymyl_short') ?>
<p class="lead"><?= esc($sample['dek']) ?></p>

<?php foreach ($sample['sections'] as $section): ?>
    <section>
        <h2><?= esc($section['h2']) ?></h2>
        <?php foreach ($section['paragraphs'] as $paragraph): ?>
            <p><?= esc($paragraph) ?></p>
        <?php endforeach; ?>
        <?php if (! empty($section['items'])): ?>
            <ul class="checklist">
                <?php foreach ($section['items'] as $line): ?>
                    <li><?= esc($line) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>
<?php endforeach; ?>

<aside class="cta">
    <h2>ツールで受け付ける</h2>
    <p>計算はまだ実装していません。入力の確認だけが返ります。</p>
    <?php if ($item['tool_label'] !== ''): ?>
        <p><a class="button-link" href="<?= site_url($item['tool_path']) ?>"><?= esc($item['tool_label']) ?></a></p>
    <?php endif; ?>
    <?php if (! empty($sample['secondary_path'])): ?>
        <p>あわせて見る: <a href="<?= site_url($sample['secondary_path']) ?>"><?= esc($sample['secondary_label']) ?></a></p>
    <?php endif; ?>
    <p><a href="<?= site_url('disclaimer') ?>">免責事項を読む</a></p>
</aside>
<?= $this->endSection() ?>
