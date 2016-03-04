<?php
	 class Store
		{
		private $store_name;
		private $id;

		function __contruct($store_name, $id = null)
		{
			$this->store_name = $store_name;
			$this->id = $id;
		}

		function getStoreName()
		{
			return $this->store_name;
		}

		function setStoreName()
		{
			$this->store_name = $store_name;
		}

		function getId()
		{
			return $this->id;
		}
	}
 ?>
