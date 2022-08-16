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

    $sql = "UPDATE documentos SET {$attr} WHERE codigo = '{$id}'";

    if (@mysqli_query($con, $sql)) {

        echo json_encode([
            "status" => true,
            "msg"    => "Dados salvo com sucesso",
            "codigo" => $id,
            "sql" => $sql
        ]);
    } else {
        echo json_encode([
            "codigo" => $codigo,
            "status"      => true,
            "msg"         => "Error ao salvar",
            "query"       => $sql,
            "mysql_error" => mysqli_error($con),
        ]);
    }

    exit();
    #@formatter:on
}

$doc_id = $_SESSION['id'];

$d = [];

if ($doc_id) {
    $colunas = [
        "codigo",
        'cartorio',
        'tipo_documento',
        'tipo_imovel',
        'nivel_imovel',
        'resumo',
        'livro',
        'folha',
        'tipo_doc_cartorio',
        'registro',
        'data_registro'
    ];

    $colunas = implode(', ', $colunas);

    $result = mysqli_query($con, "SELECT {$colunas} FROM documentos WHERE codigo = '{$doc_id}'");
    $d = mysqli_fetch_object($result);
}

?>
<form id="form-documento">

    <input type="hidden" name="doc_id" value="<?= $doc_id; ?>" id="doc_id">



    <div class="mb-3">
        <label for="municipio_cartorio" class="form-label">município em foi lavrado a escritura <span
                    class="text-danger">*</span></label>
        <select
                class="form-control"
                id="municipio_cartorio"
                name="municipio_cartorio"
                aria-describedby="municipio_cartorio"
                required

        >
            <option value=""></option>
            <?php
            $query_municipio_cartorio = "SELECT * FROM aux_cidades WHERE estado = '3' ORDER BY nome";
            $result = mysqli_query($con, $query_municipio_cartorio);

            while ($row = mysqli_fetch_object($result)): ?>
                <option
                        value="<?= $row->codigo ?>"
                    <?= $row->codigo == $d->municipio_cartorio ? 'selected ' : ''; ?>
                >
                    <?= $row->nome ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>


    <div class="mb-3">
        <label for="cartorio" class="form-label">Cartório <span class="text-danger">*</span></label>
        <input
                type="text"
                class="form-control"
                id="cartorio"
                name="cartorio"
                aria-describedby="cartorio"
                value="<?= $d->cartorio; ?>"
                required
        >
    </div>

    <div class="mb-3">
        <label for="tipo_documento" class="form-label">Tipo de documento <span
                    class="text-danger">*</span></label>
        <select
                class="form-control"
                id="tipo_documento"
                name="tipo_documento"
                aria-describedby="tipo_documento"
                required

        >
            <option value=""></option>
            <?php
            $query_tipo_documento = "SELECT * FROM aux_tipo_documento WHERE deletado != '1' ORDER BY descricao";
            $result = mysqli_query($con, $query_tipo_documento);

            while ($row = mysqli_fetch_object($result)): ?>
                <option
                        value="<?= $row->codigo ?>"
                    <?= $row->codigo == $d->tipo_documento ? 'selected ' : ''; ?>
                >
                    <?= $row->descricao ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="mb-3">
        <div class="row">

            <div class="col-md-6">
                <label for="tipo_imovel" class="form-label">Tipo de Imóvel <span class="text-danger">*</span></label>
                <select
                        type="text"
                        class="form-control"
                        id="tipo_imovel"
                        name="tipo_imovel"
                        aria-describedby="tipo_imovel"
                        required
                >
                    <option value=""></option>
                    <?php
                    $query_tipo_imovel = "SELECT * FROM aux_tipo_imovel WHERE deletado != '1' ORDER BY descricao";
                    $result = mysqli_query($con, $query_tipo_imovel);

                    while ($row = mysqli_fetch_object($result)): ?>
                        <option
                                value="<?= $row->codigo ?>"
                            <?= $row->codigo == $d->tipo_imovel ? 'selected ' : ''; ?>
                        >
                            <?= $row->descricao ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label for="nivel_imovel" class="form-label">Nivel do imóvel</label>
                <input
                        type="number"
                        min="0"
                        class="form-control"
                        id="nivel_imovel"
                        name="nivel_imovel"
                        aria-describedby="nivel_imovel"
                        value="<?= $d->nivel_imovel; ?>"
                >
            </div>
        </div>

    </div>

    <div class="mb-3">
        <div class="row">

            <div class="col-md-4">
                <label for="tipo_doc_cartorio" class="form-label">Tipo</label>
                <select
                        class="form-control"
                        name="tipo_doc_cartorio"
                        id="tipo_doc_cartorio"
                >
                    <option value=""></option>
                    <option
                            value="termo"
                        <?= ($doc_id and $d->tipo_doc_cartorio == 'termo') ? 'selected' : '' ?>
                    >
                        Termo
                    </option>
                    <option
                            value="protocolo"
                        <?= ($doc_id and $d->tipo_doc_cartorio == 'protocolo') ? 'selected' : '' ?>
                    >
                        Protocolo
                    </option>
                </select>
            </div>

            <div class="col-md-4">
                <label for="registro" class="form-label">Registro</label>

                <input
                        type="text"
                        class="form-control"
                        id="registro"
                        name="registro"
                        aria-describedby="registro"
                        value="<?= $d->registro; ?>"
                        maxlength="30"
                >
            </div>

            <div class="col-md-4">
                <label for="data_registro" class="form-label">Data do registro</label>
                <input
                        type="date"
                        class="form-control"
                        id="data_registro"
                        name="data_registro"
                        aria-describedby="data_registro"
                        value="<?= $d->data_registro; ?>"
                >
            </div>
        </div>
    </div>

    <div class="mb-3">
        <div class="row">
            <div class="col-md-6">
                <label for="livro" class="form-label">
                    Livro
                </label>
                <input
                        type="text"
                        class="form-control"
                        id="livro"
                        name="livro"
                        aria-describedby="livro"
                        value="<?= $d->livro; ?>"
                >
            </div>

            <div class="col-md-6">
                <label for="folha" class="form-label">
                    Folha
                </label>
                <input
                        type="text"
                        class="form-control"
                        id="folha"
                        name="folha"
                        aria-describedby="folha"
                        value="<?= $d->folha; ?>"
                >
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label for="resumo" class="form-label">
            Resumo
        </label>
        <textarea
                class="form-control"
                id="resumo"
                name="resumo"
                aria-describedby="resumo"
                rows="2"
        ><?= $d->resumo; ?></textarea>
    </div>

    <br>

    <div class="mb-3">
        <div class="d-flex flex-row justify-content-between">
            <button type="button" class="btn bg-secondary text-white" onclick="window.history.back()">Voltar</button>
            <button type="submit" class="btn bg-primary btn_next text-white">Salvar</button>
        </div>
    </div>
</form>

<script>
    $(function () {
        var form = $("#form-documento").validate();

        $("#form-documento").submit(function (e) {
            e.preventDefault();

            if (!form.valid()) return false;

            var formData = $(this).serializeArray();

            $.ajax({
                url: "./pages/editar_documento/documento.php",
                type: "POST",
                data: formData,
                dataType: "JSON",
                success: function (data) {
                    //window.localStorage.setItem('doc_id', data.codigo);

                    if (data.status) {
                        $.ajax({
                            url: "./pages/editar_documento/vendedor.php",
                            type: "GET",
                            data: {doc_id: data.codigo},
                            success: function (data) {
                                $(".content-pane").html(data);
                            }
                        })
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

        });
    });
</script>