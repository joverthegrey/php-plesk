<?php

require_once("../config.php");

$request = new \DALTCORE\Plesk\ListServicePlans($config);
$info = $request->process();

var_dump($info);