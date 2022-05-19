<?php

// ENDERECO DO SERVIDOR
const HOST = "localhost";
// NOME DO SCHEMA DB
const DBNAME = "portal_escritura";
// USUARIO
const USER = "root";
// SENHA
const PASSWORD = "";


$con = mysqli_connect(HOST, USER, PASSWORD, DBNAME) or die(mysqli_error($con));

// Check connection
/*if ($con->connect_errno) {
    echo "Failed to connect to MySQL: " . $con->connect_error;
    exit();
}*/