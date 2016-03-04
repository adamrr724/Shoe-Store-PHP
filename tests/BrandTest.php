<?php
	/**
	* @backupGlobals disabled
	* @backupStaticAttributes disabled
	*/

	require_once 'src/Brand.php';
	require_once 'src/Store.php';

	$server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

	class BrandTest extends PHPUnit_Framework_TestCase
	{
		protected function tearDown()
		{
			Brand::deleteAll();
			Store::deleteAll();
		}

		function test_getters()
		{
			//Arrange
			$brand_name = "Nike";
			$id = 1;
			$test_brand = new Brand($brand_name, $id);

			//Act
			$result1 = $test_brand->getBrandName();
			$result2 = $test_brand->getId();

			//Assert
			$this->assertEquals("Nike", $result1);
			$this->assertEquals(1, $result2);
		}

		function test_save()
		{
			//Arrange
			$brand_name = "Nike";
			$id = null;
			$test_brand = new Brand($brand_name, $id);

			//Act
			$test_brand->save();
			$result = Brand::getAll();

			//Assert
			$this->assertEquals([$test_brand], $result);
		}

		function test_getAll()
		{
			//Arrange
			$brand_name = "Nike";
			$id = null;
			$test_brand = new Brand($brand_name, $id);
			$test_brand->save();

			$brand_name2 = "Adidas";
			$test_brand2 = new Brand($brand_name2, $id);
			$test_brand2->save();

			//Act
			$result = Brand::getAll();

			//Assert
			$this->assertEquals([$test_brand, $test_brand2], $result);
		}

		function test_deleteAll()
		{
			//Arrange
			$brand_name = "Nike";
			$id = null;
			$test_brand = new Brand($brand_name, $id);
			$test_brand->save();

			$brand_name2 = "Adidas";
			$test_brand2 = new Brand($brand_name2, $id);
			$test_brand2->save();

			//Act
			Brand::deleteAll();

			//Assert
			$this->assertEquals([], Brand::getAll());
		}

		function test_find()
		{
			//Arrange
			$brand_name = "Nike";
			$id = null;
			$test_brand = new Brand($brand_name, $id);
			$test_brand->save();

			$brand_name2 = "Adidas";
			$test_brand2 = new Brand($brand_name2, $id);
			$test_brand2->save();

			//Act
			$result = Brand::find($test_brand->getId());

			//Assert
			$this->assertEquals($test_brand, $result);
		}

		function test_addStore()
		{
			//Arrange
			$brand_name = "Nike Store";
			$id = null;
			$test_brand = new Brand($brand_name, $id);
			$test_brand->save();

			$store_name = "Nike";
			$id = null;
			$test_store = new Store($store_name, $id);
			$test_store->save();

			//Act
			$test_brand->addStore($test_store);

			//Assert
			$this->assertEquals($test_brand->getStores(), [$test_store]);
		}

		function test_getStores()
		{
			//Arrange
			$brand_name = "Nike";
			$id = null;
			$test_brand = new Brand($brand_name, $id);
			$test_brand->save();

			$store_name = "Nike Store";
			$id = null;
			$test_store = new Store($store_name, $id);
			$test_store->save();

			$brand_name2 = "Adidas";
			$test_brand2 = new Brand($brand_name2, $id);
			$test_brand2->save();

			$store_name2 = "Footlocker";
			$test_store2 = new Store($store_name2, $id);
			$test_store2->save();

			//Act
			$test_brand->addStore($test_store);
			$test_brand->addStore($test_store2);

			//Assert
			$this->assertEquals($test_brand->getStores(), [$test_store, $test_store2]);
		}

		function test_delete()
		{
			//Arrange
			$brand_name = "Nike";
			$id = null;
			$test_brand = new Brand($brand_name, $id);
			$test_brand->save();

			$brand_name2 = "Adidas";
			$test_brand2 = new Brand($brand_name2, $id);
			$test_brand2->save();

			//Act
			$test_brand->delete();
			$result = Brand::getAll();

			//Assert
			$this->assertEquals([$test_brand2], $result);
		}
	}

?>
