<?php

$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
$host = $_SERVER['HTTP_HOST'] != 'localhost' ? 'escrituras.mohatron.com/' : 'localhost/escrituras';
$base_url = $protocol . "://" . $host . '/';

if (session_id() === "") {
    session_start();
}

date_default_timezone_set('America/Manaus');
header('Content-Type: text/html; charset=utf-8');