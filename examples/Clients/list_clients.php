<?php

require_once("../config.php");

$request = new \DALTCORE\Plesk\ListClients($config);
$info = $request->process();

var_dump($info);