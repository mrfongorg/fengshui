<?php

use App\Libraries\PublicPages;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */
final class SeoTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testInventoryCoversPublicPagesOnce(): void
    {
        $pages = (new PublicPages())->all();
        $paths = array_column($pages, 'path');

        $this->assertSame([
            '/',
            'tools/honmei-kichihoi',
            'tools/kichijitsu',
            'tools/kimon-qa',
            'genkan',
            'genkan/a7',
            'mizumawari',
            'mizumawari/b1',
            'hikkoshi',
            'hikkoshi/c1',
            'disclaimer',
            'privacy',
        ], $paths);

        $titles       = array_column($pages, 'title');
        $descriptions = array_column($pages, 'description');

        $this->assertSame($titles, array_unique($titles));
        $this->assertSame($descriptions, array_unique($descriptions));

        $copy = implode("\n", array_merge($titles, $descriptions));

        foreach (['玄関', '水回り', '引越', '本命星', '吉日', '鬼門'] as $keyword) {
            $this->assertStringContainsString($keyword, $copy);
        }

        foreach ($descriptions as $description) {
            $this->assertNotSame('', $description);
            $this->assertStringNotContainsString('鳴鳳', $description);
            $this->assertStringNotContainsString('MINGFONG', $description);
        }
    }

    public function testEachPublicPageHasUniqueHead(): void
    {
        foreach ((new PublicPages())->all() as $page) {
            $result = $this->get($page['path'] === '/' ? '/' : '/' . $page['path']);
            $result->assertOK();

            $body      = (string) $result->response()->getBody();
            $title     = $page['title'] . ' | MyFushi';
            $canonical = PublicPages::absolute($page['path']);

            $this->assertStringContainsString('<title>' . $title . '</title>', $body, $page['path']);
            $this->assertStringContainsString(
                '<meta name="description" content="' . $page['description'] . '">',
                $body,
                $page['path'],
            );
            $this->assertStringContainsString(
                '<link rel="canonical" href="' . $canonical . '">',
                $body,
                $page['path'],
            );
            $this->assertStringContainsString(
                '<meta property="og:title" content="' . $title . '">',
                $body,
                $page['path'],
            );
            $this->assertStringContainsString(
                '<meta property="og:description" content="' . $page['description'] . '">',
                $body,
                $page['path'],
            );
            $this->assertStringContainsString(
                '<meta property="og:url" content="' . $canonical . '">',
                $body,
                $page['path'],
            );
            $this->assertStringNotContainsString('noindex', $body, $page['path']);
            $this->assertStringNotContainsString('nofollow', $body, $page['path']);
            $this->assertStringNotContainsString('application/ld+json', $body, $page['path']);
            $this->assertSame('', $result->response()->getHeaderLine('X-Robots-Tag'), $page['path']);
        }
    }

    public function testToolResultKeepsCleanCanonical(): void
    {
        $result = $this->get('/tools/honmei-kichihoi?birth_year=1990&submit=1');

        $result->assertOK();
        $body = (string) $result->response()->getBody();

        $this->assertStringContainsString(
            '<link rel="canonical" href="https://myfushi.com/tools/honmei-kichihoi">',
            $body,
        );
        $this->assertStringContainsString(
            '<meta property="og:url" content="https://myfushi.com/tools/honmei-kichihoi">',
            $body,
        );
        $this->assertStringNotContainsString('birth_year', $this->head($body));
    }

    public function testSitemapListsTheSameUrls(): void
    {
        $result = $this->get('/sitemap.xml');

        $result->assertOK();
        $this->assertStringContainsString('application/xml', $result->response()->getHeaderLine('Content-Type'));

        $body = (string) $result->response()->getBody();
        $this->assertStringStartsWith('<?xml version="1.0" encoding="UTF-8"?>', $body);
        $this->assertNotFalse(simplexml_load_string($body));
        $this->assertStringContainsString('http://www.sitemaps.org/schemas/sitemap/0.9', $body);

        $pages = (new PublicPages())->all();

        foreach ($pages as $page) {
            $this->assertStringContainsString(
                '<loc>' . PublicPages::absolute($page['path']) . '</loc>',
                $body,
            );
        }

        $this->assertSame(count($pages), substr_count($body, '<loc>'));
        $this->assertStringNotContainsString('/genkan/a1', $body);
        $this->assertStringNotContainsString('localhost', $body);
        $this->assertStringNotContainsString('staging.myfushi.com', $body);
    }

    public function testRobotsAllowsCrawlersAndNamesSitemap(): void
    {
        $robots = file_get_contents(PUBLICPATH . 'robots.txt');

        $this->assertIsString($robots);
        $this->assertStringContainsString("User-agent: *\nAllow: /\n", $robots);
        $this->assertStringContainsString('Sitemap: https://myfushi.com/sitemap.xml', $robots);
        $this->assertStringNotContainsString('Disallow', $robots);
    }

    private function head(string $body): string
    {
        $end = strpos($body, '</head>');

        return $end === false ? $body : substr($body, 0, $end);
    }
}
