<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */
final class PagesTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testHome(): void
    {
        $result = $this->get('/');

        $result->assertOK();
        $result->assertSee('MyFushi');
        $result->assertSee('玄關の第一印象');
        $result->assertSee('ツールを試す');
        $result->assertSee('吉方位');
        $result->assertSee('吉日カレンダー');
        $result->assertSee('tools/honmei-kichihoi');
        $result->assertSee('tools/kichijitsu');
        $result->assertDontSee('住まいの整え方を、参考情報として届けるサイトです');
        $result->assertSee('lang="ja"');
        $result->assertSee('noindex');
        $result->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function testHomeReservesOneAdSlotUnderHero(): void
    {
        $result = $this->get('/');

        $result->assertOK();
        $body = (string) $result->response()->getBody();

        $this->assertSame(1, substr_count($body, 'class="ad-reserve"'));
        $this->assertSame(1, substr_count($body, 'data-ad-client="ca-pub-3320427785368951"'));
        $this->assertStringContainsString('data-ad-slot=""', $body);
        $this->assertStringContainsString('data-ad-format="horizontal"', $body);
        $this->assertStringNotContainsString('adsbygoogle', $body);
        $this->assertStringNotContainsString('pagead2.googlesyndication.com', $body);
        $this->assertStringNotContainsString('鳴鳳', $body);
        $this->assertStringNotContainsString('MINGFONG', $body);

        $hero = strpos($body, 'id="hero-title"');
        $slot = strpos($body, 'class="ad-reserve"');
        $tools = strpos($body, 'id="tools"');
        $this->assertNotFalse($hero);
        $this->assertNotFalse($slot);
        $this->assertNotFalse($tools);
        $this->assertGreaterThan($hero, $slot);
        $this->assertLessThan($tools, $slot);

        $tool = (string) $this->get('/tools/kichijitsu')->response()->getBody();
        $this->assertStringNotContainsString('ad-reserve', $tool);

        $css = file_get_contents(PUBLICPATH . 'css/site.css');
        $this->assertMatchesRegularExpression('/\.ad-reserve\s*\{[^}]*min-height:\s*90px/s', $css);
        $this->assertMatchesRegularExpression('/\.ad-reserve\s*\{[^}]*background:\s*var\(--bg-0\)/s', $css);
        $this->assertMatchesRegularExpression('/\.ad-reserve\s*\{[^}]*border:\s*1px solid var\(--gold\)/s', $css);
        $this->assertStringContainsString('.ad-reserve[data-ad-slot=""]::before', $css);
        $this->assertSame(1, preg_match_all('/min-height:\s*90px/', $css));
    }

    public function testHonmeiStub(): void
    {
        $result = $this->get('/tools/honmei-kichihoi');

        $result->assertOK();
        $result->assertSee('本命星／今年吉方位');
        $result->assertSee('参考');
        $result->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function testHonmeiAcceptsYearWithoutCalculating(): void
    {
        $result = $this->get('/tools/honmei-kichihoi?birth_year=1990&submit=1');

        $result->assertOK();
        $result->assertSee('結果（プレースホルダ）');
        $result->assertSee('1990');
    }

    public function testHonmeiRejectsBadYear(): void
    {
        $result = $this->get('/tools/honmei-kichihoi?birth_year=abc&submit=1');

        $result->assertOK();
        $result->assertSee('西暦の数字');
        $result->assertDontSee('結果（プレースホルダ）');
    }

    public function testKichijitsuStub(): void
    {
        $result = $this->get('/tools/kichijitsu');

        $result->assertOK();
        $result->assertSee('吉日日暦');
        $result->assertSee('参考');
    }

    public function testKichijitsuAcceptsFilter(): void
    {
        $result = $this->get('/tools/kichijitsu?event=hikkoshi&year=2026&month=4&submit=1');

        $result->assertOK();
        $result->assertSee('結果（プレースホルダ）');
        $result->assertSee('引越し');
    }

    public function testKimonStub(): void
    {
        $result = $this->get('/tools/kimon-qa');

        $result->assertOK();
        $result->assertSee('鬼門問答');
        $result->assertSee('参考');
    }

    public function testKimonAcceptsAnswersWithoutJudgement(): void
    {
        $result = $this->get('/tools/kimon-qa?entrance=unknown&water=no&furniture=yes&submit=1');

        $result->assertOK();
        $result->assertSee('結果（プレースホルダ）');
        $result->assertSee('吉凶の答えとして読まない');
    }

    public function testUnknownRouteIsJapanese404(): void
    {
        $result = $this->get('/missing');

        $result->assertStatus(404);
        $result->assertSee('ページが見つかりません');
        $result->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function testHonmeiPostEchoesInputWithoutCalculation(): void
    {
        $result = $this->post('/tools/honmei-kichihoi', [
            'birth_year' => '1990',
            'submit'     => '1',
        ]);

        $result->assertOK();
        $result->assertSee('結果（プレースホルダ）');
        $result->assertSee('結果＝参考・計算未實作');
        $result->assertSee('1990');
        $result->assertSee('method="post"');
    }

    public function testHonmeiPostRejectsBadYear(): void
    {
        $result = $this->post('/tools/honmei-kichihoi', [
            'birth_year' => 'abc',
            'submit'     => '1',
        ]);

        $result->assertOK();
        $result->assertSee('西暦の数字');
        $result->assertDontSee('結果（プレースホルダ）');
        $result->assertDontSee('結果＝参考・計算未實作');
    }

    public function testKichijitsuPostEchoesFilter(): void
    {
        $result = $this->post('/tools/kichijitsu', [
            'event'  => 'nyukyo',
            'year'   => '2026',
            'month'  => '11',
            'submit' => '1',
        ]);

        $result->assertOK();
        $result->assertSee('結果＝参考・計算未實作');
        $result->assertSee('入居・入宅');
        $result->assertSee('2026');
    }

    public function testKimonPostEchoesAnswers(): void
    {
        $result = $this->post('/tools/kimon-qa', [
            'entrance'  => 'yes',
            'water'     => 'unknown',
            'furniture' => 'no',
            'submit'    => '1',
        ]);

        $result->assertOK();
        $result->assertSee('結果＝参考・計算未實作');
        $result->assertSee('吉凶の答えとして読まない');
        $result->assertSee('わからない');
    }

    public function testDisclaimerAndPrivacy(): void
    {
        $disclaimer = $this->get('/disclaimer');
        $disclaimer->assertOK();
        $disclaimer->assertSee('免責事項');
        $disclaimer->assertSee('MyFushi');
        $disclaimer->assertSee('lang="ja"');

        $privacy = $this->get('/privacy/');
        $privacy->assertOK();
        $privacy->assertSee('プライバシー');
        $privacy->assertSee('いまのサイトではデータベースへ保存しません');
    }

    public function testClusterIndexesAndSamples(): void
    {
        $pages = [
            '/genkan'         => '玄関セルフチェックリスト',
            '/genkan/'        => '準備中',
            '/genkan/a7'      => 'サンプル下書き',
            '/mizumawari'     => 'トイレの位置と風水でよく聞く注意点',
            '/mizumawari/b1/' => '鬼門問答',
            '/hikkoshi/'      => '引越しの吉日の見方',
            '/hikkoshi/c1'    => '吉日は決定ではない',
        ];

        foreach ($pages as $path => $needle) {
            $result = $this->get($path);
            $result->assertOK();
            $result->assertSee('MyFushi');
            $result->assertSee($needle);
            $result->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        }
    }

    public function testUnpublishedOutlineIsJapanese404(): void
    {
        $result = $this->get('/genkan/a1');

        $result->assertStatus(404);
        $result->assertSee('ページが見つかりません');
    }

    public function testPagesDoNotUseRetiredNames(): void
    {
        foreach (['/', '/disclaimer', '/privacy', '/genkan/a7', '/mizumawari/b1', '/hikkoshi/c1', '/tools/honmei-kichihoi'] as $path) {
            $body = (string) $this->get($path)->response()->getBody();
            foreach (['MINGFONG', '鳴鳳', '鸣凤', '阴盘奇门遁甲', '陰盤奇門遁甲', '風水日站'] as $retired) {
                $this->assertStringNotContainsString($retired, $body, $path . ' contains ' . $retired);
            }
        }
    }
}
