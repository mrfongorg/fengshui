<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Sets X-Robots-Tag: noindex, nofollow when this filter is applied to a route.
 * The alias is registered and is not in the global filter list, so public pages stay indexable.
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
