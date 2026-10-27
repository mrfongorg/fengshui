<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('sitemap.xml', 'Sitemap::index');

$routes->match(['GET', 'POST'], 'tools/honmei-kichihoi', 'Tools::honmei');
$routes->match(['GET', 'POST'], 'tools/kichijitsu', 'Tools::kichijitsu');
$routes->match(['GET', 'POST'], 'tools/kimon-qa', 'Tools::kimon');

$routes->get('disclaimer', 'Pages::disclaimer');
$routes->get('disclaimer/', 'Pages::disclaimer');
$routes->get('privacy', 'Pages::privacy');
$routes->get('privacy/', 'Pages::privacy');

foreach (['genkan', 'mizumawari', 'hikkoshi'] as $cluster) {
    $routes->get($cluster, 'Pages::cluster/' . $cluster);
    $routes->get($cluster . '/', 'Pages::cluster/' . $cluster);
    $routes->get($cluster . '/(:segment)', 'Pages::article/' . $cluster . '/$1');
    $routes->get($cluster . '/(:segment)/', 'Pages::article/' . $cluster . '/$1');
}

$routes->set404Override(static function (?string $message = null) {
    helper('url');

    return view('errors/html/error_404_ja', \App\Libraries\PublicPages::notFoundData());
});
