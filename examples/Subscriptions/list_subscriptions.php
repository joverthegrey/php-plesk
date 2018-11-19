<?php

require_once("../config.php");

/*
 * Lists all subscriptions, or if client_id is supplied lists only that clients subscriptions
 */
$params = array(
	//'client_id'=>'',
);

$request = new \DALTCORE\Plesk\ListSubscriptions($config, $params);
$info = $request->process();

var_dump($info);

if ($info === false) {
    var_dump($request->error);
}