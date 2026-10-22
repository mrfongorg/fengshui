<?php

namespace App\Libraries;

use RuntimeException;

/**
 * Reads the outline CSV and marks the three sample articles that have pages.
 */
class ContentCatalog
{
    /** @var list<string> */
    public const PUBLISHED = ['A7', 'B1', 'C1'];

    /**
     * @var array<string, array{title: string, summary: string}>
     */
    private const CLUSTERS = [
        'genkan' => [
            'title'   => '玄関',
            'summary' => '入口の明るさ、動線、置き方を、断定せずに並べるテーマです。',
        ],
        'mizumawari' => [
            'title'   => '水回り',
            'summary' => 'トイレ、浴室、キッチン、洗面所。湿気や詰まりを先に見て、方位の話は参考までにします。',
        ],
        'hikkoshi' => [
            'title'   => '引越',
            'summary' => '日取りと、新しい部屋で最初にすること。暦の候補は、仕事と荷物の都合のあとです。',
        ],
    ];

    /**
     * @return list<array{key: string, title: string, summary: string}>
     */
    public function clusters(): array
    {
        $list = [];

        foreach (self::CLUSTERS as $key => $meta) {
            $list[] = [
                'key'     => $key,
                'title'   => $meta['title'],
                'summary' => $meta['summary'],
            ];
        }

        return $list;
    }

    /**
     * @return array{key: string, title: string, summary: string, items: list<array<string, mixed>>}|null
     */
    public function cluster(string $key): ?array
    {
        if (! isset(self::CLUSTERS[$key])) {
            return null;
        }

        $items = [];

        foreach ($this->rows() as $row) {
            if ($row['cluster'] !== $key) {
                continue;
            }

            $items[] = $this->present($row);
        }

        return [
            'key'     => $key,
            'title'   => self::CLUSTERS[$key]['title'],
            'summary' => self::CLUSTERS[$key]['summary'],
            'items'   => $items,
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    public function article(string $cluster, string $id): ?array
    {
        $id = strtoupper($id);

        foreach ($this->rows() as $row) {
            if ($row['cluster'] !== $cluster || $row['id'] !== $id) {
                continue;
            }

            $item   = $this->present($row);
            $sample = ContentSamples::find($id);

            if ($sample === null || $item['published'] !== true) {
                return null;
            }

            return [
                'cluster_key'   => $cluster,
                'cluster_title' => self::CLUSTERS[$cluster]['title'],
                'item'          => $item,
                'sample'        => $sample,
            ];
        }

        return null;
    }

    /**
     * @param array{id: string, cluster: string, title: string, tool_slug: string} $row
     *
     * @return array<string, mixed>
     */
    private function present(array $row): array
    {
        $toolPath = ltrim($row['tool_slug'], '/');

        return [
            'id'         => $row['id'],
            'slug'       => strtolower($row['id']),
            'title'      => $row['title'],
            'tool_path'  => $toolPath,
            'tool_label' => self::toolLabel($toolPath),
            'published'  => in_array($row['id'], self::PUBLISHED, true),
        ];
    }

    /**
     * @return list<array{id: string, cluster: string, title: string, tool_slug: string}>
     */
    private function rows(): array
    {
        $path   = APPPATH . 'Database/Seeds/data/content-seed-stub.csv';
        $handle = fopen($path, 'rb');

        if ($handle === false) {
            throw new RuntimeException('Content outline CSV is missing.');
        }

        $header = fgetcsv($handle);

        if (! is_array($header)) {
            fclose($handle);

            throw new RuntimeException('Content outline CSV has no header.');
        }

        $map  = array_flip($header);
        $rows = [];

        while (($line = fgetcsv($handle)) !== false) {
            if ($line === [null] || count($line) < count($header)) {
                continue;
            }

            $id = trim((string) ($line[$map['seed_id']] ?? ''));

            if ($id === '') {
                continue;
            }

            $rows[] = [
                'id'        => $id,
                'cluster'   => trim((string) ($line[$map['cluster']] ?? '')),
                'title'     => trim((string) ($line[$map['title']] ?? '')),
                'tool_slug' => trim((string) ($line[$map['tool_slug']] ?? '')),
            ];
        }

        fclose($handle);

        return $rows;
    }

    private static function toolLabel(string $path): string
    {
        return match ($path) {
            'tools/honmei-kichihoi' => '本命星／今年吉方位',
            'tools/kichijitsu'      => '吉日日暦',
            'tools/kimon-qa'        => '鬼門問答',
            default                 => '',
        };
    }
}
