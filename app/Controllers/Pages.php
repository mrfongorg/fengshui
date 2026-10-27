<?php

namespace App\Controllers;

use App\Libraries\ContentCatalog;
use App\Libraries\PublicPages;
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
        return $this->renderPage('pages/disclaimer', 'disclaimer');
    }

    public function privacy(): string
    {
        return $this->renderPage('pages/privacy', 'privacy');
    }

    public function cluster(string $key): ResponseInterface|string
    {
        $cluster = $this->catalog->cluster($key);

        if ($cluster === null) {
            return $this->notFound();
        }

        return $this->renderPage('content/cluster', $key, [
            'cluster' => $cluster,
        ]);
    }

    public function article(string $cluster, string $id): ResponseInterface|string
    {
        $article = $this->catalog->article($cluster, $id);

        if ($article === null) {
            return $this->notFound();
        }

        return $this->renderPage('content/article', $cluster . '/' . strtolower($id), [
            'article' => $article,
        ]);
    }

    private function notFound(): ResponseInterface
    {
        return $this->response
            ->setStatusCode(404)
            ->setBody(view('errors/html/error_404_ja', PublicPages::notFoundData()));
    }
}
