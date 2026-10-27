<?php

namespace App\Libraries;

use RuntimeException;

/**
 * Indexable public URLs, titles, and descriptions.
 * The sitemap and layouts/main.php both read this list.
 * Canonical URLs always use https://myfushi.com.
 */
class PublicPages
{
    public const ORIGIN = 'https://myfushi.com';

    /**
     * Document titles and descriptions for the three cluster hubs.
     * Visible headings stay the short names in ContentCatalog.
     *
     * @var array<string, array{title: string, description: string}>
     */
    private const HUBS = [
        'genkan' => [
            'title'       => '玄関の整え方',
            'description' => '玄関の明るさ、動線、置くものを断定せずに並べます。本命星の吉方位や鬼門の確認は関連ツールへ。公開中の記事はセルフチェックリストです。',
        ],
        'mizumawari' => [
            'title'       => '水回りの風水で先に見ること',
            'description' => 'トイレ、浴室、キッチン、洗面所は、湿気や詰まりを先に見て、方位の話は参考までにします。鬼門側かどうかは鬼門問答で整理できます。',
        ],
        'hikkoshi' => [
            'title'       => '引越しの吉日と新居で最初にすること',
            'description' => '引越しの日取りと、新しい部屋で最初にすることをまとめています。吉日の候補は仕事と荷物の都合のあと。方位は本命星のツールで確認できます。',
        ],
    ];

    /** @var list<array{path: string, title: string, description: string}>|null */
    private ?array $pages = null;

    /**
     * @return list<array{path: string, title: string, description: string}>
     */
    public function all(): array
    {
        if ($this->pages !== null) {
            return $this->pages;
        }

        $pages = [
            $this->page(
                '/',
                '玄関・水回り・引越しの風水',
                'MyFushiは、玄関・水回り・引越しの整え方を参考としてまとめています。本命星の吉方位、吉日、鬼門の確認は各ツールから。鑑定や開運の保証ではありません。',
            ),
            $this->page(
                'tools/honmei-kichihoi',
                '本命星と今年の吉方位',
                '生まれ年から本命星と今年の吉方位を見るツールです。玄関や引越しで方位を考えるときの参考にします。いま戻るのは入力を受け付けた確認だけで、鑑定結果ではありません。',
            ),
            $this->page(
                'tools/kichijitsu',
                '引越し・入居の吉日',
                '引越し、入居、契約の年月から吉日の候補を見る日暦です。暦の名前は予定を合わせる目印で、その日でなければ動けないという意味にはしません。',
            ),
            $this->page(
                'tools/kimon-qa',
                '鬼門の問答（玄関・水回り）',
                '玄関や水回り（トイレ・浴室）が鬼門（北東）側にあるかを、はい・いいえ・わからないで整理する問答です。吉凶の答えではなく、置き方を考える参考です。',
            ),
        ];

        $catalog = new ContentCatalog();

        foreach ($catalog->clusters() as $cluster) {
            $key = $cluster['key'];

            if (! isset(self::HUBS[$key])) {
                throw new RuntimeException('Missing SEO copy for cluster: ' . $key);
            }

            $pages[] = $this->page($key, self::HUBS[$key]['title'], self::HUBS[$key]['description']);

            $full = $catalog->cluster($key);

            if ($full === null) {
                continue;
            }

            foreach ($full['items'] as $item) {
                if ($item['published'] !== true) {
                    continue;
                }

                $slug    = (string) $item['slug'];
                $article = $catalog->article($key, $slug);
                $sample  = is_array($article) && is_array($article['sample'] ?? null) ? $article['sample'] : [];
                $dek     = trim((string) ($sample['dek'] ?? ''));

                if ($dek === '') {
                    continue;
                }

                $pages[] = $this->page($key . '/' . $slug, (string) $item['title'], $dek);
            }
        }

        $pages[] = $this->page(
            'disclaimer',
            '免責事項',
            'MyFushiの文章とツールは、玄関・水回り・引越しに関する一般向けの参考情報です。専門の風水鑑定、医療、法律、不動産、開運の保証ではありません。',
        );
        $pages[] = $this->page(
            'privacy',
            'プライバシー',
            '本命星・吉日・鬼門のフォームに入れた値は、その場の画面を描くためだけに使い、データベースへは保存しません。MyFushiの取り扱いをまとめています。',
        );

        return $this->pages = $pages;
    }

    /**
     * @return array{path: string, title: string, description: string}|null
     */
    public function find(string $path): ?array
    {
        $path = self::normalize($path);

        foreach ($this->all() as $page) {
            if ($page['path'] === $path) {
                return $page;
            }
        }

        return null;
    }

    public function sitemapXml(): string
    {
        $lines = [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',
        ];

        foreach ($this->all() as $page) {
            $loc     = htmlspecialchars(self::absolute($page['path']), ENT_XML1 | ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
            $lines[] = '  <url>';
            $lines[] = '    <loc>' . $loc . '</loc>';
            $lines[] = '  </url>';
        }

        $lines[] = '</urlset>';

        return implode("\n", $lines) . "\n";
    }

    public static function absolute(string $path): string
    {
        $path = self::normalize($path);

        if ($path === '/') {
            return self::ORIGIN . '/';
        }

        return self::ORIGIN . '/' . $path;
    }

    public static function normalize(string $path): string
    {
        $path = strtolower(trim($path));

        if ($path === '' || $path === '/') {
            return '/';
        }

        return trim($path, '/');
    }

    /**
     * @return array{title: string, description: string, canonical: string, robots: string}
     */
    public static function notFoundData(): array
    {
        return [
            'title'       => 'ページが見つかりません',
            'description' => '指定されたアドレスのページは MyFushi にありません。',
            'canonical'   => '',
            'robots'      => 'noindex',
        ];
    }

    /**
     * @return array{path: string, title: string, description: string}
     */
    private function page(string $path, string $title, string $description): array
    {
        return [
            'path'        => self::normalize($path),
            'title'       => $title,
            'description' => $description,
        ];
    }
}
