<?php

if ($_SERVER['HTTP_HOST'] === 'localhost') {
    define('DB_HOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_DATABASE', 'portal_escritura');
} else {
    define('DB_HOST', '206.81.10.165');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '53nh@D0B@nc0');
    define('DB_DATABASE', 'portal_escritura');
}

$con = mysqli_connect(HOST, USER, PASSWORD, DBNAME) or die(mysqli_error($con));

// Check connection
if (mysqli_connect_error($con)) {
    echo "Failed to connect to MySQL";
    exit();
}
