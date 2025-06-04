<?php

	namespace Hasokeyk\Hepsiburada\Marketplace;

	class HepsiburadaMarketplaceCategories{

		public $merchant_id;
		public $service_key;
		public $hepsiburada;
		public $api_link;

		function __construct($hepsiburada){
			$this->merchant_id = $hepsiburada->merchant_id;
			$this->service_key = $hepsiburada->service_key;
			$this->hepsiburada = $hepsiburada;

			if($this->hepsiburada->test){
				$this->api_link = 'https://mpop-sit.hepsiburada.com/';
			}
			else{
				$this->api_link = 'https://mpop.hepsiburada.com/';
			}

		}

		private function request(){
			return $this->hepsiburada->request;
		}

		public function get_categories($page = 1, $limit = 2000){

			$query_params = [
				'leaf'      => true,
				'status'    => 'ACTIVE',
				'available' => true,
				'page'      => $page,
				'size'      => $limit,
				'version'   => 1,
			];

			$url    = $this->api_link.'/product/api/categories/get-all-categories?'.http_build_query($query_params);
			$result = $this->request()->get($url);
			return $result;
		}

		public function get_category_attrs($category_id){

			$query_params = [
				'version' => 1
			];

			$url    = $this->api_link.'/product/api/categories/'.$category_id.'/attributes?'.http_build_query($query_params);
			$result = $this->request()->get($url);
			return $result;
		}

		public function get_category_attr_values($category_id, $attribute_id, $page = 1, $limit = 1000){

			$query_params = [
				'page'    => $page,
				'size'    => $limit,
				'version' => 4,
			];

			$url    = $this->api_link.'/product/api/categories/'.$category_id.'/attribute/'.$attribute_id.'/values?'.http_build_query($query_params);
			$result = $this->request()->get($url);
			return $result;
		}

	}