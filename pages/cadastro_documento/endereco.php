<?php
include_once "../../config/includes.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    #@formatter:off
    $data = $_POST;
    $attr = [];
    $id   = $data["doc_id"];

    $coordenadas_temp  = json_decode($data["coordenadas"], true) ?: [];
    $data["coordenadas_temp"] = json_encode($coordenadas_temp);

    unset($data["doc_id"], $data["local"]);

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
    $colunas = implode(", ", ["codigo", "estado", "cidade", "bairro", "cep", "rua"]);
    $result = mysqli_query($con, "SELECT {$colunas} FROM documentos WHERE codigo = '{$doc_id}'");
    $d = mysqli_fetch_object($result);
}
?>

<form id="form-endereco" class="needs-validation" novalidate>
    <h4 class="my-2 text-center">Endereco</h4>

    <div class="mb-3">
        <label for="estado" class="form-label">Estado</label>
        <select
                type="text"
                class="form-control"
                id="estado"
                name="estado"
                aria-describedby="estado"
                onchange="select_localidade('estado','cidade','cidades')"
        >
            <option value=""></option>
            <?php
            $query_estados = "SELECT * FROM aux_estados WHERE situacao = '1'";
            $result = mysqli_query($con, $query_estados);

            while ($row = mysqli_fetch_object($result)) : ?>
                <option
                        value="<?= $row->codigo ?>"
                    <?= $row->codigo == $d->estado ? 'selected' : '' ?>
                ><?= $row->nome ?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="cidade" class="form-label">Cidade</label>
        <select
                class="form-control"
                id="cidade"
                name="cidade"
                aria-describedby="cidade"
                onchange="select_localidade('cidade','bairro','bairros')"
        >
            <option value=""></option>

            <?php
            if ($d->cidade) {
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

    <div class="mb-3">
        <label for="bairro" class="form-label">Bairro</label>
        <select class="form-control" id="bairro" name="bairro" aria-describedby="bairro">
            <option value=""></option>

            <?php
            if ($d->bairro) {
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

    <div class="mb-3">
        <label for="cep" class="form-label">CEP</label>
        <input
                type="text"
                class="form-control"
                id="cep"
                name="cep"
                aria-describedby="cep"
                data-mask="00000-000"
                data-clearifnotmatch="true"
                value="<?= $d->cep; ?>"
        >
    </div>

    <div class="mb-3">
        <label for="rua" class="form-label">Logradouro</label>
        <input
                type="text"
                class="form-control"
                id="rua"
                name="rua"
                aria-describedby="rua"
                value="<?= $d->rua; ?>"
        >
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

    //google.maps.event.addDomListener(window, 'load', initialize);

    /* ---------------------------------------*/

    $(function () {

        local = '<?= $d->coordenadas; ?>';

        function initialize() {
            //@formatter:off
            var input = document.getElementById('rua');
            var autocomplete = new google.maps.places.Autocomplete(input);

            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var place = autocomplete.getPlace();

                place_endereco = place['formatted_address'];
                place_latitude = place.geometry.location.lat();
                place_longitude = place.geometry.location.lng();

                var geocoder = new google.maps.Geocoder();

                geocoder.geocode({
                    "address": place_endereco,
                    "region": "BR"
                }, (results, status) => {
                    if (status == google.maps.GeocoderStatus.OK) {

                        if (results[0]) {
                            let latitude = results[0].geometry.location.lat();
                            let longitude = results[0].geometry.location.lng();
                            let location = new google.maps.LatLng(latitude, longitude);

                            local = {"lat" : location.lat(), "lng" : location.lng()};

                            //console.log(local.lat());
                            /*marker.setPosition(location);
                            mapa.setCenter(location);
                            mapa.setZoom(18);

                            marker = new google.maps.Marker({
                                position: {
                                    lat: latitude,
                                    lng: longitude
                                },
                                map: mapa,
                                title: "TESTE",
                                draggable: true,
                            });*/

                            /*google.maps.event.addListener(marker, 'dragend', function(marker) {
                                var latLng = marker.latLng;
                                alert(`Lat ${latLng.lat()} & Lng ${latLng.lng()}`)
                            });*/

                        }
                    }
                });
            });
            //@formatter:on
        }

        initialize();

        var doc_id = window.localStorage.getItem('doc_id');

        $("button[voltar]").click(function () {
            $.ajax({
                url: "./pages/cadastro_documento/comprador.php",
                data: {doc_id},
                success: function (data) {
                    $(".content-pane").html(data);
                }
            })
        });

        $("#form-endereco").submit(function (e) {
            e.preventDefault();

            var form = $(this)[0];
            var isValid = form.checkValidity();


            if (!isValid) {
                form.classList.add('was-validated');
                return false;
            }

            var formData = $(this).serializeArray();

            formData.push({
                name: "coordenadas",
                value: JSON.stringify(local),
            });

            if (doc_id) {
                formData.push({
                    name: "doc_id",
                    value: doc_id,
                });
            }

            $.ajax({
                url: "./pages/cadastro_documento/endereco.php",
                type: "POST",
                data: formData,
                //dataType: "JSON",
                success: function (data) {
                    //window.localStorage.setItem('doc_id', data.codigo);

                    $.ajax({
                        url: "./pages/cadastro_documento/mapa.php",
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