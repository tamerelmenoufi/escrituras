<?php

$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
$host = $_SERVER['HTTP_HOST'] != 'localhost' ? '206.81.10.165/' : 'localhost/escrituras/';
$base_url = $protocol . "://" . $host . '/';