<?php
include_once "../../config/includes.php";

#@formatter:off
if ($_SERVER['REQUEST_METHOD'] === 'POST' and $_POST['acao'] === 'salvar') {
    $data = $_POST;
    $attr = [];
    $id   = $data['id'];
    $documento_id = $data["documento_id"];

    unset($data["id"], $data["acao"]);

    foreach ($data as $name => $value) {
        $attr[] = "{$name} = '" . mysqli_real_escape_string($con, $value) . "'";
    }

    $attr = implode(", ", $attr);

    if($id){
        $sql = "UPDATE vendedor_comprador SET {$attr} WHERE codigo = '{$id}' AND documento_id = '{$documento_id}'";
    }else{
        $sql = "INSERT into vendedor_comprador SET {$attr}";
    }

    if (mysqli_query($con, $sql)) {
        echo json_encode([
            "status" => true,
            "msg"    => "Dados salvo com sucesso!",
            "query"    => $sql,
        ]);
    } else {
        echo json_encode([
            "status"      => true,
            "msg"         => "Error ao salvar!",
            "mysql_error" => mysqli_error($con),
            "query"    => $sql,
        ]);
    }

    exit();

}

if($_SERVER['REQUEST_METHOD'] === 'POST' and $_POST['acao'] === 'excluir'){
    $codigo = $_POST['id'];

    $sql = "DELETE FROM vendedor_comprador WHERE codigo = '{$codigo}'";

    if(mysqli_query($con, $sql)){
        echo json_encode(['status' => true,'msg' => 'Excluído com sucesso!']);
    }else{
        echo json_encode(['status' => false,'msg' => 'Error ao excluir!']);
    }
    exit();
}


if($_GET['acao'] == 'novo'){
    echo $q = "INSERT INTO vendedor_comprador set documento_id = '{$_SESSION['id']}', tipo = 'c'";
    mysqli_query($con, $q);
    $_GET['comprador_id'] = mysqli_insert_id();
}

$documento_id = $_SESSION['id'];
$id           = $_GET['comprador_id'];
$tipo         = 'c';
#@formatter:on

$d = [];

if ($documento_id) {
    $result = mysqli_query($con, "SELECT * FROM vendedor_comprador "
        . "WHERE codigo = '{$id}' AND documento_id = '{$documento_id}'");
    $d = mysqli_fetch_object($result);
}

?>

