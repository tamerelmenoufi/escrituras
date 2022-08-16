<?php

include_once "../../config/includes.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doc_id = $_SESSION['id'];;
    $file = $_FILES;

    $totalFile = count($file);

    for ($i = 0; $i < $totalFile; $i++):
        $tmpFilePath = $_FILES['arquivo']['tmp_name'][$i];

        if ($tmpFilePath != "") :
            $path = "../../storage/documentos";

            if (!is_dir("{$path}/{$doc_id}")) mkdir("{$path}/{$doc_id}");

            $newFilePath = "{$path}/{$doc_id}/{$file['arquivo']['name'][$i]}";

            if (move_uploaded_file($tmpFilePath, $newFilePath)) continue;

        endif;
    endfor;
    $retorno = ['status' => true];
    echo json_encode($retorno);
    exit();
}