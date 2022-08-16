<?php
include_once "../../config/includes.php";

//Ação que atualiza as coordendas no banco de dados
if ($_POST['acao'] == 'coordenadas') {
    $coordendas = '{"lat":' . $_POST['lat'] . ', "lng": ' . $_POST['lng'] . '}';
    $q = "UPDATE documentos SET coordenadas = '{$coordendas}' WHERE codigo = '{$_POST['codigo']}'";
    mysqli_query($con, $q);
    exit();
}

//Ação que atualiza o polígono no banco de dados
if ($_POST['acao'] == 'poligono') {
    $q = "UPDATE documentos SET poligono = '{$_POST['poligono']}' WHERE codigo = '{$_POST['codigo']}'";
    mysqli_query($con, $q);
    exit();
}

if ($_POST['acao'] == 'salvar') {
    $codigo = $_POST['codigo'];
    $q = "UPDATE documentos SET situacao = 'CONCLUIDO' WHERE codigo = '{$codigo}'";

    if (mysqli_query($con, $q)) {
        echo json_encode(["status" => true, "msg" => "Dados salvo com sucesso"]);
    } else {
        echo json_encode(["status" => false, "msg" => "Error ao salvar"]);
    }

    exit();
}

$doc_id = $_SESSION['id'];

$d = [];

if ($doc_id) {
    $result = mysqli_query($con, "SELECT codigo, coordenadas, poligono FROM documentos WHERE codigo = '{$doc_id}'");
    $d = mysqli_fetch_object($result);
}
?>

<style>
    #map {
        position: relative;
        height: 500px;
        width: 100%;
    }

    #mapa-content {
        border-style: solid;
        border-color: rgb(52, 86, 132) rgb(108, 157, 223) rgb(108, 157, 223) rgb(52, 86, 132);
        border-width: 1px;
        font-size: 12px;
        font-weight: bold;
    }
</style>

<div id="map">
    <div id="mapa-content">
        Map
    </div>
</div>

<input type="hidden" id="codigo" value="<?= $d->codigo ?>">

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
            <button type="button" class="btn bg-primary btn_next salvar text-white">Salvar</button>
        </div>
    </div>
</div>

