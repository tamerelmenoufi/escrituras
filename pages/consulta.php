<?php
include_once "./config/conf.php";

if ($_GET and isset($_GET['acao'])) {
    $data = $_GET;
    unset($data['url'], $data['acao']);

    $attr = [];

    foreach ($data as $name => $value) {
        $attr[] = "{$name} LIKE '%{$value}%'";
    }

    $attr = @implode("AND ", $attr);
    $sql = "SELECT * FROM documentos WHERE {$attr}";

    $result = mysqli_query($con, $sql);

}
?>
<style>
    .info {
        border: 1px solid rgba(var(--color-black-rgb), 0.1);
    }

    .table tbody tr td {
        font-size: 14px;
    }
</style>

<div class="container py-4">
    <h2 class="text-center mb-3">Consulta de documentos</h2>

    <div class="info p-4">
        <h4>Pesquisar</h4>
        <form method="GET">
            <input type="hidden" name="acao" value="pesquisar">

            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="mb-3">
                        <label for="estado" class="col-form-label">
                            Nome do comprador
                        </label>
                        <input
                                type="text"
                                class="form-control"
                                name="comprador_nome"
                                id="comprador_nome"
                                value="<?= $_GET['comprador_nome'] ?: '' ?>"
                        >
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="mb-3">
                        <label for="vendedor_nome" class="col-form-label">
                            Nome do vendedor
                        </label>
                        <input
                                type="text"
                                class="form-control"
                                name="vendedor_nome"
                                id="vendedor_nome"
                                value="<?= $_GET['vendedor_nome'] ?: '' ?>"
                        >
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="mb-3">
                        <label for="estado" class="col-form-label">
                            Endereço do imovél
                        </label>
                        <input
                                type="text"
                                class="form-control"
                                id="rua"
                                name="rua"
                                value="<?= $_GET['rua'] ?: '' ?>"
                        >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="mb-3">
                    <button type="submit" class="btn bg-primary float-end text-white">Pesquisar</button>
                </div>
            </div>
        </form>

    </div>

    <table class="my-5 table table-striped">
        <thead>
        <tr>
            <th class="text-center">Cartório</th>
            <th class="text-center">Comprador</th>
            <th class="text-center">Vendedor</th>
            <th class="text-center" style="width: 40%">Endereço</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (@mysqli_num_rows($result) and isset($_GET['acao'])) {
            while ($d = mysqli_fetch_object($result)) { ?>

                <tr>
                    <td class="text-center"><?= $d->cartorio; ?></td>
                    <td class="text-center"><?= $d->comprador_nome; ?></td>
                    <td class="text-center"><?= $d->vendedor_nome; ?></td>
                    <td class="text-center"><?= $d->rua ?></td>
                </tr>
            <?php }
        } else {
            ?>
            <tr>
                <td colspan="4" class="text-center">Nenhum resultado encontrado</td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>