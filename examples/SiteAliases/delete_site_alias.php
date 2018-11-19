<?php

require_once("../config.php");

$params = array(
	'alias'=>'testalias2.example.com',
);

$request = new \DALTCORE\Plesk\DeleteSiteAlias($config, $params);
$info = $request->process();

var_dump($info);