<?php

	/**
	* @backupGlobals disabled
	* @backupStaticAttributes disabled
	*/

	require_once 'src/Store.php';
	require_once 'src/Brand.php';

	class StoreTest extends PHPUnit_Framework_TestCase
	{
		protected function tearDown()
		{
			Brand::deleteAll();
			Store::deleteAll();
		}

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

		function test_deleteAll()
		{
			//Arrange
			$store_name = "Nike Store";
			$id = null;
			$test_store = new Store($store_name, $id);
			$test_store->save();

			$store_name2 = "Footlocker";
			$test_store2 = new Store($store_name2, $id);
			$test_store2->save();

			//Act
			Store::deleteAll();

			//Assert
			$this->assertEquals([], Store::getAll());
		}

		function test_find()
			{
			//Arrange
			$store_name = "Nike Store";
			$id = null;
			$test_store = new Store($store_name, $id);
			$test_store->save();

			$store_name2 = "Footlocker";
			$test_store2 = new Store($store_name2, $id);
			$test_store2->save();

			//Act
			$result = Store::find($test_store->getId());

			//Assert
			$this->assertEquals($test_store, $result);
		}

		function test_update()
		{
			//Arrange
			$store_name = "Nike Store";
			$id = null;
			$test_store = new Store($store_name, $id);
			$test_store->save();

			$new_store_name = "Zumies";

			//Act
			$test_store->update($new_store_name);

			//Assert
			$this->assertEquals($new_store_name, $test_store->getStoreName());
		}

		function test_delete()
		{
			//Arrange
			$store_name = "Nike Store";
			$id = null;
			$test_store = new Store($store_name, $id);
			$test_store->save();

			$store_name2 = "Footlocker";
			$test_store2 = new Store($store_name2, $id);
			$test_store2->save();

			//Act
			$test_store->delete();
			$result = Store::getAll();

			//Assert
			$this->assertEquals([$test_store2], $result);
		}

		function test_addBrand()
		{
			//Arrange
			$store_name = "Nike Store";
			$id = null;
			$test_store = new Store($store_name, $id);
			$test_store->save();

			$brand_name = "Nike";
			$id = null;
			$test_brand = new Brand($brand_name, $id);
			$test_brand->save();

			//Act
			$test_store->addBrand($test_brand);

			//Assert
			$this->assertEquals($test_store->getBrands(), [$test_brand]);
		}

		function test_getBrands()
		{
			//Arrange
			$store_name = "Nike Store";
			$id = null;
			$test_store = new Store($store_name, $id);
			$test_store->save();

			$brand_name = "Nike";
			$id = null;
			$test_brand = new Brand($brand_name, $id);
			$test_brand->save();

			$store_name2 = "Footlocker";
			$test_store2 = new Store($store_name2, $id);
			$test_store2->save();

			$brand_name2 = "Adidas";
			$test_brand2 = new Brand($brand_name2, $id);
			$test_brand2->save();

			//Act
			$test_store->addBrand($test_brand);
			$test_store->addBrand($test_brand2);

			//Assert
			$this->assertEquals($test_store->getBrands(), [$test_brand, $test_brand2]);
		}

		function test_search()
		{
			//Arrange
			$store_name = "Nike Store";
			$id = null;
			$test_store = new Store($store_name, $id);
			$test_store->save();

			$store_name2 = "Footlocker";
			$test_store2 = new Store($store_name2, $id);
			$test_store2->save();

			$search_term = "Nike";

			//Act
			$result = Store::search($search_term);

			//Assert
			$this->assertEquals([$test_store], $result);
		}

	}

?>
