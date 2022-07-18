<?php
include_once "../../config/includes.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    #@formatter:off
    $data = $_POST;
    $attr = [];
    $id   = $data['id'];
    $documento_id   = $data["documento_id"];

    unset($data["id"]);

    foreach ($data as $name => $value) {
        $attr[] = "{$name} = '" . mysqli_real_escape_string($con, $value) . "'";
    }

    $attr = implode(", ", $attr);

    if($id){
        $sql = "UPDATE vendedores SET {$attr} WHERE codigo = '{$id}' AND documento_id = '{$documento_id}'";
    }else{
        $sql = "INSERT into vendedores SET {$attr}";
    }

    if (mysqli_query($con, $sql)) {
        echo json_encode([
            "status" => true,
            "msg"    => "Dados salvo com sucesso",
            "sql" => $sql,
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

$documento_id = $_GET['documento_id'];
$id = $_GET['vendedor_id'];
$tipo_vendedor = $_GET['tipo_vendedor'];

$d = [];

if ($documento_id) {
    $result = mysqli_query($con, "SELECT * FROM vendedores v "
        . "WHERE v.codigo = '{$id}' AND v.documento_id = '{$documento_id}'");
    $d = mysqli_fetch_object($result);
}

?>

<form id="form-vendedor<?= $random ?>" class="needs-validation mb-2" novalidate>

    <input type="hidden" id="id" name="id" value="<?= $id; ?>">
    <input type="hidden" id="documento_id" name="documento_id" value="<?= $documento_id; ?>">
    <input type="hidden" id="tipo_vendedor" name="tipo_vendedor" value="<?= $tipo_vendedor; ?>">

    <div class="card rounded-0" style="width: 100%">

        <div class="card-header d-flex flex-row justify-content-between align-items-center border-bottom-0">
            <a data-bs-toggle="collapse"
               href="#collapseVendedor<?= $random ?>"
               role="button"
               aria-expanded="false"
               aria-controls="collapseVendedor"
               style="flex: 1"
            >
                Vendedor
            </a>
            <span>
                        <button type="submit" class="btn btn-outline-success btn-sm" style="z-index: 999">
                           <i class="fa-solid fa-floppy-disk"></i>
                        </button>

                        <button type="button" class="btn btn-outline-danger btn-sm">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </span>
        </div>

        <div class="card-body collapse" id="collapseVendedor<?= $random ?>">
            <div id="vendedor-container">

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome do vendedor <span
                                class="text-danger">*</span></label>
                    <input
                            type="text"
                            class="form-control"
                            id="nome"
                            name="nome"
                            aria-describedby="nome"
                            value="<?= $d->nome; ?>"
                            maxlength="80"
                            required

                    >
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="rg" class="form-label">RG <span
                                        class="text-danger">*</span></label>
                            <input
                                    type="text"
                                    class="form-control"
                                    id="rg"
                                    name="rg"
                                    aria-describedby="rg"
                                    value="<?= $d->rg; ?>"
                                    maxlength="20"
                                    required
                            >
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tipo<?= $random ?>" class="form-label">Tipo de vendedor <span
                                        class="text-danger">*</span></label>
                            <select class="form-control" id="tipo<?= $random ?>" name="tipo" required>
                                <option value=""></option>
                                <option value="f" <?= $d->tipo == 'f' ? 'selected' : ''; ?>>Pessoa física
                                </option>
                                <option value="j" <?= $d->tipo == 'j' ? 'selected' : ''; ?>>Pessoa jurídica
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3" id="container_cpf<?= $random ?>" style="display: none">
                    <label for="cpf" class="form-label">CPF <span class="text-danger">*</span></label>
                    <input
                            type="text"
                            class="form-control"
                            id="cpf<?= $random ?>"
                            name="cpf"
                            aria-describedby="cpf"
                            value="<?= $d->cpf; ?>"
                    >
                </div>

                <div class="mb-3" id="container_cnpj<?= $random ?>" style="display: none">
                    <label for="cnpj<?= $random ?>" class="form-label">CNPJ <span
                                class="text-danger">*</span></label>
                    <input
                            type="text"
                            class="form-control"
                            id="cnpj<?= $random ?>"
                            name="cnpj"
                            aria-describedby="cnpj"
                            value="<?= $d->cnpj; ?>"
                    >
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="inscricao_estadual" class="form-label">
                                Inscrição estadual
                            </label>
                            <input
                                    type="text"
                                    class="form-control"
                                    id="inscricao_estadual"
                                    name="inscricao_estadual"
                                    aria-describedby="inscricao_estadual"
                                    value="<?= $d->inscricao_estadual; ?>"
                                    maxlength="80"
                            >
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="inscricao_municipal" class="form-label">
                                Inscrição municipal
                            </label>
                            <input
                                    type="text"
                                    class="form-control"
                                    id="inscricao_municipal"
                                    name="inscricao_municipal"
                                    aria-describedby="inscricao_municipal"
                                    value="<?= $d->inscricao_municipal; ?>"
                                    maxlength="80"
                            >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado <span
                                        class="text-danger">*</span></label>
                            <select
                                    type="text"
                                    class="form-control"
                                    id="estado<?= $random ?>"
                                    name="estado"
                                    aria-describedby="estado"
                                    onchange="select_localidade('estado<?= $random ?>','cidade<?= $random ?>','cidades')"
                                    required
                            >
                                <option value=""></option>
                                <?php
                                $query_estados = "SELECT codigo, nome FROM aux_estados WHERE situacao = '1'";
                                $result = mysqli_query($con, $query_estados);
                                while ($row = mysqli_fetch_object($result)):?>
                                    <option
                                            value="<?= $row->codigo ?>"
                                        <?= $row->codigo == $d->estado ? 'selected' : ''; ?>
                                    ><?= $row->nome ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="cidade" class="form-label">Cidade <span
                                        class="text-danger">*</span></label>
                            <select
                                    class="form-control"
                                    id="cidade<?= $random ?>"
                                    name="cidade"
                                    aria-describedby="cidade"
                                    onchange="select_localidade('cidade<?= $random ?>','bairro<?= $random ?>','bairros')"
                                    required
                            >
                                <option value=""></option>
                                <?php
                                if ($d->estado) {
                                    $sql = "SELECT codigo, nome FROM aux_cidades WHERE estado = '{$d->estado}' AND situacao = '1'";
                                    $result = mysqli_query($con, $sql);

                                    while ($c = mysqli_fetch_object($result)):?>
                                        <option
                                                value="<?= $c->codigo ?>"
                                            <?= $c->codigo == $d->cidade ? 'selected' : '' ?>>
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
                            <label for="bairro" class="form-label">Bairro</label>
                            <select
                                    class="form-control"
                                    id="bairro<?= $random ?>"
                                    name="bairro"
                                    aria-describedby="bairro"
                                    maxlength="10"
                            >
                                <option value=""></option>
                                <?php
                                if ($d->cidade) {
                                    $sql = "SELECT codigo, nome FROM aux_bairros WHERE cidade = '{$d->cidade}' AND situacao = '1'";
                                    $result = mysqli_query($con, $sql);

                                    while ($b = mysqli_fetch_object($result)):?>
                                        <option
                                                value="<?= $b->codigo ?>"
                                            <?= $b->codigo == $d->bairro ? 'selected' : '' ?>>
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
                                <label for="rua" class="form-label">Rua</label>
                                <input
                                        type="text"
                                        class="form-control"
                                        name="rua"
                                        id="rua"
                                        aria-describedby="rua"
                                        value="<?= $d->rua; ?>"
                                        maxlength="80"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="numero" class="form-label">Número</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    id="numero"
                                    name="numero"
                                    aria-describedby="numero"
                                    value="<?= $d->numero; ?>"
                                    maxlength="20"
                            >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    id="telefone"
                                    name="telefone"
                                    aria-describedby="telefone"
                                    value="<?= $d->telefone; ?>"
                                    maxlength="20"
                            >
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="email" class="form-label">E-Mail</label>
                            <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    aria-describedby="email"
                                    value="<?= $d->email; ?>"
                                    maxlength="80"
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<script>
    function select_localidade(select, select_to, url) {
        let valor = $(`#${select}`).val();

        $.ajax({
            url: `./pages/lista/${url}.php`,
            method: 'POST',
            data: {valor},
            dataType: 'html',
            success: function (data) {
                $(`#${select_to}`).html(data);
            }
        });
    }

    function exibeCpfCnpj(valor) {
        if (valor === "f") {
            $("#container_cpf<?= $random ?>").show();
            $("#container_cnpj<?= $random ?>").hide();
            $("#cnpj<?= $random ?>").val('');
        } else if (valor === 'j') {
            $("#container_cnpj<?= $random ?>").show();
            $("#container_cpf<?= $random ?>").hide().val('');
            $("#cpf<?= $random ?>").val('');
        } else {
            $("#container_cnpj<?= $random ?>").hide().val('');
            $("#container_cpf<?= $random ?>").hide().val('');
            $("#cnpj<?= $random ?>").val('');
            $("#cpf<?= $random ?>").val('');
        }
    }

    exibeCpfCnpj("<?= $d->tipo?>");

    $(function () {
        /* ------ MASCARAS -------- */
        $('#cpf<?= $random ?>, #procurador_cpf').mask('000.000.000-00', {clearIfNotMatch: true});

        $('#telefone, #procurador_telefone').mask('(00) 90000-0000', {clearIfNotMatch: true});

        $('#cnpj<?= $random ?>').mask('00.000.000/0000-00', {reverse: true});
        /* ------ MASCARAS -------- */

        /* ------ VALIDAÇÕES -------- */
        var form = $("#form-vendedor<?= $random?>").validate({
            rules: {
                cpf: {
                    required: function (elem) {
                        return $("#tipo").val() === "f";
                    }
                },
                cnpj: {
                    required: function (elem) {
                        return $("#tipo").val() === "j";
                    }
                },

                procurador_nome: {
                    required: function (elem) {
                        return $("#procurador_check").is(":checked");
                    }
                },
                procurador_rg: {
                    required: function (elem) {
                        return $("#procurador_check").is(":checked");
                    }
                },
                procurador_cpf: {
                    required: function (elem) {
                        return $("#procurador_check").is(":checked");
                    }
                },
                procurador_estado: {
                    required: function (elem) {
                        return $("#procurador_check").is(":checked");
                    }
                },
                procurador_cidade: {
                    required: function (elem) {
                        return $("#procurador_check").is(":checked");
                    }
                }
            }
        });
        /* ------ VALIDAÇÕES -------- */

        $("#form-vendedor<?= $random?>").submit(function (e) {
            e.preventDefault();

            var doc_id = $("#documento_id").val();

            if (!form.valid()) return false;

            var formData = $(this).serializeArray();

            $.ajax({
                url: "./pages/cadastro_documento/_form_vendedor.php",
                type: "POST",
                data: formData,
                dataType: "JSON",
                success: function (data) {
                    //window.localStorage.setItem('doc_id', data.codigo);


                    $.alert({
                        title: "Aviso",
                        content: "Vendedor salvo com sucesso!",
                    });
                    /*$.ajax({
                        url: "./pages/cadastro_documento/comprador.php",
                        type: "GET",
                        data: {doc_id},
                        success: function (data) {
                            $(".content-pane").html(data);
                        }
                    });*/
                }
            });

            return false;

        });

        $("#tipo<?= $random ?>").change(function () {
            exibeCpfCnpj($(this).val())
        });

        $(".remover_vendedor").click(function () {

        });
    });
</script>