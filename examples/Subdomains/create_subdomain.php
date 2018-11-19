<?php

require_once("../config.php");

$params = array(
	'domain'=>'DALTCORE.co.uk',
	'subdomain'=>'test1',
	'www_root'=>'/subdomains/test1',
);

$request = new \DALTCORE\Plesk\CreateSubdomain($config, $params);
$info = $request->process();

var_dump($info);