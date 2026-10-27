<?php

namespace App\Controllers;

use App\Libraries\PublicPages;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    /**
     * @param CLIRequest|IncomingRequest $request
     *
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        $this->helpers = ['url'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // $this->session = service('session');
    }

    /**
     * Render a public page with the title, description, and canonical
     * stored for that path. layouts/main.php prints them once.
     *
     * @param array<string, mixed> $data
     */
    protected function renderPage(string $view, string $path, array $data = []): string
    {
        $meta = (new PublicPages())->find($path);

        if ($meta === null) {
            throw new InvalidArgumentException('No public page metadata for path: ' . $path);
        }

        $data['title']       = $meta['title'];
        $data['description'] = $meta['description'];
        $data['canonical']   = PublicPages::absolute($meta['path']);
        $data['robots']      = '';

        return view($view, $data);
    }
}
