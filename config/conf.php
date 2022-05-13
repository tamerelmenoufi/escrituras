<?php

$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
$host = $_SERVER['HTTP_HOST'] != 'localhost' ?: 'localhost/escrituras/';
$base_url = $protocol . "://" . $host . '/';