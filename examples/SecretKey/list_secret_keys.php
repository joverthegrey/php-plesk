<?php

require_once("../config.php");

$request = new \DALTCORE\Plesk\ListSecretKeys($config);
$info = $request->process();

var_dump($info);