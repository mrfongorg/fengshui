<?php

namespace App\Controllers;

use App\Libraries\PublicPages;
use CodeIgniter\HTTP\ResponseInterface;

class Sitemap extends BaseController
{
    public function index(): ResponseInterface
    {
        return $this->response
            ->setContentType('application/xml')
            ->setBody((new PublicPages())->sitemapXml());
    }
}
