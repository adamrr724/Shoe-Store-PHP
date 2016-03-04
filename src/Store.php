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
			$existing_stores = $GLOBALS['DB']->query("SELECT * FROM stores");
			foreach ($existing_stores as $store) {
				if ($store['store_name'] == $this->getStoreName()) {
					return false;
				}
			}
			$GLOBALS['DB']->exec("INSERT INTO stores (store_name) VALUES ('{$this->getStoreName()}');");
			$this->id = $GLOBALS['DB']->lastInsertId();
		}

		static function getAll()
		{
			$returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores");
			$stores = array();
			foreach($returned_stores as $store){
				 $store_name = $store['store_name'];
				 $id = $store['id'];
				 $new_store = new Store($store_name, $id);
				 array_push($stores, $new_store);
			}
			return $stores;
		}

		static function deleteAll()
		{
			$GLOBALS['DB']->exec("DELETE FROM stores");
		}

		static function find($id)
		{
			$all_stores = Store::getAll();
			$found_store = null;
			foreach($all_stores as $store) {
				$store_id = $store->getId();
				if ($store_id == $id) {
					$found_store = $store;
				}
			}
			return $found_store;
		}

		function update($new_store_name)
		{
		   $GLOBALS['DB']->exec("UPDATE stores SET store_name = '{$new_store_name}' WHERE id={$this->getId()};");
		   $this->setStoreName($new_store_name);
		}

		function delete()
		{
		   $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
		   $GLOBALS['DB']->exec("DELETE FROM stores_brands WHERE store_id = {$this->getId()};");
		}

		function addBrand($brand)
		{
			$existing_store_brands = $GLOBALS['DB']->query("SELECT * FROM stores_brands");
			foreach ($existing_store_brands as $store_brand) {
				if ($store_brand['brand_id'] == $brand->getId() and $store_brand['store_id'] == $this->getId()) {
					return false;
				}
			}
			$GLOBALS['DB']->exec("INSERT INTO stores_brands (store_id, brand_id) VALUES ({$this->getId()}, {$brand->getId()}) ;");
		}

		function getBrands()
		{
			$query = $GLOBALS['DB']->query("SELECT brands.* FROM stores JOIN stores_brands ON (stores.id = stores_brands.store_id) JOIN brands ON (stores_brands.brand_id = brands.id) WHERE stores.id = {$this->getId()}; ");
			$returned_brands = $query->fetchAll(PDO::FETCH_ASSOC);
			$brands = array();
			foreach($returned_brands as $brand){
				$brand_name = $brand['brand_name'];
				$id = $brand['id'];
				$new_brand = new Brand($brand_name, $id);
				array_push($brands, $new_brand);
			}
			return $brands;
		}

		static function search($search_term)
		{
			$query = $GLOBALS['DB']->query("SELECT * FROM stores WHERE store_name LIKE '%{$search_term}%'");
			$all_stores = $query->fetchAll(PDO::FETCH_ASSOC);
			$found_stores = array();
			foreach ($all_stores as $store) {
				$store_name = $store['store_name'];
				$id = $store['id'];
				$new_store = new Store($store_name, $id);
				array_push($found_stores, $new_store);
			}
			return $found_stores;
		}


	}
 ?>
