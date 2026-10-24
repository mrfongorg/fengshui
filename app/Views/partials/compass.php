<?php
$cx = 320.0;
$cy = 320.0;
$fmt = static function (float $n): string {
    return number_format($n, 1, '.', '');
};
$at = static function (float $angle, float $radius) use ($cx, $cy, $fmt): array {
    $rad = deg2rad($angle - 90.0);

    return [
        $fmt($cx + cos($rad) * $radius),
        $fmt($cy + sin($rad) * $radius),
    ];
};

$branches = ['子', '丑', '寅', '卯', '辰', '巳', '午', '未', '申', '酉', '戌', '亥'];
$stems    = [
    15  => '癸',
    75  => '甲',
    105 => '乙',
    165 => '丙',
    195 => '丁',
    255 => '庚',
    285 => '辛',
    345 => '壬',
];
$trigrams = [
    ['angle' => 0, 'name' => '坎', 'lines' => [0, 1, 0]],
    ['angle' => 45, 'name' => '艮', 'lines' => [1, 0, 0]],
    ['angle' => 90, 'name' => '震', 'lines' => [0, 0, 1]],
    ['angle' => 135, 'name' => '巽', 'lines' => [1, 1, 0]],
    ['angle' => 180, 'name' => '離', 'lines' => [1, 0, 1]],
    ['angle' => 225, 'name' => '坤', 'lines' => [0, 0, 0]],
    ['angle' => 270, 'name' => '兌', 'lines' => [0, 1, 1]],
    ['angle' => 315, 'name' => '乾', 'lines' => [1, 1, 1]],
];
?>
<svg class="luopan" viewBox="0 0 640 640" aria-hidden="true" focusable="false">
    <defs>
        <radialGradient id="luopan-glow" cx="50%" cy="50%" r="50%">
            <stop offset="0%" stop-color="#E8E4D8" stop-opacity="0.28"/>
            <stop offset="70%" stop-color="#E8E4D8" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="luopan-moon" cx="38%" cy="36%" r="68%">
            <stop offset="0%" stop-color="#F7F5F0"/>
            <stop offset="42%" stop-color="#D5DEEC"/>
            <stop offset="100%" stop-color="#8FA4C4"/>
        </radialGradient>
    </defs>

    <circle cx="320" cy="320" r="86" fill="url(#luopan-glow)"/>
    <circle cx="320" cy="320" r="308" fill="none" stroke="#C9A96A" stroke-opacity="0.28" stroke-width="1"/>
    <circle cx="320" cy="320" r="292" fill="none" stroke="#C9A96A" stroke-opacity="0.78" stroke-width="1.15"/>
    <circle cx="320" cy="320" r="268" fill="none" stroke="#C9A96A" stroke-opacity="0.45" stroke-width="0.8"/>
    <circle cx="320" cy="320" r="196" fill="none" stroke="#C9A96A" stroke-opacity="0.38" stroke-width="0.8"/>
    <circle cx="320" cy="320" r="150" fill="none" stroke="#C9A96A" stroke-opacity="0.5" stroke-width="0.8"/>
    <circle cx="320" cy="320" r="104" fill="none" stroke="#C9A96A" stroke-opacity="0.62" stroke-width="0.9"/>

    <g stroke="#C9A96A" stroke-linecap="square">
        <?php for ($deg = 0; $deg < 360; $deg += 3): ?>
            <?php
            $major = $deg % 30 === 0;
            $mid   = $deg % 15 === 0;
            $len   = $major ? 16 : ($mid ? 9 : 4.5);
            [$x1, $y1] = $at((float) $deg, 291);
            [$x2, $y2] = $at((float) $deg, 291 - $len);
            $opacity = $major ? '0.9' : '0.45';
            $width   = $major ? '1.15' : '0.6';
            ?>
            <line x1="<?= $x1 ?>" y1="<?= $y1 ?>" x2="<?= $x2 ?>" y2="<?= $y2 ?>" stroke-width="<?= $width ?>" stroke-opacity="<?= $opacity ?>"/>
        <?php endfor; ?>
    </g>

    <g fill="#E8E4D8" text-anchor="middle" dominant-baseline="middle" font-size="18" font-family="Shippori Mincho, Noto Serif CJK JP, serif">
        <?php foreach ($branches as $index => $branch): ?>
            <?php [$x, $y] = $at($index * 30, 250); ?>
            <text x="<?= $x ?>" y="<?= $y ?>"><?= $branch ?></text>
        <?php endforeach; ?>
    </g>

    <g fill="#C9A96A" text-anchor="middle" dominant-baseline="middle" font-size="13" font-family="Shippori Mincho, Noto Serif CJK JP, serif">
        <?php foreach ($stems as $angle => $stem): ?>
            <?php [$x, $y] = $at((float) $angle, 222); ?>
            <text x="<?= $x ?>" y="<?= $y ?>" fill-opacity="0.78"><?= $stem ?></text>
        <?php endforeach; ?>
    </g>

    <g fill="#E8E4D8" text-anchor="middle" dominant-baseline="middle" font-size="13" font-family="Shippori Mincho, Noto Serif CJK JP, serif">
        <?php foreach ($trigrams as $trigram): ?>
            <?php [$x, $y] = $at((float) $trigram['angle'], 172); ?>
            <text x="<?= $x ?>" y="<?= $y ?>" fill-opacity="0.8"><?= $trigram['name'] ?></text>
        <?php endforeach; ?>
    </g>

    <?php foreach ($trigrams as $trigram): ?>
        <g transform="rotate(<?= $trigram['angle'] ?> 320 320)" fill="none" stroke="#C9A96A" stroke-width="1.55">
            <g transform="translate(320 190)">
                <?php foreach ($trigram['lines'] as $i => $yang): ?>
                    <?php $y = -9 + ($i * 9); ?>
                    <?php if ($yang): ?>
                        <line x1="-13" y1="<?= $y ?>" x2="13" y2="<?= $y ?>"/>
                    <?php else: ?>
                        <line x1="-13" y1="<?= $y ?>" x2="-3.2" y2="<?= $y ?>"/>
                        <line x1="3.2" y1="<?= $y ?>" x2="13" y2="<?= $y ?>"/>
                    <?php endif; ?>
                <?php endforeach; ?>
            </g>
        </g>
    <?php endforeach; ?>

    <circle cx="320" cy="320" r="64" fill="url(#luopan-moon)"/>
    <circle cx="300" cy="308" r="8" fill="#AEBDCF" opacity="0.45"/>
    <circle cx="340" cy="334" r="4.5" fill="#C5D0E0" opacity="0.5"/>
    <circle cx="314" cy="344" r="2.6" fill="#9AADC4" opacity="0.45"/>
    <g stroke="#F4F1E6" stroke-width="0.7" opacity="0.9">
        <line x1="372" y1="268" x2="372" y2="286"/>
        <line x1="363" y1="277" x2="381" y2="277"/>
    </g>
    <circle cx="372" cy="277" r="1.35" fill="#F7F4EA"/>
</svg>
