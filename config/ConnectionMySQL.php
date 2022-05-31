<?php

error_reporting(E_ALL);

if ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '10.0.0.115') {
    define('HOST', 'localhost');
    define('USER', 'root');
    define('PASSWORD', '');
    define('DBNAME', 'portal_escritura');
} else {
    define('HOST', 'escrituras.mohatron.com');
    define('USER', 'root');
    define('PASSWORD', '53nh@D0B@nc0');
    define('DBNAME', 'portal_escritura');
}

$con = mysqli_connect(HOST, USER, PASSWORD, DBNAME) or die('Ocorreu erro na conexão'); //mysqli_error($con)

// Check connection
// if (mysqli_connect_error($con)) {
//     echo "Failed to connect to MySQL";
//     exit();
// }
