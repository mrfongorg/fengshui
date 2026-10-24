<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="home">
    <section class="hero" aria-labelledby="hero-title">
        <div class="hero-panel">
            <h1 id="hero-title">玄關の第一印象</h1>
            <p class="hero-lead">快適な気の流れで、<br>あなたの生活をサポート。</p>
            <a class="button-link" href="#tools">ツールを試す</a>
        </div>
        <div class="compass">
            <?= $this->include('partials/compass') ?>
        </div>
    </section>

    <?php
    /*
     * One manual AdSense reserve, directly under the hero and before the tool cards.
     * Publisher ca-pub-3320427785368951 is already listed in ads.txt.
     * data-ad-slot stays empty until AdSense approval. Do not request a creative before then.
     * After approval: set data-ad-slot, drop aria-hidden, and enable this loader only:
     * <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3320427785368951" crossorigin="anonymous"></script>
     * <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-3320427785368951" data-ad-slot="SLOT_ID_AFTER_APPROVAL" data-ad-format="horizontal" data-full-width-responsive="true"></ins>
     * <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
     */
    ?>
    <aside class="ad-reserve" data-ad-client="ca-pub-3320427785368951" data-ad-slot="" data-ad-format="horizontal" data-full-width-responsive="true" aria-hidden="true"></aside>

    <div class="rule" aria-hidden="true">
        <span></span>
        <svg viewBox="0 0 24 24" focusable="false">
            <circle cx="12" cy="12" r="4.25" fill="none" stroke="currentColor" stroke-width="1"/>
        </svg>
        <span></span>
    </div>

    <section class="tool-board" id="tools" aria-label="ツール">
        <a class="tool-card" href="<?= site_url('tools/honmei-kichihoi') ?>">
            <?= $this->include('partials/seal') ?>
            <svg class="mark" viewBox="0 0 64 64" aria-hidden="true" focusable="false">
                <circle cx="32" cy="32" r="16" fill="none" stroke="currentColor" stroke-width="1.3"/>
            </svg>
            <span class="tool-card-title">本命星</span>
            <span class="tool-card-note">生まれ年からの見方</span>
        </a>
        <a class="tool-card" href="<?= site_url('tools/honmei-kichihoi') ?>">
            <?= $this->include('partials/seal') ?>
            <svg class="mark" viewBox="0 0 64 64" aria-hidden="true" focusable="false">
                <circle cx="32" cy="32" r="15.5" fill="none" stroke="currentColor" stroke-width="1.2"/>
                <path fill="currentColor" d="M32 16.5a15.5 15.5 0 0 1 0 31 7.75 7.75 0 0 1 0-15.5 7.75 7.75 0 0 0 0-15.5z"/>
                <circle cx="32" cy="24.25" r="2.15" fill="#0B1220"/>
                <circle cx="32" cy="39.75" r="2.15" fill="currentColor"/>
            </svg>
            <span class="tool-card-title">吉方位</span>
            <span class="tool-card-note">今年の方位</span>
        </a>
        <a class="tool-card" href="<?= site_url('tools/kichijitsu') ?>">
            <?= $this->include('partials/seal') ?>
            <svg class="mark" viewBox="0 0 64 64" aria-hidden="true" focusable="false">
                <path d="M14 44c6-8 12-8 18 0s12 8 18 0" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                <path d="M10 33c8-10 15-10 22 0s14 10 22 0" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                <path d="M6 22c10-12 19-12 26 0s16 12 26 0" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
            </svg>
            <span class="tool-card-title">吉日カレンダー</span>
            <span class="tool-card-note">日取りの参考</span>
        </a>
    </section>
</div>
<?= $this->endSection() ?>
