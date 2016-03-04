<?php

	/**
	* @backupGlobals disabled
	* @backupStaticAttributes disabled
	*/

	require_once 'src/Store.php';
	require_once 'src/Brand.php';

	class StoreTest extends PHPUnit_Framework_TestCase
	{
		// protected function tearDown()
		// {
		// 	Brand::deleteAll();
		// 	Store::deleteAll();
		// }

		function test_getters()
		{
			//Arrange
			$store_name = "Nike Store";
			$id = 1;
			$test_store = new Store($store_name, $id);

			//Act
			$result1 = $test_store->getStoreName();
			$result2 = $test_store->getId();

			//Assert
			$this->assertEquals("Nike Store", $result1);
			$this->assertEquals(1, $result2);
		}

		function test_save()
	   {
			//Arrange
			$store_name = "Nike Store";
			$id = 1;
			$test_store = new Store($store_name, $id);

			//Act
			$test_store->save();
			$result = Store::getAll();

			//Assert
			$this->assertEquals([$test_store], $result);
	   }

	   function test_getAll()
	   {
			//Arrange
			$store_name = "Nike Store";
			$id = null;
			$test_store = new Store($store_name, $id);
			$test_store->save();

			//Act
			$store_name2 = "Footlocker";
			$test_store2 = new Store($store_name2, $id);
			$test_store2->save();

			//Assert
			$result = Store::getAll();
			$this->assertEquals([$test_store, $test_store2], $result);
	   }
	}

?>
