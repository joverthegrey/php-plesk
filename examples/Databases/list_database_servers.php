<?php

require_once("../config.php");

/*
 * Lists all database servers
 */
$request = new \DALTCORE\Plesk\ListDatabaseServers($config);
$info = $request->process();

var_dump($info);