<script>
    $(function () {
        //@formatter:off
        var doc_id = $("#codigo").val();

        $("button[voltar]").click(function () {
            $.ajax({
                url: "./pages/documentos/endereco.php",
                data: {doc_id},
                success: function (data) {
                    $(".content-pane").html(data);
                }
            })
        });

        marker = null;

        geocoder = new google.maps.Geocoder();

        //@formatter:off
        mapa = new google.maps.Map(document.getElementById("map"), {
            center            : <?=(($d->coordenadas)?:'{lat : 0, lng : 0}')?>,
            zoom              : 20,
            zoomControl       : true,
            mapTypeControl    : false,
            draggable         : true,
            scaleControl      : false,
            scrollwheel       : true,
            navigationControl : false,
            streetViewControl : false,
            fullscreenControl : false,
        });

        //Define as corrdendas de acordo com a informação resgatada no ...
        // ... banco ou define as coordendas no ponto zero
        marker = new google.maps.Marker({
            position: <?=(($d->coordenadas)?:'{lat : 0, lng : 0}')?>,
            map: mapa,
            title: "TESTE",
            draggable: true,
        });

        //Ao remover o Marker ele redefine no banco as cooredendas alteradas na função abaixo
        google.maps.event.addListener(marker, 'dragend', function(marker) {
                                var latLng = marker.latLng;
                                // coordendas = `{"Lat" : ${latLng.lat()} , "Lng" : ${latLng.lng()}}`;
                                Lat = `${latLng.lat()}`;
                                Lng = `${latLng.lng()}`;

                                $.ajax({
                                    url: "./pages/documentos/mapa.php",
                                    type:"POST",
                                    data: {
                                        codigo:'<?=$d->codigo?>',
                                        lat:Lat,
                                        lng:Lng,
                                        acao:'coordenadas'
                                    },
                                    success: function (data) {
                                        // alert(data);
                                    }
                                })

                            });

        triangleCoords = <?=(($d->poligono)?:'null')?>;

        poligono = new google.maps.Polygon({
            paths : triangleCoords,
            strokeColor   : "#FF0000",
            fillColor     : "#FF0000",
            strokeOpacity : 0.8,
            strokeWeight  : 2,
            fillOpacity   : 0.35,
            editable      : true,
        });

        poligono.setMap(mapa);

        mapa.addListener('click', addLatLng);

        //Aqui a função que remove o polígono com o click sobre a área do polígono
        google.maps.event.addListener(poligono, "click", function(){
            Limpa = [];
            poligono.setPath(Limpa);

            $.ajax({
                url: "./pages/documentos/mapa.php",
                type:"POST",
                data: {
                    codigo:'<?=$d->codigo?>',
                    poligono:'null',
                    acao:'poligono'
                },
                success: function (data) {
                    // alert(data);
                }
            })

        });

        google.maps.event.addListener(poligono, "dragend", getPolygonCoords);
        google.maps.event.addListener(poligono, "change", getPolygonCoords);
        google.maps.event.addListener(poligono.getPath(), "insert_at", getPolygonCoords);
        google.maps.event.addListener(poligono.getPath(), "remove_at", getPolygonCoords);
        google.maps.event.addListener(poligono.getPath(), "set_at", getPolygonCoords);

        // ** Função que adicionar um poligono **
        function addLatLng(e) {
            var path = poligono.getPath();
            path.push(e.latLng);
            getPolygonCoords();
        }

        // ** Função para criar botão para resetar poligono **
        function CenterControl(controlDiv, map) {
            // Set CSS for the control border.
            const controlUI = document.createElement("div");

            controlUI.style.backgroundColor = "#fff";
            controlUI.style.border          = "2px solid #fff";
            controlUI.style.borderRadius    = "3px";
            controlUI.style.boxShadow       = "0 2px 6px rgba(0,0,0,.3)";
            controlUI.style.cursor          = "pointer";
            controlUI.style.marginTop       = "8px";
            controlUI.style.marginLeft      = "8px";
            controlUI.style.marginBottom    = "22px";
            controlUI.style.textAlign       = "center";
            controlUI.title                 = "Click to recenter the map";
            controlDiv.appendChild(controlUI);

            // Set CSS for the control interior.
            const controlText = document.createElement("div");

            controlText.style.color        = "rgb(25,25,25)";
            controlText.style.fontFamily   = "Roboto,Arial,sans-serif";
            controlText.style.fontSize     = "16px";
            controlText.style.lineHeight   = "38px";
            controlText.style.paddingLeft  = "5px";
            controlText.style.paddingRight = "5px";
            controlText.innerHTML          = "Resetar";
            controlUI.appendChild(controlText);

            //@formatter:on
            // Setup the click event listeners: simply set the map to Chicago.
            controlUI.addEventListener("click", () => {
                poligono.setMap(null);
            });
        }

        //função que acionada após as ações no polígono, atualiza as coordenadas e submete para a ação do banco
        function getPolygonCoords() {

            // var len = poligono.getPath().getLength();
            // var htmlStr = [];
            // for (var i = 0; i < len; i++) {
            //     htmlStr = poligono.getPath().getAt(i).toUrlValue(5) ;
            // }
            // console.log(poligono.getPath());
            // console.log(htmlStr);

            var polygonBounds = poligono.getPath();
            var bounds = [];
            for (var i = 0; i < polygonBounds.length; i++) {
                var point = {
                    lat: polygonBounds.getAt(i).lat(),
                    lng: polygonBounds.getAt(i).lng()
                };
                bounds.push(point);
            }
            resultado = JSON.stringify(bounds);

            $.ajax({
                url: "./pages/documentos/mapa.php",
                type: "POST",
                data: {
                    codigo: '<?=$d->codigo?>',
                    poligono: resultado,
                    acao: 'poligono'
                },
                success: function (data) {
                    // alert(data);
                }
            })

        }

        const centerControlDiv = document.createElement("div");

        CenterControl(centerControlDiv, mapa);

        mapa.controls[google.maps.ControlPosition.TOP_LEFT].push(centerControlDiv);

        $(".salvar").click(function () {
            var codigo = $("#codigo").val();

            $.ajax({
                url: "./pages/documentos/mapa.php",
                method: "post",
                data: {codigo, acao: "salvar"},
                dataType: "json",
                success: function (response) {
                    if (response.status) {

                        $.ajax({
                            url: "./pages/documentos/anexo.php",
                            type: "GET",
                            data: {doc_id},
                            success: function (data) {
                                $(".content-pane").html(data);
                            }
                        });
                    } else {
                        $.alert({
                            title: 'Error',
                            content: response.msg
                        });
                    }
                }
            });
        });
    });
</script>