<?php

	namespace Hasokeyk\Hepsiburada\Marketplace;

	class HepsiburadaMarketplaceProducts{

		public $merchant_id;
		public $service_key;
		public $hepsiburada;
		public $api_link;

		function __construct($hepsiburada){
			$this->merchant_id = $hepsiburada->merchant_id;
			$this->service_key = $hepsiburada->service_key;
			$this->hepsiburada = $hepsiburada;

			if($this->hepsiburada->test){
				$this->api_link = 'https://listing-external-sit.hepsiburada.com/';
			}
			else{
				$this->api_link = 'https://listing-external.hepsiburada.com/';
			}

		}

		private function request(){
			return $this->hepsiburada->request;
		}

		public function get_listing_products($filter = []){

			$required_query_data = [
				//'offset' => 1,
				'limit' => 1000,
			];

			if(is_array($filter)){
				$required_query_data = array_merge($required_query_data, $filter);
			}

			$url = $this->api_link.'listings/merchantid/'.$this->merchant_id.'?'.http_build_query($required_query_data);
			$result = $this->request()->get($url);
			return $result;
		}

		public function get_my_products_for_api($filter = []){

			$required_query_data = [
				//'offset' => 1,
				'limit' => 1000,
			];

			if(is_array($filter)){
				$required_query_data = array_merge($required_query_data, $filter);
			}

			$url = $this->api_link.'listings/merchantid/'.$this->merchant_id.'?'.http_build_query($required_query_data);
			$result = $this->request()->get($url);
			return $result;
		}

	}