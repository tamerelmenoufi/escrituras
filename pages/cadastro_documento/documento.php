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

    if(!$id){
        $sql = "INSERT INTO documentos SET {$attr}";
    }else{
        $sql = "UPDATE documentos SET {$attr} WHERE codigo = '{$id}'";
    }

    if (mysqli_query($con, $sql)) {
        $codigo = $id ?:mysqli_insert_id($con);

        echo json_encode([
            "status" => true,
            "msg"    => "Dados salvo com sucesso",
            "codigo" => $codigo,
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

$doc_id = $_GET['doc_id'];

$d = [];

if ($doc_id) {
    $result = mysqli_query($con, "SELECT * FROM documentos WHERE codigo = '{$doc_id}'");
    $d = mysqli_fetch_object($result);
}

?>
<form id="form-documento">
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
        <label for="tipo_documento" class="form-label">Tipo de documento <span class="text-danger">*</span></label>
        <select
                class="form-control"
                id="tipo_documento"
                name="tipo_documento"
                aria-describedby="tipo_documento"
                required

        >
            <option value=""></option>
            <?php
            $query_tipo_documento = "SELECT * FROM aux_tipo_documento WHERE deletado != '1'";
            $result = mysqli_query($con, $query_tipo_documento);

            while ($row = mysqli_fetch_object($result)): ?>
                <option
                        value="<?= $row->codigo ?>"
                    <?= $row->codigo = $d->tipo_documento ? 'selected ' : ''; ?>
                >
                    <?= $row->descricao ?>
                </option>
            <?php endwhile; ?>
        </select>

    </div>

    <div class="mb-3">
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
            $query_tipo_imovel = "SELECT * FROM aux_tipo_imovel WHERE deletado != '1'";
            $result = mysqli_query($con, $query_tipo_imovel);

            while ($row = mysqli_fetch_object($result)): ?>
                <option
                        value="<?= $row->codigo ?>"
                    <?= $row->codigo = $d->tipo_imovel ? 'selected ' : ''; ?>
                >
                    <?= $row->descricao ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="mb-3">
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

    <div class="mb-3">
        <div class="d-flex flex-row justify-content-end">
            <button type="submit" class="btn bg-primary btn_next">Salvar</button>
        </div>
    </div>
</form>

<script>
    $(function () {
        var form = $("#form-documento").validate();

        var doc_id = window.localStorage.getItem('doc_id');

        $("#form-documento").submit(function (e) {
            e.preventDefault();

            if (!form.valid()) return false;

            var formData = $(this).serializeArray();

            if (doc_id) {
                formData.push({
                    name: "doc_id",
                    value: doc_id,
                });
            }

            $.ajax({
                url: "./pages/cadastro_documento/documento.php",
                type: "POST",
                data: formData,
                dataType: "JSON",
                success: function (data) {
                    window.localStorage.setItem('doc_id', data.codigo);

                    $.ajax({
                        url: "./pages/cadastro_documento/vendedor.php",
                        type: "GET",
                        data: {doc_id: data.codigo},
                        success: function (data) {
                            $(".content-pane").html(data);
                        }
                    })
                }
            });

        });
    });
</script>