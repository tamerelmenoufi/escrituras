<?php
include_once "../../config/includes.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    #@formatter:off
    $data = $_POST;
    $attr = [];
    $id   = $data["doc_id"];
    unset($data["doc_id"]);

    foreach ($data as $name => $value) {
        $attr[] = "{$name} = '" . mysqli_real_escape_string($con, $value) . "'";
    }

    $attr = implode(", ", $attr);

    if($id){
        $sql = "UPDATE documentos SET {$attr} WHERE codigo = '{$id}'";
    }else{
       echo json_encode([
           "status"      => true,
           "msg"         => "Error ao salvar",
           "mysql_error" => mysqli_error($con),
       ]);
       exit();
    }

    if (mysqli_query($con, $sql)) {
        echo json_encode([
            "status" => true,
            "msg"    => "Dados salvo com sucesso",
        ]);
    } else {
        echo json_encode([
            "status"      => true,
            "msg"         => "Error ao salvar",
            "query"       => $sql,
            "mysql_error" => mysqli_error($con),
        ]);
    }

    exit();
    #@formatter:on
}

$doc_id = $_GET['doc_id'];

$d = [];

if ($doc_id) {
    $result = mysqli_query($con, "SELECT * FROM documentos WHERE codigo = '{$doc_id}'");
    $d = mysqli_fetch_object($result);
}
?>
<form id="form-vendedor" class="needs-validation" novalidate>

    <div id="vendedor-container">
        <h4 class="my-2 text-center">Vendedor</h4>

        <div class="mb-3">
            <label for="vendedor_tipo" class="form-label">Tipo de vendedor</label>
            <select class="form-control" id="vendedor_tipo" name="vendedor_tipo">
                <option value=""></option>
                <option value="f" <?= $d->vendedor_tipo == 'f' ? 'selected' : ''; ?>>Pessoa física</option>
                <option value="j" <?= $d->vendedor_tipo == 'j' ? 'selected' : ''; ?>>Pessoa jurídica</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="vendedor_nome" class="form-label">Nome do vendedor</label>
            <input
                    type="text"
                    class="form-control"
                    id="vendedor_nome"
                    name="vendedor_nome"
                    aria-describedby="vendedor_nome"
                    value="<?= $d->vendedor_nome; ?>"

            >
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="vendedor_rg" class="form-label">RG</label>
                    <input
                            type="text"
                            class="form-control"
                            id="vendedor_rg"
                            name="vendedor_rg"
                            aria-describedby="vendedor_rg"
                            value="<?= $d->vendedor_rg; ?>"
                    >
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="vendedor_cpf" class="form-label">CPF</label>
                    <input
                            type="text"
                            class="form-control"
                            id="vendedor_cpf"
                            name="vendedor_cpf"
                            aria-describedby="vendedor_cpf"
                            value="<?= $d->vendedor_cpf; ?>"
                    >
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="vendedor_cnpj" class="form-label">CNPJ</label>
            <input
                    type="text"
                    class="form-control"
                    id="vendedor_cnpj"
                    name="vendedor_cnpj"
                    aria-describedby="vendedor_cnpj"
                    value="<?= $d->vendedor_cnpj; ?>"
            >
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="vendedor_inscricao_estadual" class="form-label">
                        Inscrição estadual

                    </label>
                    <input
                            type="text"
                            class="form-control"
                            id="vendedor_inscricao_estadual"
                            name="vendedor_inscricao_estadual"
                            aria-describedby="vendedor_inscricao_estadual"
                            value="<?= $d->vendedor_inscricao_estadual; ?>"
                    >
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="vendedor_inscricao_municipal" class="form-label">
                        Inscrição municipal
                    </label>
                    <input
                            type="text"
                            class="form-control"
                            id="vendedor_inscricao_municipal"
                            name="vendedor_inscricao_municipal"
                            aria-describedby="vendedor_inscricao_municipal"
                            value="<?= $d->vendedor_inscricao_municipal; ?>"
                    >
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="vendedor_estado" class="form-label">Estado</label>
                    <select
                            type="text"
                            class="form-control"
                            id="vendedor_estado"
                            name="vendedor_estado"
                            aria-describedby="vendedor_estado"
                            onchange="select_localidade('vendedor_estado','vendedor_cidade','cidades')"
                    >
                        <option value=""></option>
                        <?php
                        $query_estados = "SELECT * FROM aux_estados WHERE situacao = '1'";
                        $result = mysqli_query($con, $query_estados);
                        while ($row = mysqli_fetch_object($result)):?>
                            <option
                                    value="<?= $row->codigo ?>"
                                <?= $row->codigo == $d->vendedor_estado ? 'selected' : ''; ?>
                            ><?= $row->nome ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="vendedor_cidade" class="form-label">Cidade</label>
                    <select
                            class="form-control"
                            id="vendedor_cidade"
                            name="vendedor_cidade"
                            aria-describedby="vendedor_cidade"
                            onchange="select_localidade('vendedor_cidade','vendedor_bairro','bairros')"

                    >
                        <option value=""></option>
                        <?php
                        if ($d->vendedor_cidade) {
                            $sql = "SELECT * FROM aux_cidades WHERE estado = '{$d->vendedor_estado}' AND deletado != '1'";
                            $result = mysqli_query($con, $sql);

                            while ($c = mysqli_fetch_object($result)):?>
                                <option
                                        value="<?= $c->codigo ?>"
                                    <?= $c->codigo == $d->vendedor_estado ? 'select' : '' ?>>
                                    <?= $c->descricao ?>
                                </option>';
                            <?php endwhile;
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="vendedor_bairro" class="form-label">Bairro</label>
                    <select
                            class="form-control"
                            id="vendedor_bairro"
                            name="vendedor_bairro"
                            aria-describedby="vendedor_bairro"
                            value="<?= $d->vendedor_bairro; ?>"
                    >
                        <option value=""></option>
                        <?php
                        if ($d->vendedor_bairro) {
                            $sql = "SELECT * FROM aux_bairros WHERE cidade = '{$d->vendedor_cidade}' AND deletado != '1'";
                            $result = mysqli_query($con, $sql);

                            while ($b = mysqli_fetch_object($result)):?>
                                <option
                                        value="<?= $b->codigo ?>"
                                    <?= $b->codigo == $d->vendedor_bairro ? 'select' : '' ?>>
                                    <?= $b->descricao ?>
                                </option>';
                            <?php endwhile;
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="co-md-3">
                    <div class="mb-3">
                        <label for="vendedor_rua" class="form-label">Rua</label>
                        <input
                                type="text"
                                class="form-control"
                                name="vendedor_rua"
                                aria-describedby="vendedor_rua"
                                value="<?= $d->vendedor_rua; ?>"
                        >
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label for="vendedor_numero" class="form-label">Número</label>
                    <input
                            type="text"
                            class="form-control"
                            id="vendedor_numero"
                            name="vendedor_numero"
                            aria-describedby="vendedor_numero"
                            value="<?= $d->vendedor_numero; ?>"
                    >
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="vendedor_telefone" class="form-label">Telefone</label>
                    <input
                            type="text"
                            class="form-control"
                            id="vendedor_telefone"
                            name="vendedor_telefone"
                            aria-describedby="vendedor_telefone"
                            value="<?= $d->vendedor_telefone; ?>"
                    >
                </div>
            </div>
            <div class="col-md-8">
                <div class="mb-3">
                    <label for="vendedor_email" class="form-label">E-Mail</label>
                    <input
                            type="email"
                            class="form-control"
                            id="vendedor_email"
                            name="vendedor_email"
                            aria-describedby="vendedor_email"
                            value="<?= $d->vendedor_email; ?>"
                    >
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <div class="form-check">
            <input
                    class="form-check-input"
                    type="checkbox"
                    value=""
                    id="check-vendedor-procurador"
                    name="check-vendedor-procurador"
                    onclick="exibiContainer(this,'vendedor_procurador-container')"
            >
            <label class="form-check-label" for="check-vendedor-procurador">
                Vendedor procurador
            </label>
        </div>
    </div>

    <div id="vendedor_procurador-container" style="display: none">
        <h4 class="my-2 text-center">Vendedor procurador</h4>

        <div class="mb-3">
            <label for="vendedor_procurador_nome" class="form-label">Nome do vendedor</label>
            <input
                    type="text"
                    class="form-control"
                    id="vendedor_procurador_nome"
                    name="vendedor_procurador_nome"
                    aria-describedby="vendedor_procurador_nome"
                    value="<?= $d->vendedor_procurador_nome; ?>"
            >
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="vendedor_procurador_rg" class="form-label">RG</label>
                    <input
                            type="text"
                            class="form-control"
                            id="vendedor_procurador_rg"
                            name="vendedor_procurador_rg"
                            aria-describedby="vendedor_procurador_rg"
                            value="<?= $d->vendedor_procurador_rg; ?>"
                    >
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="vendedor_procurador_cpf" class="form-label">CPF</label>
                    <input
                            type="text"
                            class="form-control"
                            id="vendedor_procurador_cpf"
                            name="vendedor_procurador_cpf"
                            aria-describedby="vendedor_procurador_cpf"
                            value="<?= $d->vendedor_procurador_cpf; ?>"
                    >
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="vendedor_procurador_estado" class="form-label">Estado</label>
                    <select
                            type="text"
                            class="form-control"
                            id="vendedor_procurador_estado"
                            name="vendedor_procurador_estado"
                            aria-describedby="vendedor_procurador_estado"
                            onchange="select_localidade('vendedor_procurador_estado','vendedor_procurador_cidade','cidades')"
                    >
                        <option value=""></option>
                        <?php
                        $query_estados = "SELECT * FROM aux_estados WHERE situacao = '1'";
                        $result = mysqli_query($con, $query_estados);
                        while ($row = mysqli_fetch_object($result)):?>
                            <option
                                    value="<?= $row->codigo ?>"
                                <?= $row->codigo == $d->vendedor_procurador_estado ? 'selected' : '' ?>
                            ><?= $row->nome ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="vendedor_procurador_cidade" class="form-label">Cidade</label>
                    <select
                            class="form-control"
                            id="vendedor_procurador_cidade"
                            name="vendedor_procurador_cidade"
                            aria-describedby="vendedor_procurador_cidade"
                            onchange="select_localidade('vendedor_procurador_cidade','vendedor_procurador_bairro','bairros')"
                    >
                        <option value=""></option>

                        <?php
                        if ($d->vendedor_procurador_cidade) {
                            $sql = "SELECT * FROM aux_cidades WHERE estado = '{$d->vendedor_procurador_estado}' AND deletado != '1'";
                            $result = mysqli_query($con, $sql);

                            while ($c = mysqli_fetch_object($result)):?>
                                <option
                                        value="<?= $c->codigo ?>"
                                    <?= $c->codigo == $d->vendedor_procurador_cidade ? 'select' : '' ?>>
                                    <?= $c->descricao ?>
                                </option>';
                            <?php endwhile;
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="vendedor_procurador_bairro" class="form-label">Bairro</label>
                    <select
                            class="form-control"
                            id="vendedor_procurador_bairro"
                            name="vendedor_procurador_bairro"
                            aria-describedby="vendedor_procurador_bairro"
                    >
                        <option value=""></option>
                        <?php
                        if ($d->vendedor_bairro) {
                            $sql = "SELECT * FROM aux_bairros WHERE cidade = '{$d->vendedor_procurador_cidade}' AND deletado != '1'";
                            $result = mysqli_query($con, $sql);

                            while ($b = mysqli_fetch_object($result)):?>
                                <option
                                        value="<?= $b->codigo ?>"
                                    <?= $b->codigo == $d->vendedor_procurador_bairro ? 'select' : '' ?>>
                                    <?= $b->descricao ?>
                                </option>';
                            <?php endwhile;
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="co-md-3">
                    <div class="mb-3">
                        <label for="vendedor_procurador_rua" class="form-label">Rua</label>
                        <input
                                type="text"
                                class="form-control"
                                id="vendedor_procurador_rua"
                                name="vendedor_procurador_rua"
                                aria-describedby="vendedor_procurador_rua"
                                value="<?= $d->vendedor_procurador_rua; ?>"
                        >
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label for="vendedor_procurador_numero" class="form-label">Número</label>
                    <input
                            type="text"
                            class="form-control"
                            id="vendedor_procurador_numero"
                            name="vendedor_procurador_numero"
                            aria-describedby="vendedor_procurador_numero"
                            value="<?= $d->vendedor_procurador_numero; ?>"
                    >
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="vendedor_procurador_telefone"
                           class="form-label">Telefone</label>
                    <input
                            type="text"
                            class="form-control"
                            id="vendedor_procurador_telefone"
                            name="vendedor_procurador_telefone"
                            aria-describedby="vendedor_procurador_telefone"
                            value="<?= $d->vendedor_procurador_telefone; ?>"
                    >
                </div>
            </div>
            <div class="col-md-8">
                <div class="mb-3">
                    <label for="vendedor_procurador_email" class="form-label">E-Mail</label>
                    <input
                            type="text"
                            class="form-control"
                            id="vendedor_procurador_email"
                            name="vendedor_procurador_email"
                            aria-describedby="vendedor_procurador_email"
                            value="<?= $d->vendedor_procurador_email; ?>"
                    >
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <div class="row justify-content-between">
            <div class="col-auto">
                <button
                        voltar
                        type="button"
                        class="btn btn-secondary btn_prev"
                        data-enchanter="previous"
                >
                    Voltar
                </button>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary btn_next">Salvar</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(function () {
        $('#vendedor_cpf, #vendedor_comprador_cpf')
            .mask('000.000.000-00', {clearIfNotMatch: true});

        $('#vendedor_telefone, #vendedor_comprador_telefone')
            .mask('(00) 90000-0000', {clearIfNotMatch: true});

        var doc_id = window.localStorage.getItem('doc_id');

        $("button[voltar]").click(function () {
            $.ajax({
                url: "./pages/cadastro_documento/documento.php",
                data: {doc_id},
                success: function (data) {
                    $(".content-pane").html(data);
                }
            })
        });

        $("#form-vendedor").submit(function (e) {
            e.preventDefault();

            var form = $(this)[0];
            var isValid = form.checkValidity();

            if (!isValid) {
                form.classList.add('was-validated');
                return false;
            }

            var formData = $(this).serializeArray();

            if (doc_id) {
                formData.push({
                    name: "doc_id",
                    value: doc_id,
                });
            }

            $.ajax({
                url: "./pages/cadastro_documento/vendedor.php",
                type: "POST",
                data: formData,
                dataType: "JSON",
                success: function (data) {
                    //window.localStorage.setItem('doc_id', data.codigo);


                    $.ajax({
                        url: "./pages/cadastro_documento/comprador.php",
                        type: "GET",
                        data: {doc_id},
                        success: function (data) {
                            $(".content-pane").html(data);
                        }
                    });
                }
            });
        });
    });
</script>
