<?php

    namespace Hasokeyk\Hepsiburada;

    class Hepsiburada{

        public $merchant_id;
        public $username;
        public $password;
        public $test_mode;

        public $request;
        public $catalog;
        public $listing;

        public function __construct($merchant_id = null, $username = null, $password = null, $test_mode = false){
            $this->merchant_id = $merchant_id;
            $this->username    = $username;
            $this->password    = $password;
            $this->test_mode   = $test_mode;

            $this->request = $this->Request();
            $this->catalog = $this->Catalog();
            $this->listing = $this->Listing();
        }

        private function Request(): Request{
            return new Request($this->merchant_id, $this->username, $this->password, $this->test_mode);
        }

        private function Catalog(): Catalog{
            return new Catalog($this->request, $this->test_mode);
        }

        private function Listing(): Listing{
            return new Listing($this->request, $this->test_mode);
        }
    }