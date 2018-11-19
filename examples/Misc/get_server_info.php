<?php

require_once("../config.php");

$request = new \DALTCORE\Plesk\GetServerInfo($config);
$info = $request->process();

var_dump($info);