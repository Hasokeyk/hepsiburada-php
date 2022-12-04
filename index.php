<?php

    require "vendor/autoload.php";

    use Hasokeyk\Hepsiburada\Hepsiburada;

    $merchant_id = '5a83c57b-46e1-45f1-bc56-5d08a3c39b13';
    $username    = 'herkesaliyo_dev';
    $password    = 'Hb12345!';

    $hepsiburada = new Hepsiburada($merchant_id, $username, $password, true);

    $list = $hepsiburada->listing->update_product_price('HBV0000104HI3',null,1);

    print_r($list);