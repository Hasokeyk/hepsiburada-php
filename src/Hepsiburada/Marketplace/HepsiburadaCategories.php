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
			}else{
				$this->api_link = 'https://mpop.hepsiburada.com/';
			}

		}

		private function request(){
			return $this->hepsiburada->request;
		}

		public function get_categories(){

			echo $this->api_link;

		}

	}