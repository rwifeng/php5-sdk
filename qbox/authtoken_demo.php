#!/usr/bin/env php
<?php

require_once('authtoken.php');

$QBOX_ACCESS_KEY = '<Please apply your access key>';
$QBOX_SECRET_KEY = '<Dont send your secret key to anyone>';

$opts = array(
    "scope"			=> "test_bucket",
    "expiresIn"		=> 3600,
    "callbackUrl"	=> "http://example.com/callback?a=b&d=c",
);

$upToken = QBox_MakeAuthToken($opts);

var_dump($upToken);


$domain = "test.qiniudn.com";
$params = array("expiresIn" => 3600, "pattern" => "$domain/*");

$dnToken = QBox_MakeDownloadToken($params);

$dnUrl = "http://$domain/file_key?token=".$dnToken;

echo file_get_contents($dnUrl);

