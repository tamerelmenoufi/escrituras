<?php

$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
$host = $_SERVER['HTTP_HOST'] != 'localhost' ? '206.81.10.165/' : 'localhost/escrituras';
$base_url = $protocol . "://" . $host . '/';


if (session_id() === "") {
    session_start();
}

date_default_timezone_set('America/Manaus');