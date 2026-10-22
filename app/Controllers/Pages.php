<?php

namespace App\Controllers;

use App\Libraries\ContentCatalog;
use CodeIgniter\HTTP\ResponseInterface;

class Pages extends BaseController
{
    private ContentCatalog $catalog;

    public function __construct()
    {
        $this->catalog = new ContentCatalog();
    }

    public function disclaimer(): string
    {
        return view('pages/disclaimer', [
            'title' => '免責事項',
        ]);
    }

    public function privacy(): string
    {
        return view('pages/privacy', [
            'title' => 'プライバシー',
        ]);
    }

    public function cluster(string $key): ResponseInterface|string
    {
        $cluster = $this->catalog->cluster($key);

        if ($cluster === null) {
            return $this->notFound();
        }

        return view('content/cluster', [
            'title'   => $cluster['title'],
            'cluster' => $cluster,
        ]);
    }

    public function article(string $cluster, string $id): ResponseInterface|string
    {
        $article = $this->catalog->article($cluster, $id);

        if ($article === null) {
            return $this->notFound();
        }

        return view('content/article', [
            'title'   => $article['item']['title'],
            'article' => $article,
        ]);
    }

    private function notFound(): ResponseInterface
    {
        return $this->response
            ->setStatusCode(404)
            ->setBody(view('errors/html/error_404_ja', [
                'title' => 'ページが見つかりません',
            ]));
    }
}
