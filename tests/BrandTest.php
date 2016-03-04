<?php

	require_once 'src/Brand.php';
	require_once 'src/Store.php';

	class BrandTest extends PHPUnit_Framework_TestCase
	{

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
	}

?>
