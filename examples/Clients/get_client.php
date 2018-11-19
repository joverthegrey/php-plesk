<?php

require_once("../config.php");

$params = array(
    'id'=>4,
    //'username'=>'',
);

$request = new \DALTCORE\Plesk\GetClient($config, $params);
$info = $request->process();

var_dump($info);