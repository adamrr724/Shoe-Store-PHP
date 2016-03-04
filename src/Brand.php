<?php
	 class Brand
	{
		private $brand_name;
		private $id;

		function __construct($brand_name, $id = null)
		{
			$this->brand_name = $brand_name;
			$this->id = $id;
		}

		function getBrandName()
		{
			return $this->brand_name;
		}

		function setBrandName($new_brand_name)
		{
			$this->brand_name = $new_brand_name;
		}

		function getId()
		{
			return $this->id;
		}

		function save()
		{
			$GLOBALS['DB']->exec("INSERT INTO brands (brand_name) VALUES ('{$this->getBrandName()}');");
			$this->id = $GLOBALS['DB']->lastInsertId();
		}
	}
 ?>
