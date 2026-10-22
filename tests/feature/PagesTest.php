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
        $result->assertSee('lang="ja"');
        $result->assertSee('noindex');
        $result->assertHeader('X-Robots-Tag', 'noindex, nofollow');
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
}
