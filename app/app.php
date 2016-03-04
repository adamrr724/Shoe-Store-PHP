<?php

	require_once __DIR__.'/../vendor/autoload.php';
	require_once __DIR__.'/../src/Store.php';
	require_once __DIR__.'/../src/Brand.php';

	// session_start();
	use Symfony\Component\Debug\Debug;
	Debug::enable();

	$server = 'mysql:host=localhost;dbname=shoes';
	$username = 'root';
	$password = 'root';
	$DB = new PDO($server, $username, $password);

	$app = new Silex\Application();

	$app['debug'] = true;

	use Symfony\Component\HttpFoundation\Request;
	Request::enableHttpMethodParameterOverride();

	$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

	$app->get('/', function(){});

	return $app;

?>
