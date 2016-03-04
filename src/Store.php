<?php
	 class Store
		{
		private $store_name;
		private $id;

		function __construct($store_name, $id = null)
		{
			$this->store_name = $store_name;
			$this->id = $id;
		}

		function getStoreName()
		{
			return $this->store_name;
		}

		function setStoreName($new_store_name)
		{
			$this->store_name = $new_store_name;
		}

		function getId()
		{
			return $this->id;
		}
		function save()
		{
			$GLOBALS['DB']->exec("INSERT INTO stores (sotre_name) VALUES ('{$this->getStoreName()}');");
			$this->id = $GLOBALS['DB']->lastInsertId();
		}
	}
 ?>
