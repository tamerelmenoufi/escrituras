<?php
include './config/includes.php';


$colunas_array = [
    "vendedor_nome",
    "comprador_nome",
    "m.nome AS end_municipio",
    "b.nome AS end_bairro",
];

$colunas = implode(", ", $colunas_array);

$query = "SELECT {$colunas} FROM documentos d "
    . "LEFT JOIN aux_cidades m ON m.codigo = d.cidade "
    . "LEFT JOIN aux_bairros b ON b.codigo = d.bairro ";

$result = mysqli_query($con, $query);

?>

<div class="container py-4">
    <h1 class="text-center">Lista de cadastros</h1>

    <div>
        <table class="table table-bordered my-5">
            <thead style="border-width: 1px !important;">
            <tr>
                <th class="text-center" scope="col">Vendedor</th>
                <th class="text-center" scope="col">Comprador</th>
                <th class="text-center" scope="col">Município</th>
                <th class="text-center" scope="col">Bairro</th>
                <th class="text-center" scope="col">Status</th>
                <th class="text-center" scope="col" style="width: 10%">Ação</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($d = mysqli_fetch_object($result)): ?>
                <tr>
                    <td><?= $d->vendedor_nome ?></td>
                    <td><?= $d->comprador_nome ?></td>
                    <td><?= $d->end_municipio ?></td>
                    <td><?= $d->end_bairro ?></td>
                    <td>Pendente</td>
                    <td>
                        <button type="button" class="btn btn-light btn-sm">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button type="button" class="btn btn-light btn-sm">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>
