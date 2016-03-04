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

	$app->get('/', function() use ($app){
		return $app['twig']->render('index.html.twig');
	});

	$app->get('/stores', function() use ($app){
		$stores = Store::getAll();
		$message = null;
		return $app['twig']->render('stores.html.twig', array('stores' => $stores, 'message' => $message));
	});

	$app->get('/stores/add', function() use ($app){
		return $app['twig']->render('stores_add.html.twig');
	});

	$app->post('/store/addstore', function() use ($app){
		$store_name = $_POST['store_name'];
		$store = new Store($store_name);
		if ($store->save() == false){
			$message = array('type' => 'danger','text' => 'That store already exists. Store not added to page.');
			return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'message' => $message));
		} else {
			$store->save();
			$message = null;
			}
		return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'message' => $message));
	});

	$app->get('/store/{id}/edit', function($id) use ($app){
		$store = Store::find($id);
		return $app['twig']->render('stores_edit.html.twig', array('store' => $store, 'brands' => Brand::getAll()));
	});

	$app->patch('/store/{id}/update_name', function($id) use ($app){
		$store = Store::find($id);
		$new_store_name = $_POST['store_name'];
		$store->update($new_store_name);
		$message = null;
		return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'message' => $message));
	});

	$app->post('/store/{id}/addbrand', function($id) use ($app){
		$brand_id = $_POST['brand_name'];
		$brand = Brand::find($brand_id);
		$store = Store::find($id);
		$store->addBrand($brand);
		$message = null;
		return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'message' => $message));
	});

	$app->delete('/store/{id}/delete', function($id) use ($app){
		$store = Store::find($id);
		$store->delete();
		$message = null;
		return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'message' => $message));
	});

	$app->get('/stores/search', function() use ($app){
		$search_term = $_GET['store_name'];
		$stores = Store::search($search_term);
		$message = null;
		return $app['twig']->render('stores.html.twig', array('stores' => $stores, 'message' => $message));
	});

	$app->get('/brands', function() use ($app){
		$brands = Brand::getAll();
		$message = null;
		return $app['twig']->render('brands.html.twig', array('brands' => $brands, 'stores' => Store::getAll(), 'message' => $message));
	});

	$app->get('/brands/add', function() use ($app){
		return $app['twig']->render('brands_add.html.twig');
	});

	$app->post('/brand/addbrand', function() use ($app){
		$brand_name = $_POST['brand_name'];
		$brand = new Brand($brand_name);
		if ($brand->save() == false){
			$message = array('type' => 'danger','text' => 'That brand already exists. Brand not added to page.');
			return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll(), 'message' => $message));
		} else {
			$brand->save();
			$message = null;
			}
		return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll(), 'message' => $message));
	});

	$app->post('/brand/{id}/store_add', function($id) use ($app){
		$store_id = $_POST['store_name'];
		$store = Store::find($store_id);
		$brand = Brand::find($id);
		$brand->addStore($store);
		$message = null;
		return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll(), 'message' => $message));
	});

	$app->delete('/brand/{id}/delete', function($id) use ($app){
		$brand = Brand::find($id);
		$brand->delete();
		$message = null;
		return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll(), 'message' => $message));
	});

	$app->get('/brands/search', function() use ($app){
		$search_term = $_GET['brand_name'];
		$brands = Brand::search($search_term);
		$message = null;
		return $app['twig']->render('brands.html.twig', array('brands' => $brands, 'stores' => Store::getAll(), 'message' => $message));
	});

	return $app;

?>
