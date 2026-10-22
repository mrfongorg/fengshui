<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<h1>MyFushi</h1>
<p class="lead">住まいの整え方を、参考情報として届けるサイトです。玄関・水回り・引越の三つのテーマと、三つのツールを準備しています。</p>

<section>
    <h2>テーマ</h2>
    <ul>
        <li>玄関 — 入口の動線、明るさ、置き方</li>
        <li>水回り — トイレ、浴室、キッチン、洗面所</li>
        <li>引越 — 日取り、入居、新居で最初にすること</li>
    </ul>
    <p>各テーマの記事はこれからです。ツールの結果も、いまは受け付けの確認だけです。</p>
</section>

<section>
    <h2>ツール</h2>
    <ul class="tool-list">
        <li>
            <a href="<?= site_url('tools/honmei-kichihoi') ?>">本命星／今年吉方位</a>
            <span>生まれ年から、今年の方位の見方へ（準備中）</span>
        </li>
        <li>
            <a href="<?= site_url('tools/kichijitsu') ?>">吉日日暦</a>
            <span>引越し・入居・契約の日取りを絞り込む画面（準備中）</span>
        </li>
        <li>
            <a href="<?= site_url('tools/kimon-qa') ?>">鬼門問答</a>
            <span>鬼門側の置き方を、はい／いいえで確認する画面（準備中）</span>
        </li>
    </ul>
</section>
<?= $this->endSection() ?>
