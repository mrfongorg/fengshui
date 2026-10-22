<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<h1>吉日日暦</h1>
<?= $this->include('partials/ymyl_short') ?>
<p>用途と年月から、よく使われる暦の見方で候補日を絞り込む予定です。仕事の都合との両立が先です。いまは入力の受け付けだけです。</p>

<?php
$events = [
    'hikkoshi' => '引越し',
    'nyukyo'   => '入居・入宅',
    'keiyaku'  => '契約・鍵渡し',
];
?>
<form method="post" action="<?= site_url('tools/kichijitsu') ?>">
    <fieldset>
        <legend>用途</legend>
        <?php foreach ($events as $value => $label): ?>
            <label>
                <input type="radio" name="event" value="<?= esc($value) ?>" <?= $values['event'] === $value ? 'checked' : '' ?> required>
                <?= esc($label) ?>
            </label>
        <?php endforeach; ?>
        <?php if (isset($errors['event'])): ?>
            <p class="error"><?= esc($errors['event']) ?></p>
        <?php endif; ?>
    </fieldset>

    <label for="year">年</label>
    <input id="year" name="year" inputmode="numeric" value="<?= esc($values['year']) ?>" required>

    <label for="month">月</label>
    <select id="month" name="month" required>
        <option value="">選ぶ</option>
        <?php for ($month = 1; $month <= 12; $month++): ?>
            <option value="<?= $month ?>" <?= (string) $month === $values['month'] ? 'selected' : '' ?>><?= $month ?>月</option>
        <?php endfor; ?>
    </select>
    <?php if (isset($errors['year'])): ?>
        <p class="error"><?= esc($errors['year']) ?></p>
    <?php endif; ?>
    <?php if (isset($errors['month'])): ?>
        <p class="error"><?= esc($errors['month']) ?></p>
    <?php endif; ?>

    <button type="submit" name="submit" value="1">候補を見る</button>
</form>

<?php if ($accepted): ?>
    <section class="result" aria-live="polite">
        <h2>結果（プレースホルダ）</h2>
        <?= $this->include('partials/result_status') ?>
        <p>条件は受け付けました（<?= esc($events[$values['event']] ?? '') ?>、<?= esc($values['year']) ?>年<?= esc($values['month']) ?>月）。</p>
        <p>吉日の一覧と注意事項の計算はまだ実装していません。日取りの最終決定には使わないでください。</p>
    </section>
<?php endif; ?>
<?= $this->endSection() ?>
