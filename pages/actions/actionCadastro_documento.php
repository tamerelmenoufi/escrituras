<?php
include '../../config/includes.php';

$data = $_POST;
$attr = [];

foreach ($data as $name => $value) {
    $attr[] = "{$name} = '" . mysqli_real_escape_string($con, $value) . "'";
}

$attr = implode(', ', $attr);

$sql = "INSERT INTO documentos SET {$attr}";

if (mysqli_query($con, $sql)) {
    $_SESSION['alert'] = [
        "title" => "Sucesso",
        "content" => "Documento salvo com sucesso"
    ];

    echo "ok";
} else {
    $_SESSION['alert'] = [
        "title" => "Error",
        "content" => "Error ao salvar documento"
    ];
    echo $sql." | errorXXX";
}

exit();