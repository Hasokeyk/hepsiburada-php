<?php

    /*
     * Soruce : https://developers.hepsiburada.com/?docs=dokuman/entegrasyon
     */

    namespace Hasokeyk\Hepsiburada;

    use Exception;

    class Catalog{

        private $test_url = 'https://mpop-sit.hepsiburada.com';
        private $live_url = 'https://mpop.hepsiburada.com';
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

        public function get_all_categories($status = 'ACTIVE', $available = true, $page = 0, $size = 1000){

            if(!in_array($status, [
                'INACTIVE',
                'ACTIVE',
            ])){
                throw new Exception('"status" value can be "ACTIVE" or "INACTIVE"');
            }

            if(!is_bool($available)){
                throw new Exception('"available" value can be "true" or "false"');
            }

            if(!is_numeric($page)){
                throw new Exception('"page" value none numaric');
            }

            if(!is_numeric($size)){
                throw new Exception('"size" value none numaric');
            }
            else if($size > 1000){
                throw new Exception('"size" cannot be greater than 1000');
            }
            else if($size < 0){
                throw new Exception('"size" cannot be less than 0');
            }

            try{
                $url     = $this->url.'/product/api/categories/get-all-categories?leaf=true&status='.$status.'&available='.$available.'&page='.$page.'&size='.$size.'&version=1';
                $request = $this->request->get($url);
                return json_decode($request['body']);
            }catch(Exception $err){
                return $err->getMessage();
            }
        }

        public function get_category_attributes($category_id = null){
            if(!is_numeric($category_id)){
                throw new Exception('"category_id" is none numaric');
            }

            try{
                $url     = $this->url.'/product/api/categories/'.$category_id.'/attributes';
                $request = $this->request->get($url);
                return json_decode($request['body']);
            }catch(Exception $err){
                print_r($err->getMessage());
            }
        }

        public function get_category_attribute_value($category_id = null, $attribute_id = null, $page = 0, $size = 1000){

            if(!is_numeric($category_id)){
                throw new Exception('"category_id" is none numaric');
            }

            if(!is_numeric($page)){
                throw new Exception('"page" value none numaric');
            }

            if(!is_numeric($size)){
                throw new Exception('"size" value none numaric');
            }
            else if($size > 1000){
                throw new Exception('"size" cannot be greater than 1000');
            }
            else if($size < 0){
                throw new Exception('"size" cannot be less than 0');
            }

            try{
                $url     = $this->url.'/product/api/categories/'.$category_id.'/attribute/'.$attribute_id.'/values?page=0&size=1000&version=4';
                $request = $this->request->get($url);
                return json_decode($request['body']);
            }catch(Exception $err){
                print_r($err->getMessage());
            }
        }

        public function add_single_product($product_name = null, $product_desc = null, $price = null, $tax = 0, $category_id = null, $brand = null, $merchant_sku = null, $barcode = null, $image1 = null, $image2 = '', $image3 = '', $image4 = '', $image5 = '', $stock = 0, $warranty_period = 0, $kg = 0){

            if(empty($product_name)){
                throw new Exception('"product_name" value none empty');
            }

            if(empty($product_desc)){
                throw new Exception('"product_desc" value none empty');
            }

            if(!is_numeric($category_id)){
                throw new Exception('"category_id" is none numaric');
            }

            if(empty($brand)){
                throw new Exception('"brand" value none empty');
            }

            if(empty($price)){
                throw new Exception('"price" value none empty');
            }

            $tax_required = [
                '0',
                '1',
                '8',
                '18',
            ];
            if(!in_array($tax, $tax_required)){
                throw new Exception('"tax" value can be '.implode(' or ', $tax_required));
            }

            if(empty($merchant_sku)){
                throw new Exception('"merchant_sku" value none empty');
            }

            if(empty($barcode)){
                throw new Exception('"barcode" value none empty');
            }
            else if(strlen($barcode) < 5){
                throw new Exception('"barcode" Length must not be less than 5 characters');
            }

            if(empty($image1)){
                throw new Exception('"image1" value none empty. Please write url');
            }

            try{

                $product_info[] = [
                    'categoryId' => $category_id,
                    'merchant'   => $this->request->merchant_id,
                    'attributes' => [
                        'merchantSku'    => $merchant_sku,
                        'Barcode'        => $barcode,
                        'price'          => $price,
                        'Marka'          => $brand,
                        'UrunAdi'        => $product_name,
                        "UrunAciklamasi" => $product_desc,
                        'Image1'         => $image1,
                        'Image2'         => $image2,
                        'Image3'         => $image3,
                        'Image4'         => $image4,
                        'Image5'         => $image5,
                        'GarantiSuresi'  => $warranty_period,
                        'kg'             => $kg,
                        'tax_vat_rate'   => $tax,
                        'stock'          => $stock,
                    ],
                ];

                $url = $this->url.'/product/api/products/import';

                $temp_file     = tempnam(sys_get_temp_dir(), 'products');
                $new_temp_file = sprintf('%s.json', $temp_file);
                rename($temp_file, $new_temp_file);
                $temp_file = $new_temp_file;
                file_put_contents($temp_file, json_encode($product_info));

                $data = [
                    'name'     => 'file',
                    'contents' => fopen($temp_file, 'rb'),
                    'headers'  => [
                        'Content-Type' => 'multipart/form-data',
                    ],
                ];

                $request = $this->request->post_multipart($url, $data);
                return json_decode($request['body']);
            }catch(Exception $err){
                print_r($err->getMessage());
            }
        }

        public function get_product_status($tracking_id = null, $page = 0, $size = 20){

            if(empty($tracking_id)){
                throw new Exception('"tracking_id" value none empty');
            }

            if(!is_numeric($page)){
                throw new Exception('"page" value none numaric');
            }

            if(!is_numeric($size)){
                throw new Exception('"size" value none numaric');
            }
            else if($size > 1000){
                throw new Exception('"size" cannot be greater than 1000');
            }
            else if($size < 0){
                throw new Exception('"size" cannot be less than 0');
            }

            try{
                $url     = $this->url.'/product/api/products/status/'.$tracking_id.'?page='.$page.'&size='.$size.'&version=1';
                $request = $this->request->get($url);
                return json_decode($request['body']);
            }catch(Exception $err){
                print_r($err->getMessage());
            }
        }

        public function get_tracking_history($page = 0, $size = 20){

            if(!is_numeric($page)){
                throw new Exception('"page" value none numaric');
            }

            if(!is_numeric($size)){
                throw new Exception('"size" value none numaric');
            }
            else if($size > 1000){
                throw new Exception('"size" cannot be greater than 1000');
            }
            else if($size < 0){
                throw new Exception('"size" cannot be less than 0');
            }

            try{
                $url     = $this->url.'/product/api/products/trackingId-history?version=2&page='.$page.'&size='.$size.'&sort=createdAt,desc';
                $request = $this->request->get($url);
                return json_decode($request['body']);
            }catch(Exception $err){
                print_r($err->getMessage());
            }

        }

    }