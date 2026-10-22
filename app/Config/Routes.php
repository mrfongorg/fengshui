<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('tools/honmei-kichihoi', 'Tools::honmei');
$routes->get('tools/kichijitsu', 'Tools::kichijitsu');
$routes->get('tools/kimon-qa', 'Tools::kimon');

$routes->set404Override(static function (?string $message = null) {
    helper('url');

    return view('errors/html/error_404_ja', ['title' => 'ページが見つかりません']);
});
