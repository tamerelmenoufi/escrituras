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

<form id="form-comprador" class="needs-validation" novalidate>
    <div id="comprador-container">
        <h4 class="my-2 text-center">Comprador</h4>

        <div class="mb-3">
            <label for="comprador_nome" class="form-label">Nome do comprador <span class="text-danger">*</span></label>
            <input
                    type="text"
                    class="form-control"
                    id="comprador_nome"
                    name="comprador_nome"
                    aria-describedby="comprador_nome"
                    value="<?= $d->comprador_nome ?>"
                    required
            >
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="comprador_rg" class="form-label">RG <span class="text-danger">*</span></label>
                    <input
                            type="text"
                            class="form-control"
                            id="comprador_rg"
                            name="comprador_rg"
                            aria-describedby="comprador_rg"
                            value="<?= $d->comprador_rg ?>"
                            required
                    >
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="comprador_tipo" class="form-label">Tipo de comprador <span class="text-danger">*</span></label>

                    <select class="form-control" id="comprador_tipo" name="comprador_tipo" required>
                        <option value=""></option>
                        <option value="f" <?= $d->comprador_tipo == 'f' ? 'selected' : ''; ?>>Pessoa física</option>
                        <option value="j" <?= $d->comprador_tipo == 'j' ? 'selected' : ''; ?>>Pessoa jurídica</option>
                    </select>
                </div>
            </div>
        </div>


        <div class="mb-3" id="container_comprador_cpf">
            <label for="comprador_cpf" class="form-label">CPF <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="comprador_cpf" name="comprador_cpf"
                   aria-describedby="comprador_cpf" value="<?= $d->comprador_cpf ?>">
        </div>


        <div class="mb-3" id="container_comprador_cnpj">
            <label for="comprador_cnpj" class="form-label">CNPJ <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="comprador_cnpj" name="comprador_cnpj"
                   aria-describedby="comprador_cnpj" value="<?= $d->comprador_cnpj ?>">
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="comprador_inscricao_estadual" class="form-label">Inscrição
                        estadual</label>
                    <input
                            type="text"
                            class="form-control"
                            id="comprador_inscricao_estadual"
                            name="comprador_inscricao_estadual"
                            aria-describedby="comprador_inscricao_estadual"
                            maxlength="80"
                            value="<?= $d->comprador_inscricao_estadual ?>"
                    >
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="comprador_inscricao_municipal" class="form-label">Inscrição
                        municipal</label>
                    <input
                            type="text"
                            class="form-control"
                            name="comprador_inscricao_municipal"
                            id="comprador_inscricao_municipal"
                            maxlength="80"
                            aria-describedby="comprador_inscricao_municipal"
                            value="<?= $d->comprador_inscricao_municipal ?>"
                    >
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="comprador_estado" class="form-label">Estado <span class="text-danger">*</span></label>
                    <select type="text" class="form-control" id="comprador_estado" name="comprador_estado"
                            aria-describedby="comprador_estado"
                            onchange="select_localidade('comprador_estado','comprador_cidade','cidades')"
                            required
                    >
                        <option value=""></option>
                        <?php
                        $query_estados = "SELECT codigo, nome FROM aux_estados WHERE situacao = '1'";
                        $result = mysqli_query($con, $query_estados);
                        while ($row = mysqli_fetch_object($result)) : ?>
                            <option
                                    value="<?= $row->codigo ?>"
                                <?= ($row->codigo == $d->comprador_estado) ? 'selected' : '' ?>
                            ><?= $row->nome ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="comprador_cidade" class="form-label">Cidade <span class="text-danger">*</span></label>
                    <select class="form-control" id="comprador_cidade" name="comprador_cidade"
                            aria-describedby="comprador_cidade"
                            onchange="select_localidade('comprador_cidade','comprador_bairro','bairros')"
                            required
                    >
                        <option value=""></option>

                        <?php
                        if ($d->comprador_estado) {
                            $sql = "SELECT codigo, nome FROM aux_cidades WHERE estado = '{$d->comprador_estado}' AND situacao = '1'";
                            $result = mysqli_query($con, $sql);

                            while ($c = mysqli_fetch_object($result)):?>
                                <option
                                        value="<?= $c->codigo ?>"
                                    <?= $c->codigo == $d->comprador_cidade ? 'selected' : '' ?>>
                                    <?= $c->nome ?>
                                </option>
                            <?php endwhile;
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="comprador_bairro" class="form-label">Bairro</label>
                    <select class="form-control" id="comprador_bairro" name="comprador_bairro"
                            aria-describedby="comprador_bairro">
                        <option value=""></option>

                        <?php
                        if ($d->comprador_cidade) {
                            $sql = "SELECT codigo, nome FROM aux_bairros WHERE cidade = '{$d->comprador_cidade}' AND situacao = '1'";
                            $result = mysqli_query($con, $sql);

                            while ($b = mysqli_fetch_object($result)):?>
                                <option
                                        value="<?= $b->codigo ?>"
                                    <?= $b->codigo == $d->comprador_bairro ? 'selected' : '' ?>>
                                    <?= $b->nome ?>
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
                        <label for="comprador_rua" class="form-label">Rua</label>
                        <input type="text" class="form-control" id="comprador_rua" name="comprador_rua"
                               aria-describedby="comprador_rua" value="<?= $d->comprador_rua; ?>" maxlength="80">
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label for="comprador_numero" class="form-label">Número</label>
                    <input type="text" class="form-control" id="comprador_numero" name="comprador_numero"
                           aria-describedby="comprador_numero" value="<?= $d->comprador_numero; ?>" maxlength="20">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="comprador_telefone" class="form-label">Telefone</label>
                    <input type="text" class="form-control" id="comprador_telefone" name="comprador_telefone"
                           aria-describedby="comprador_telefone" value="<?= $d->comprador_telefone; ?>" maxlength="20">
                </div>
            </div>
            <div class="col-md-8">
                <div class="mb-3">
                    <label for="comprador_email" class="form-label">E-Mail</label>
                    <input type="text" class="form-control" id="comprador_email" name="comprador_email"
                           aria-describedby="comprador_email" value="<?= $d->comprador_email; ?>" maxlength="80">
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
                    id="comprador_procurador_check"
                    name="comprador_procurador_check"
                    onclick="exibiContainer(this,'comprador-procurador-container')"
            >
            <label class="form-check-label" for="comprador_procurador_check">
                Comprador procurador?
            </label>
        </div>
    </div>

    <div id="comprador-procurador-container" style="display: none">
        <h4 class="my-2 text-center">Comprador procurador</h4>

        <div class="mb-3">
            <label for="comprador_procurador_nome" class="form-label">Nome do comprador <span
                        class="text-danger">*</span></label>
            <input type="text" class="form-control" id="comprador_procurador_nome" name="comprador_procurador_nome"
                   aria-describedby="comprador_procurador_nome" value="<?= $d->comprador_procurador_nome; ?>"
                   maxlength="80">
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="comprador_procurador_rg" class="form-label">RG <span
                                class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="comprador_procurador_rg" name="comprador_procurador_rg"
                           aria-describedby="comprador_procurador_rg" value="<?= $d->comprador_procurador_rg; ?>"
                           maxlength="20">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="comprador_procurador_cpf" class="form-label">CPF <span
                                class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="comprador_procurador_cpf"
                           name="comprador_procurador_cpf"
                           aria-describedby="comprador_procurador_cpf" value="<?= $d->comprador_procurador_cpf; ?>"
                           maxlength="20">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="comprador_procurador_estado" class="form-label">Estado <span
                                class="text-danger">*</span></label>
                    <select type="text" class="form-control" id="comprador_procurador_estado"
                            name="comprador_procurador_estado" aria-describedby="comprador_procurador_estado"
                            onchange="select_localidade('comprador_procurador_estado','comprador_procurador_cidade','cidades')">
                        <option value=""></option>
                        <?php
                        $query_estados = "SELECT codigo, nome FROM aux_estados WHERE situacao = '1'";
                        $result = mysqli_query($con, $query_estados);
                        while ($row = mysqli_fetch_object($result)) : ?>
                            <option
                                    value="<?= $row->codigo ?>"
                                <?= $row->codigo == $d->comprador_procurador_estado ? 'selected' : ''; ?>
                            ><?= $row->nome ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="comprador_procurador_cidade" class="form-label">Cidade <span
                                class="text-danger">*</span></label>
                    <select class="form-control" id="comprador_procurador_cidade" name="comprador_procurador_cidade"
                            aria-describedby="comprador_procurador_cidade"
                            onchange="select_localidade('comprador_procurador_cidade','comprador_procurador_bairro','bairros')">
                        <option value=""></option>

                        <?php
                        if ($d->comprador_procurador_estado) {
                            $sql = "SELECT codigo, nome FROM aux_cidades WHERE estado = '{$d->comprador_procurador_estado}' AND situacao = '1'";
                            $result = mysqli_query($con, $sql);

                            while ($c = mysqli_fetch_object($result)):?>
                                <option
                                        value="<?= $c->codigo ?>"
                                    <?= $c->codigo == $d->comprador_procurador_cidade ? 'selected' : '' ?>>
                                    <?= $c->nome ?>
                                </option>';
                            <?php endwhile;
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="comprador_procurador_bairro" class="form-label">Bairro</label>
                    <select class="form-control" id="comprador_procurador_bairro" name="comprador_procurador_bairro"
                            aria-describedby="comprador_procurador_bairro">
                        <option value=""></option>

                        <?php
                        if ($d->comprador_procurador_cidade) {
                            $sql = "SELECT codigo, nome FROM aux_bairros WHERE cidade = '{$d->comprador_procurador_cidade}' AND situacao = '1'";
                            $result = mysqli_query($con, $sql);

                            while ($b = mysqli_fetch_object($result)):?>
                                <option
                                        value="<?= $b->codigo ?>"
                                    <?= $b->codigo == $d->comprador_procurador_bairro ? 'selected' : '' ?>>
                                    <?= $b->nome ?>
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
                        <label for="comprador_procurador_rua" class="form-label">Rua</label>
                        <input type="text" class="form-control" id="comprador_procurador_rua"
                               name="comprador_procurador_rua" aria-describedby="comprador_procurador_rua"
                               value="<?= $d->comprador_procurador_rua; ?>" maxlength="80">
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label for="comprador_procurador_numero" class="form-label">Número</label>
                    <input type="text" class="form-control" id="comprador_procurador_numero"
                           name="comprador_procurador_numero" aria-describedby="comprador_procurador_numero"
                           value="<?= $d->comprador_procurador_numero; ?>"
                           maxlength="20"
                    >
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="comprador_procurador_telefone" class="form-label">Telefone</label>
                    <input type="text" class="form-control" id="comprador_procurador_telefone"
                           name="comprador_procurador_telefone" aria-describedby="comprador_procurador_telefone"
                           value="<?= $d->comprador_procurador_telefone; ?>"
                           maxlength="20"
                    >
                </div>
            </div>
            <div class="col-md-8">
                <div class="mb-3">
                    <label for="comprador_procurador_email" class="form-label">E-Mail</label>
                    <input type="text" class="form-control" id="comprador_procurador_email"
                           name="comprador_procurador_email" aria-describedby="comprador_procurador_email"
                           value="<?= $d->comprador_procurador_email; ?>"
                           maxlength="80"
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
        $("#comprador_procurador_check").prop("checked", <?= $d->comprador_procurador_check ? true : false?>);

        /* ------ VALIDAÇÕES -------- */
        var form = $("#form-comprador").validate({
            rules: {
                comprador_cpf: {
                    required: function (elem) {
                        return $("#comprador_tipo").val() === "f";
                    }
                },
                comprador_cnpj: {
                    required: function (elem) {
                        return $("#comprador_tipo").val() === "j";
                    }
                },

                comprador_procurador_nome: {
                    required: function (elem) {
                        return $("#comprador_procurador_check").is(":checked");
                    }
                },
                comprador_procurador_rg: {
                    required: function (elem) {
                        return $("#comprador_procurador_check").is(":checked");
                    }
                },
                comprador_procurador_cpf: {
                    required: function (elem) {
                        return $("#comprador_procurador_check").is(":checked");
                    }
                },
                comprador_procurador_estado: {
                    required: function (elem) {
                        return $("#comprador_procurador_check").is(":checked");
                    }
                },
                comprador_procurador_cidade: {
                    required: function (elem) {
                        return $("#comprador_procurador_check").is(":checked");
                    }
                }
            }
        });
        /* ------ VALIDAÇÕES -------- */

        initExibiContainer("<?= $d->comprador_procurador_check?>", "comprador-procurador-container");

        exibeCpfCnpj("<?= $d->comprador_tipo?>");

        $("#comprador_tipo").change(function () {
            exibeCpfCnpj($(this).val())
        });

        function exibeCpfCnpj(valor) {
            if (valor === "f") {
                $("#container_comprador_cpf").show();
                $("#container_comprador_cnpj").hide();
                $("#comprador").val('');
            } else if (valor === 'j') {
                $("#container_comprador_cnpj").show();
                $("#container_comprador_cpf").hide().val('');
                $("#comprador").val('');
            } else {
                $("#container_comprador_cnpj").hide().val('');
                $("#container_comprador_cpf").hide().val('');
                $("#comprador").val('');
                $("#comprador").val('');
            }
        }

        $('#comprador_cpf, #comprador_procurador_cpf').mask('000.000.000-00', {clearIfNotMatch: true});

        $('#comprador_telefone, #comprador_procurador_telefone').mask('(00) 90000-0000', {clearIfNotMatch: true});

        var doc_id = window.localStorage.getItem('doc_id');

        $("button[voltar]").click(function () {
            $.ajax({
                url: "./pages/cadastro_documento/vendedor.php",
                data: {doc_id},
                success: function (data) {
                    $(".content-pane").html(data);
                }
            })
        });

        $("#form-comprador").submit(function (e) {
            e.preventDefault();

            if (!form.valid()) return false;

            var formData = $(this).serializeArray();

            if (doc_id) {
                formData.push({
                    name: "doc_id",
                    value: doc_id,
                });
            }

            formData.push({
                name: "comprador_procurador_check",
                value: $("#comprador_procurador_check").is(":checked") ? 1 : 0,
            });

            console.log($("#comprador_procurador_check").is(":checked"))
            $.ajax({
                url: "./pages/cadastro_documento/comprador.php",
                type: "POST",
                data: formData,
                dataType: "JSON",
                success: function (data) {
                    //window.localStorage.setItem('doc_id', data.codigo);

                    $.ajax({
                        url: "./pages/cadastro_documento/endereco.php",
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