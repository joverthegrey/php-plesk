<?php

require_once("../config.php");

$request = new \DALTCORE\Plesk\ListIPAddresses($config);
$info = $request->process();

var_dump($info);