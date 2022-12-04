<?php

    namespace Hasokeyk\Hepsiburada;

    use GuzzleHttp\Client;
    use GuzzleHttp\Exception\GuzzleException;

    class Request{

        public $merchant_id;
        public $username;
        public $password;

        public $client;
        public $headers = [];
        public $user_agent = 'Instagram 219.0.0.12.117 Android (25/7.1.2; 320dpi; 900x1600; xiaomi; Redmi Note 8 Pro; d2q; qcom; tr_TR; 346138365)';

        function __construct($merchant_id = null, $username = null, $password = null, $test_mode = false){

            $this->merchant_id = $merchant_id;
            $this->username    = $username;
            $this->password    = $password;

            $this->client = new Client([
                'verify'  => false,
                //'proxy'   => $this->proxy,
                'version' => 2,
            ]);
        }

        public function ready_header($user_cookie = false){

            $headers = [
                //'Content-Type'  => 'application/json',
                'User-Agent'    => $this->user_agent,
                'Authorization' => 'Basic '.$this->generate_credentials(),
                'merchantid'    => $this->merchant_id,
                'Accept'        => 'application/json',
            ];

            return $headers;
        }

        public function get($url = '', $headers = null, $cookie = true){
            try{
                $headers = $headers ?? $this->ready_header();
                $options = [
                    'headers' => $headers,
                    'version' => 2,
                    'curl'    => [
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
                    ],
                ];

                $res = $this->client->get($url, $options);
                return [
                    'status'  => 'ok',
                    'headers' => $res->getHeaders(),
                    'body'    => $res->getBody()->getContents(),
                ];
            }catch(GuzzleException $exception){
                return [
                    'status'  => 'fail',
                    'message' => $exception->getMessage() ?? 'Empty',
                    'headers' => $exception->getResponse()->getHeaders() ?? null,
                    'body'    => $exception->getResponse()->getBody()->getContents() ?? null,
                ];
            }
        }

        public function post($url = null, $post_data = null, $headers = null){
            try{

                $headers = $headers ?? $this->ready_header();
                $options = [
                    'headers'     => $headers,
                    'form_params' => ($post_data ?? null),
                    'version'     => 2,
                    'curl'        => [
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
                    ],
                ];

                $res = $this->client->post($url, $options);
                return [
                    'status'  => 'ok',
                    'headers' => $res->getHeaders() ?? null,
                    'body'    => $res->getBody()->getContents(),
                ];
            }catch(GuzzleException $exception){
                return [
                    'status'  => 'fail',
                    'message' => $exception->getMessage() ?? 'Empty',
                    'headers' => $exception->getResponse()->getHeaders() ?? null,
                    'body'    => $exception->getResponse()->getBody()->getContents() ?? null,
                ];
            }
        }

        public function post_body($url = null, $post_data = null, $headers = null){
            try{

                $headers = $headers ?? $this->ready_header();

                $headers['Content-Type'] = 'application/x-www-form-urlencoded';

                $options = [
                    'headers' => $headers,
                    'body'    => ($post_data ?? null),
                    'version' => 2,
                    'curl'    => [
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
                    ],
                ];

                $res = $this->client->post($url, $options);
                return [
                    'status'  => 'ok',
                    'headers' => $res->getHeaders() ?? null,
                    'body'    => $res->getBody()->getContents(),
                ];
            }catch(GuzzleException $exception){
                return [
                    'status'  => 'fail',
                    'message' => $exception->getMessage() ?? 'Empty',
                    'headers' => $exception->getResponse()->getHeaders() ?? null,
                    'body'    => $exception->getResponse()->getBody()->getContents() ?? null,
                ];
            }
        }

        public function post_multipart($url = null, $post_data = null, $headers = null){
            try{

                $headers = $headers ?? $this->ready_header();
                $options = [
                    'headers'   => $headers,
                    'multipart' => [
                        $post_data,
                    ],
                    'version'   => 2,
                    'curl'      => [
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
                    ],
                ];

                $res = $this->client->post($url, $options);
                return [
                    'status'  => 'ok',
                    'headers' => $res->getHeaders() ?? null,
                    'body'    => $res->getBody()->getContents(),
                ];
            }catch(GuzzleException $exception){
                return [
                    'status'  => 'fail',
                    'message' => $exception->getMessage() ?? 'Empty',
                    'headers' => $exception->getResponse()->getHeaders() ?? null,
                    'body'    => $exception->getResponse()->getBody()->getContents() ?? null,
                ];
            }
        }

        public function upload($url = null, $post_data = null, $headers = null){
            try{

                $headers = $headers ?? $this->ready_header();
                $options = [
                    'headers' => $headers,
                    'body'    => $post_data,
                    'version' => 2,
                    'curl'    => [
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
                    ],
                ];

                $res = $this->client->post($url, $options);
                return [
                    'status'  => 'ok',
                    'headers' => $res->getHeaders() ?? null,
                    'body'    => $res->getBody()->getContents(),
                ];
            }catch(GuzzleException $exception){
                return [
                    'status'  => 'fail',
                    'message' => $exception->getMessage() ?? 'Empty',
                    'headers' => $exception->getResponse()->getHeaders() ?? null,
                    'body'    => $exception->getResponse()->getBody()->getContents() ?? null,
                ];
            }
        }

        public function generate_credentials(){
            return base64_encode($this->username.':'.$this->password);
        }
    }