<?php

	namespace Hasokeyk\Hepsiburada\Marketplace;

	class HepsiburadaMarketplace{

		public $merchant_id;
		public $service_key;
		public $hepsiburada;

		function __construct($hepsiburada){
			$this->merchant_id = $hepsiburada->merchant_id;
			$this->service_key = $hepsiburada->service_key;
			$this->hepsiburada = $hepsiburada;
		}

		public function HepsiburadaMarketplaceCategories(): HepsiburadaMarketplaceCategories{
			return new HepsiburadaMarketplaceCategories($this->hepsiburada);
		}

		public function HepsiburadaMarketplaceProducts(): HepsiburadaMarketplaceProducts{
			return new HepsiburadaMarketplaceProducts($this->hepsiburada);
		}
	}