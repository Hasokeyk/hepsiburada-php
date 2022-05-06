<?php

    require "vendor/autoload.php";

    use Hasokeyk\Hepsiburada\Hepsiburada;

    $merchant_id = '5a83c57b-46e1-45f1-bc56-5d08a3c39b13';
    $username    = 'herkesaliyo_dev';
    $password    = 'Hb12345!';

    $hepsiburada = new Hepsiburada($merchant_id, $username, $password, true);
    //    $product = $hepsiburada->product->add_product('11111','test','test222','1');
    $product = $hepsiburada->catalog->add_single_product('test1', 'test1 açıklama', '40,99', '18', '18021982', 'Herkesaliyo', '0000', '11111', 'https://productimages.hepsiburada.net/s/27/552/10194862145586.jpg');
    print_r($product);