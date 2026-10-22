<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<h1>本命星／今年吉方位</h1>
<p>生まれ年（西暦）を入れると、本命星と今年の吉方位・凶方位、家のどこに効くかの短いメモを返す予定です。いまは入力の受け付けだけです。</p>

<form method="get" action="<?= site_url('tools/honmei-kichihoi') ?>">
    <label for="birth_year">生まれ年（西暦）</label>
    <input id="birth_year" name="birth_year" inputmode="numeric" autocomplete="bday-year" value="<?= esc($values['birth_year']) ?>" required>
    <?php if (isset($errors['birth_year'])): ?>
        <p class="error"><?= esc($errors['birth_year']) ?></p>
    <?php endif; ?>
    <button type="submit" name="submit" value="1">参考として見る</button>
</form>

<?php if ($accepted): ?>
    <section class="result" aria-live="polite">
        <h2>結果（プレースホルダ）</h2>
        <p>入力された生まれ年：<?= esc($values['birth_year']) ?>年。</p>
        <p>本命星、今年の吉方位・凶方位、「家のどこに効くか」の計算はまだ実装していません。ここに出る内容は参考用の枠だけです。</p>
    </section>
<?php endif; ?>
<?= $this->endSection() ?>
