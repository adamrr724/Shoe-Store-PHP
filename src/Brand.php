<?php
	 class Brand
		{
		private $brand_name;
		private $id;

		function __construct($brand_name, $id = null)
		{
			$this->brand_name = $brand_name
		}

		function getBrandName()
		{
			return $this->brand_name;
		}

		function setBrandName()
		{
			$this->brand_name = $brand_name;
		}

		function getId()
		{
			return $this->id;
		}
	}
 ?>
