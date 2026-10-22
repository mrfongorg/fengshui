<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<h1>鬼門問答</h1>
<?= $this->include('partials/ymyl_short') ?>
<p>鬼門（北東）・裏鬼門側に、何をどれだけ置くかの簡易な確認を返す予定です。いまは質問の受け付けだけです。方位が分からないときは「わからない」を選んでください。</p>

<?php
$questions = [
    'entrance'  => '玄関は鬼門（北東）側にありますか',
    'water'     => 'トイレや浴室は鬼門側にありますか',
    'furniture' => '鬼門側に大きな家具を置く予定はありますか',
];
$choices = [
    'yes'     => 'はい',
    'no'      => 'いいえ',
    'unknown' => 'わからない',
];
?>
<form method="post" action="<?= site_url('tools/kimon-qa') ?>">
    <?php foreach ($questions as $name => $label): ?>
        <fieldset>
            <legend><?= esc($label) ?></legend>
            <?php foreach ($choices as $value => $choiceLabel): ?>
                <label>
                    <input type="radio" name="<?= esc($name) ?>" value="<?= esc($value) ?>" <?= $values[$name] === $value ? 'checked' : '' ?> required>
                    <?= esc($choiceLabel) ?>
                </label>
            <?php endforeach; ?>
            <?php if (isset($errors[$name])): ?>
                <p class="error"><?= esc($errors[$name]) ?></p>
            <?php endif; ?>
        </fieldset>
    <?php endforeach; ?>
    <button type="submit" name="submit" value="1">確認する</button>
</form>

<?php if ($accepted): ?>
    <section class="result" aria-live="polite">
        <h2>結果（プレースホルダ）</h2>
        <?= $this->include('partials/result_status') ?>
        <ul>
            <?php foreach ($questions as $name => $label): ?>
                <li><?= esc($label) ?>：<?= esc($choices[$values[$name]] ?? '') ?></li>
            <?php endforeach; ?>
        </ul>
        <p>鬼門方位の簡易判定と注意リストはまだ実装していません。はい／いいえを吉凶の答えとして読まないでください。</p>
    </section>
<?php endif; ?>
<?= $this->endSection() ?>
