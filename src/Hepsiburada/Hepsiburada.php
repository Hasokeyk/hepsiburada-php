<?php

	namespace Hasokeyk\Hepsiburada;

	use Hasokeyk\Hepsiburada\Marketplace\HepsiburadaMarketplace;

	class Hepsiburada{

		public $merchant_id;
		public $service_key;
		public $integrator_dev;
		public $test;

		public HepsiburadaMarketplace $marketplace;
		public HepsiburadaRequest     $request;

		function __construct($merchant_id = null, $integrator_dev = null, $service_key = null, $test = false){

			$this->merchant_id    = $merchant_id;
			$this->integrator_dev = $integrator_dev;
			$this->service_key    = $service_key;
			$this->test           = $test;

			$this->request     = $this->HepsiburadaRequest();
			$this->marketplace = $this->HepsiburadaMarketplace();
		}

		public function HepsiburadaMarketplace(): HepsiburadaMarketplace{
			return new HepsiburadaMarketplace($this);
		}

		public function HepsiburadaRequest(): HepsiburadaRequest{
			return new HepsiburadaRequest($this);
		}

	}