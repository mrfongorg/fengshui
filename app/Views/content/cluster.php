<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<p class="crumbs"><a href="<?= site_url('/') ?>">ホーム</a> / <?= esc($cluster['title']) ?></p>
<h1><?= esc($cluster['title']) ?></h1>
<?= $this->include('partials/ymyl_short') ?>
<p class="lead"><?= esc($cluster['summary']) ?></p>
<p>公開しているのはサンプル 1 本です。ほかの見出しは目次だけです。</p>

<ul class="tool-list">
    <?php foreach ($cluster['items'] as $item): ?>
        <li>
            <span class="seed-id"><?= esc($item['id']) ?></span>
            <?php if ($item['published']): ?>
                <a href="<?= site_url($cluster['key'] . '/' . $item['slug']) ?>"><?= esc($item['title']) ?></a>
                <span class="tag">サンプル</span>
            <?php else: ?>
                <span class="pending-title"><?= esc($item['title']) ?></span>
                <span class="tag">準備中</span>
            <?php endif; ?>
            <?php if ($item['tool_label'] !== ''): ?>
                <span>関連ツール: <a href="<?= site_url($item['tool_path']) ?>"><?= esc($item['tool_label']) ?></a></span>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>
<?= $this->endSection() ?>
