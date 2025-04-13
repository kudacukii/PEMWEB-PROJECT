<?php

// load all dependencies
require_once __DIR__ . '/../src/Loader.php';

// start php session
session_start();

$router = new \Bantoo\App\Router\Router();

// Custom 404 Handler
$router->set404(function () {
  http_response_code(404);
  header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
  echo '404, route not found!';
});

// Before Router middleware a.k.a request filter
$router->before('GET', '/.*', function (): void {
  header('X-Powered-By: Opik Technology');
});

$router->setNamespace('\Bantoo\App');
$router->setBasePath('/api');

$router->get  ('/info',                          'Controller\Info@show');
$router->get  ('/navigation/(\w+)',              'Controller\User@menu');
$router->post ('/login',                         'Controller\User@login');
$router->post ('/logout',                        'Controller\User@logout');
$router->post ('/register',                      'Controller\User@register');
$router->get  ('/profile',                       'Controller\User@profile');
$router->get  ('/campaign/(\d+)/(\d+)',          'Controller\Campaign@getCampaigns');
$router->get  ('/campaign/latest',               'Controller\Campaign@getLatestCampaigns');
$router->patch('/campaign/approve/(\w+)/(\d+)',  'Controller\Campaign@approveCampaign');
$router->patch('/campaign/reject/(\w+)/(\d+)',   'Controller\Campaign@rejectCampaign');
$router->patch('/campaign/complete/(\w+)/(\d+)', 'Controller\Campaign@closeCampaign');
$router->get  ('/campaign/donate/(\d+)',         'Controller\Campaign@showDonation');
$router->post ('/campaign/donate/(\d+)',         'Controller\Campaign@acceptDonation');

// Here we go!
$router->run();
