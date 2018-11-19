<?php

require_once("../config.php");

$params = array(
    'name'=>'testsubdomain.example.com',
);

$request = new \DALTCORE\Plesk\GetSubdomain($config, $params);
$info = $request->process();

var_dump($info);