<form id="form-comprador<?= $uniqued ?>" class="needs-validation mb-2" novalidate>

    <input type="hidden" id="id<?= $uniqued ?>" name="id" value="<?= $id; ?>">

    <input type="hidden" id="documento_id" name="documento_id" value="<?= $documento_id; ?>">

    <input type="hidden" id="tipo" name="tipo" value="<?= $tipo; ?>">

    <div class="card rounded-0" style="width: 100%">

        <div class="card-header d-flex flex-row justify-content-between align-items-center border-bottom-0 bg-white">
            <a data-bs-toggle="collapse"
               href="#collapseComprador<?= $uniqued ?>"
               role="button"
               aria-expanded="false"
               aria-controls="collapseComprador"
               style="flex: 1"
            >
                Comprador
            </a>
            <span>
                <button type="button" class="btn btn-outline-danger btn-sm remover_comprador<?= $uniqued ?>">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </span>
        </div>

        <div class="card-body collapse" id="collapseComprador<?= $uniqued ?>">
            <h5 class="text-center">Formulário Comprador</h5>

            <div id="comprador-container">

                <div id="comprador">
                    <div class="mb-3">
                        <label for="nome" class="form-label">
                            Nome do comprador <span class="text-danger">*</span>
                        </label>

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
                                <label for="rg" class="form-label">
                                    RG <span class="text-danger">*</span>
                                </label>
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
                                <label
                                        for="tipo_pessoa<?= $uniqued ?>"
                                        class="form-label">
                                    Tipo de pessoa <span class="text-danger">*</span>
                                </label>
                                <select
                                        class="form-control"
                                        id="tipo_pessoa<?= $uniqued ?>"
                                        name="tipo_pessoa"
                                        required
                                >
                                    <option value=""></option>
                                    <option value="f" <?= $d->tipo_pessoa == 'f' ? 'selected' : ''; ?>>
                                        Pessoa física
                                    </option>
                                    <option value="j" <?= $d->tipo_pessoa == 'j' ? 'selected' : ''; ?>>
                                        Pessoa jurídica
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3" id="container_cpf<?= $uniqued ?>" style="display: none">
                        <label for="cpf" class="form-label">CPF <span class="text-danger">*</span></label>
                        <input
                                type="text"
                                class="form-control"
                                id="cpf<?= $uniqued ?>"
                                name="cpf"
                                aria-describedby="cpf"
                                value="<?= $d->cpf; ?>"
                        >
                    </div>

                    <div class="mb-3" id="container_cnpj<?= $uniqued ?>" style="display: none">
                        <label for="cnpj<?= $uniqued ?>" class="form-label">
                            CNPJ <span class="text-danger">*</span>
                        </label>
                        <input
                                type="text"
                                class="form-control"
                                id="cnpj<?= $uniqued ?>"
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
                                <label for="estado" class="form-label">
                                    Estado <span class="text-danger">*</span>
                                </label>
                                <select
                                        type="text"
                                        class="form-control"
                                        id="estado<?= $uniqued ?>"
                                        name="estado"
                                        aria-describedby="estado"
                                        onchange="select_localidade('estado<?= $uniqued ?>','cidade<?= $uniqued ?>','cidades')"
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
                                <label for="cidade" class="form-label">
                                    Cidade <span class="text-danger">*</span>
                                </label>
                                <select
                                        class="form-control"
                                        id="cidade<?= $uniqued ?>"
                                        name="cidade"
                                        aria-describedby="cidade"
                                        onchange="select_localidade('cidade<?= $uniqued ?>','bairro<?= $uniqued ?>','bairros')"
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
                                <label for="bairro<?= $uniqued ?>" class="form-label">Bairro</label>
                                <select
                                        class="form-control"
                                        id="bairro<?= $uniqued ?>"
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

                <!-- Checkbox -->
                <div class="my-4">
                    <div class="form-check">
                        <input
                                class="form-check-input"
                                type="checkbox"
                                value=""
                                id="check_procurador<?= $uniqued ?>"
                                name="check_procurador"
                                onclick="exibiContainer(this,'comprador_procurador-container<?= $uniqued ?>')"
                        >
                        <label class="form-check-label" for="check_procurador<?= $uniqued ?>">
                            Comprador procurador?
                        </label>
                    </div>
                </div>
                <!-- Checkbox -->

                <div id="comprador_procurador-container<?= $uniqued ?>" style="display: none">
                    <h5 class="my-2 text-center">Comprador procurador</h5>

                    <div id="comprador-procurador">
                        <div class="mb-3">
                            <label for="procurador_nome" class="form-label">
                                Nome do comprador <span class="text-danger">*</span>
                            </label>
                            <input
                                    type="text"
                                    class="form-control"
                                    id="procurador_nome"
                                    name="procurador_nome"
                                    aria-describedby="procurador_nome"
                                    value="<?= $d->procurador_nome; ?>"
                                    maxlength="80"
                                    required
                            >
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="procurador_rg" class="form-label">
                                        RG <span class="text-danger">*</span>
                                    </label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            id="procurador_rg"
                                            name="procurador_rg"
                                            aria-describedby="procurador_rg"
                                            value="<?= $d->procurador_rg; ?>"
                                            maxlength="20"
                                            required
                                    >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label
                                            for="procurador_tipo_pessoa<?= $uniqued ?>"
                                            class="form-label">
                                        Tipo de pessoa <span class="text-danger">*</span>
                                    </label>
                                    <select
                                            class="form-control"
                                            id="procurador_tipo_pessoa<?= $uniqued ?>"
                                            name="procurador_tipo_pessoa"
                                            required
                                    >
                                        <option value=""></option>
                                        <option value="f" <?= $d->procurador_tipo_pessoa == 'f' ? 'selected' : ''; ?>>
                                            Pessoa física
                                        </option>
                                        <option value="j" <?= $d->procurador_tipo_pessoa == 'j' ? 'selected' : ''; ?>>
                                            Pessoa jurídica
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3" id="procurador_container_cpf<?= $uniqued ?>" style="display: none">
                            <label
                                    for="procurador_cpf"
                                    class="form-label">
                                CPF <span class="text-danger">*</span>
                            </label>
                            <input
                                    type="text"
                                    class="form-control"
                                    id="procurador_cpf<?= $uniqued ?>"
                                    name="procurador_cpf"
                                    aria-describedby="procurador_cpf"
                                    value="<?= $d->procurador_cpf; ?>"
                            >
                        </div>

                        <div class="mb-3" id="procurador_container_cnpj<?= $uniqued ?>" style="display: none">
                            <label for="procurador_cnpj<?= $uniqued ?>" class="form-label">
                                CNPJ <span class="text-danger">*</span>
                            </label>
                            <input
                                    type="text"
                                    class="form-control"
                                    id="procurador_cnpj<?= $uniqued ?>"
                                    name="procurador_cnpj"
                                    aria-describedby="procurador_cnpj"
                                    value="<?= $d->procurador_cnpj; ?>"
                            >
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="procurador_inscricao_estadual" class="form-label">
                                        Inscrição estadual
                                    </label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            id="procurador_inscricao_estadual"
                                            name="procurador_inscricao_estadual"
                                            aria-describedby="procurador_inscricao_estadual"
                                            value="<?= $d->procurador_inscricao_estadual; ?>"
                                            maxlength="80"
                                    >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="procurador_inscricao_municipal" class="form-label">
                                        Inscrição municipal
                                    </label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            id="procurador_inscricao_municipal"
                                            name="procurador_inscricao_municipal"
                                            aria-describedby="procurador_inscricao_municipal"
                                            value="<?= $d->procurador_inscricao_municipal; ?>"
                                            maxlength="80"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="procurador_estado" class="form-label">
                                        Estado <span class="text-danger">*</span>
                                    </label>
                                    <select
                                            type="text"
                                            class="form-control"
                                            id="procurador_estado<?= $uniqued ?>"
                                            name="procurador_estado"
                                            aria-describedby="procurador_estado"
                                            onchange="select_localidade('procurador_estado<?= $uniqued ?>','procurador_cidade<?= $uniqued ?>','cidades')"
                                            required
                                    >
                                        <option value=""></option>
                                        <?php
                                        $query_estados = "SELECT codigo, nome FROM aux_estados WHERE situacao = '1'";
                                        $result = mysqli_query($con, $query_estados);
                                        while ($row = mysqli_fetch_object($result)):?>
                                            <option
                                                    value="<?= $row->codigo ?>"
                                                <?= $row->codigo == $d->procurador_estado ? 'selected' : ''; ?>
                                            ><?= $row->nome ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="procurador_cidade<?= $uniqued ?>" class="form-label">
                                        Cidade <span class="text-danger">*</span>
                                    </label>
                                    <select
                                            class="form-control"
                                            id="procurador_cidade<?= $uniqued ?>"
                                            name="procurador_cidade"
                                            aria-describedby="procurador_cidade"
                                            onchange="select_localidade('procurador_cidade<?= $uniqued ?>','procurador_bairro<?= $uniqued ?>','bairros')"
                                            required
                                    >
                                        <option value=""></option>
                                        <?php
                                        if ($d->estado) {
                                            $sql = "SELECT codigo, nome FROM aux_cidades WHERE estado = '{$d->procurador_estado}' AND situacao = '1'";
                                            $result = mysqli_query($con, $sql);

                                            while ($c = mysqli_fetch_object($result)):?>
                                                <option
                                                        value="<?= $c->codigo ?>"
                                                    <?= $c->codigo == $d->procurador_cidade ? 'selected' : '' ?>>
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
                                    <label for="procurador_bairro" class="form-label">Bairro</label>
                                    <select
                                            class="form-control"
                                            id="procurador_bairro<?= $uniqued ?>"
                                            name="procurador_bairro"
                                            aria-describedby="procurador_bairro"
                                            maxlength="10"
                                    >
                                        <option value=""></option>
                                        <?php
                                        if ($d->cidade) {
                                            $sql = "SELECT codigo, nome FROM aux_bairros WHERE cidade = '{$d->procurador_cidade}' AND situacao = '1'";
                                            $result = mysqli_query($con, $sql);

                                            while ($b = mysqli_fetch_object($result)):?>
                                                <option
                                                        value="<?= $b->codigo ?>"
                                                    <?= $b->codigo == $d->procurador_bairro ? 'selected' : '' ?>>
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
                                        <label for="procurador_rua" class="form-label">Rua</label>
                                        <input
                                                type="text"
                                                class="form-control"
                                                name="procurador_rua"
                                                id="procurador_rua"
                                                aria-describedby="rua"
                                                value="<?= $d->procurador_rua; ?>"
                                                maxlength="80"
                                        >
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="procurador_numero" class="form-label">Número</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            id="procurador_numero"
                                            name="procurador_numero"
                                            aria-describedby="procurador_numero"
                                            value="<?= $d->procurador_numero; ?>"
                                            maxlength="20"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="procurador_telefone" class="form-label">Telefone</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            id="procurador_telefone"
                                            name="procurador_telefone"
                                            aria-describedby="procurador_telefone"
                                            value="<?= $d->procurador_telefone; ?>"
                                            maxlength="20"
                                    >
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="procurador_email" class="form-label">E-Mail</label>
                                    <input
                                            type="procurador_email"
                                            class="form-control"
                                            id="procurador_email"
                                            name="procurador_email"
                                            aria-describedby="procurador_email"
                                            value="<?= $d->procurador_email; ?>"
                                            maxlength="80"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="my-3 d-flex flex-row justify-content-center">
                    <button type="reset" class="btn btn-danger btn-sm me-1">
                        <i class="fa-solid fa-floppy-disk"></i> Limpar
                    </button>
                    <button type="submit" class="btn btn-success btn-sm ms-1">
                        <i class="fa-solid fa-floppy-disk"></i> Salvar
                    </button>
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
            $("#container_cpf<?= $uniqued ?>").show();
            $("#container_cnpj<?= $uniqued ?>").hide();
            $("#cnpj<?= $uniqued ?>").val('');
        } else if (valor === 'j') {
            $("#container_cnpj<?= $uniqued ?>").show();
            $("#container_cpf<?= $uniqued ?>").hide().val('');
            $("#cpf<?= $uniqued ?>").val('');
        } else {
            $("#container_cnpj<?= $uniqued ?>").hide().val('');
            $("#container_cpf<?= $uniqued ?>").hide().val('');
            $("#cnpj<?= $uniqued ?>").val('');
            $("#cpf<?= $uniqued ?>").val('');
        }
    }

    function exibeCpfCnpjProcurador(valor) {
        if (valor) {
            if (valor === "f") {
                $("#procurador_container_cpf<?= $uniqued ?>").show();
                $("#procurador_container_cnpj<?= $uniqued ?>").hide();
                $("#procurador_cnpj<?= $uniqued ?>").val('');
            } else if (valor === 'j') {
                $("#procurador_container_cnpj<?= $uniqued ?>").show();
                $("#procurador_container_cpf<?= $uniqued ?>").hide().val('');
                $("#procurador_cpf<?= $uniqued ?>").val('');
            } else {
                $("#procurador_container_cnpj<?= $uniqued ?>").hide().val('');
                $("#procurador_container_cpf<?= $uniqued ?>").hide().val('');
                $("#procurador_cnpj<?= $uniqued ?>").val('');
                $("#procurador_cpf<?= $uniqued ?>").val('');
            }
        }
    }

    function exibiContainer(input, id_container) {
        if ($(input).is(":checked")) {
            $(`#${id_container}`).show();
        } else {
            let container = $(`#${id_container}`);
            container.hide();
            container.find('input, select').val('');
        }
    }

    function initExibiContainer(value, id_container) {
        if (value === '1') $(`#${id_container}`).show();
    }

    initExibiContainer("<?= $d->check_procurador?>", "comprador_procurador-container<?= $uniqued ?>");
    exibeCpfCnpj("<?= $d->tipo_pessoa?>");
    exibeCpfCnpjProcurador("<?= $d->procurador_tipo_pessoa?>");

    $(function () {

        $("#check_procurador<?= $uniqued ?>").prop("checked", <?= $d->check_procurador ? true : false?>);

        /* ------ Mascaras -------- */
        $('#cpf<?= $uniqued ?>, #procurador_cpf<?= $uniqued ?>').mask('000.000.000-00', {clearIfNotMatch: true});

        $('#telefone, #procurador_telefone').mask('(00) 90000-0000', {clearIfNotMatch: true});

        $('#cnpj<?= $uniqued ?>').mask('00.000.000/0000-00', {reverse: true});
        /* ------ Mascaras -------- */

        /* ------ Validações -------- */
        var form = $("#form-comprador<?= $uniqued?>").validate({
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
                        return $("#check_procurador<?= $uniqued ?>").is(":checked");
                    }
                },
                procurador_rg: {
                    required: function (elem) {
                        return $("#check_procurador<?= $uniqued ?>").is(":checked");
                    }
                },
                procurador_cpf: {
                    required: function (elem) {
                        return $("#check_procurador<?= $uniqued ?>").is(":checked");
                    }
                },
                procurador_estado: {
                    required: function (elem) {
                        return $("#check_procurador<?= $uniqued ?>").is(":checked");
                    }
                },
                procurador_cidade: {
                    required: function (elem) {
                        return $("#check_procurador<?= $uniqued ?>").is(":checked");
                    }
                }

            }
        });
        /* ------ Validações -------- */

        $("#form-comprador<?= $uniqued?>").submit(function (e) {
            e.preventDefault();

            //var doc_id = $("#documento_id").val();

            if (!form.valid()) return false;

            var formData = $(this).serializeArray();

            formData.push({
                name: "check_procurador",
                value: $("#check_procurador<?= $uniqued ?>").is(":checked") ? 1 : 0,
            });

            formData.push({
                name: "acao",
                value: "salvar",
            });

            $.ajax({
                url: "./pages/documentos/_form_comprador.php",
                type: "POST",
                data: formData,
                dataType: "JSON",
                success: function (data) {

                    if (data.status) {
                        $.alert({
                            title: 'Sucesso',
                            content: data.query,
                            theme: 'bootstrap',
                            type: 'green',
                            icon: 'fa fa-check',
                        });
                    } else {
                        $.alert({
                            title: 'Erro',
                            content: data.msg,
                            theme: 'bootstrap',
                            type: 'red',
                            icon: 'fa fa-warning',
                        });
                    }

                }
            });

            return false;
        });

        $("#tipo_pessoa<?= $uniqued ?>").change(function () {
            exibeCpfCnpj($(this).val())
        });

        $("#procurador_tipo_pessoa<?= $uniqued ?>").change(function () {
            exibeCpfCnpjProcurador($(this).val())
        });



        $(".remover_comprador<?= $uniqued ?>").click(function () {
            var id = $("#id<?= $uniqued ?>").val();

            $.alert({
                title: 'Aviso',
                content: 'Deseja realmente excluir?',
                theme: 'bootstrap',
                type: 'red',
                icon: 'fa fa-warning',
                buttons: {
                    sim: {
                        text: 'Sim',
                        action: function () {

                            if (id) {
                                $.ajax({
                                    url: './pages/documentos/_form_comprador.php',
                                    method: 'post',
                                    dataType: 'json',
                                    data: {id, acao: 'excluir'},
                                    success: function (data) {
                                        if (data.status) {
                                            $.alert({
                                                title: 'Sucesso',
                                                content: data.msg,
                                                theme: 'bootstrap',
                                                type: 'green',
                                                icon: 'fa fa-check',
                                            });
                                            $("#form-comprador<?= $uniqued ?>").remove();
                                        } else {
                                            $.alert({
                                                title: 'Erro',
                                                content: data.msg,
                                                theme: 'bootstrap',
                                                type: 'red',
                                                icon: 'fa fa-warning',
                                            });
                                        }
                                    }
                                });
                            } else {
                                $("#form-comprador<?= $uniqued ?>").remove();

                                $.alert({
                                    title: 'Aviso',
                                    content: 'Excluído com sucesso!',
                                    theme: 'bootstrap',
                                    type: 'green',
                                    icon: 'fa fa-check',
                                });
                            }

                        },
                        btnClass: 'btn-red',
                    },
                    nao: {
                        text: 'Não',
                        action: function () {
                        }
                    }
                }
            })

        });



        $(".remover_procurador<?= $uniqued ?>").click(function () {
            var id = $("#id<?= $uniqued ?>").val();

            $.alert({
                title: 'Aviso',
                content: 'Deseja realmente excluir?',
                theme: 'bootstrap',
                type: 'red',
                icon: 'fa fa-warning',
                buttons: {
                    sim: {
                        text: 'Sim',
                        action: function () {
                            if (id) {
                                $.ajax({
                                    url: './pages/documentos/_form_comprador.php',
                                    method: 'post',
                                    dataType: 'json',
                                    data: {id, acao: 'excluir'},
                                    success: function (data) {
                                        if (data.status) {
                                            $.alert({
                                                title: 'Sucesso',
                                                content: data.msg,
                                                theme: 'bootstrap',
                                                type: 'green',
                                                icon: 'fa fa-check',
                                            });
                                            $("#form-comprador<?= $uniqued ?>").remove();
                                        } else {
                                            $.alert({
                                                title: 'Erro',
                                                content: data.msg,
                                                theme: 'bootstrap',
                                                type: 'red',
                                                icon: 'fa fa-warning',
                                            });
                                        }
                                    }
                                });
                            } else {
                                $("#form-comprador<?= $uniqued ?>").remove();

                                $.alert({
                                    title: 'Aviso',
                                    content: 'Excluído com sucesso!',
                                    theme: 'bootstrap',
                                    type: 'green',
                                    icon: 'fa fa-check',
                                });
                            }

                        },
                        btnClass: 'btn-red',
                    },
                    nao: {
                        text: 'Não',
                        action: function () {
                        }
                    }
                }
            })

        });
    });
</script>