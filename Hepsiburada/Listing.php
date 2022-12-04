<?php

    namespace Hasokeyk\Hepsiburada;

    use Exception;

    class Listing{

        private $test_url = 'https://listing-external-sit.hepsiburada.com/';
        private $live_url = 'https://listing-external.hepsiburada.com/';
        private $url;

        private $request;

        public function __construct($request, $test_mode){

            if($test_mode){
                $this->url = $this->test_url;
            }
            else{
                $this->url = $this->live_url;
            }

            $this->request = $request;
        }

        public function get_merchant_list($offset = 0, $limit = 2000){

            if(!is_numeric($offset)){
                throw new Exception('"offset" value none numaric');
            }

            if(!is_numeric($limit)){
                throw new Exception('"limit" value none numaric');
            }
            else if($limit > 2000){
                throw new Exception('"limit" cannot be greater than 1000');
            }
            else if($limit < 0){
                throw new Exception('"limit" cannot be less than 0');
            }

            try{
                $url     = $this->url.'/listings/merchantid/'.$this->request->merchant_id.'?offset='.$offset.'&limit='.$limit;
                $request = $this->request->get($url);
                return json_decode($request['body']);
            }catch(Exception $err){
                print_r($err->getMessage());
            }

        }

        public function update_product_price($hepsiburada_product_sku = null, $custom_product_sku = null, $price = 0){

            if(!is_numeric($price)){
                throw new Exception('"price" value none numaric');
            }

            if(empty($hepsiburada_product_sku)){
                throw new Exception('"hepsiburada_product_sku" is none empty');
            }

            try{

                $data[] = [
                    'HepsiburadaSku' => $hepsiburada_product_sku,
                    'MerchantSku'    => $custom_product_sku,
                    'Price'          => $price,
                ];

               $data = json_encode($data);

               $data = '[
    {
        "HepsiburadaSku": "HBV000004FYHI",
        "MerchantSku": "MMMM",
        "Price": 1006.99
    },
    {
        "MerchantSku": "MMMM",
        "Price": 1006.99
    }
]';

                $url     = $this->url.'/listings/merchantid/'.$this->request->merchant_id.'/price-uploads';
                $request = $this->request->post_body($url, $data);
                return json_decode($request['body']);
            }catch(Exception $err){
                print_r($err->getMessage());
            }

        }

    }