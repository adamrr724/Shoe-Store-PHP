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
	}

?>
