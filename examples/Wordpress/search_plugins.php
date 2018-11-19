<?php

require_once("../config.php");

/*
 * Enables
 */
$params = [
    'query' => 'Responsify',
];

$request = new \DALTCORE\Plesk\Wordpress\SearchPlugins($config, $params);

$info = $request->process();
var_dump($info);

if ($info === false) {
    var_dump($request->error->getMessage());
}
