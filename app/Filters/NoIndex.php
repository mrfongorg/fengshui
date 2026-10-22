<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Staging stub: ask crawlers not to index any response.
 * Remove this filter before a public launch.
 */
class NoIndex implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return $response->setHeader('X-Robots-Tag', 'noindex, nofollow');
    }
}
