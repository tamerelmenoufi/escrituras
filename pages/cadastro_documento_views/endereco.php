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
        $query_estados = "SELECT * FROM aux_estados WHERE situacao = '0'";
        $result = mysqli_query($con, $query_estados);
        while ($row = mysqli_fetch_object($result)):?>
            <option value="<?= $row->codigo ?>"><?= $row->nome ?></option>
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
    </select>
</div>

<div class="mb-3">
    <label for="bairro" class="form-label">Bairro</label>
    <select
            class="form-control"
            id="bairro"
            name="bairro"
            aria-describedby="bairro"
    >
        <option value=""></option>
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
    >
</div>

<script>

    function initialize() {
        //@formatter:off
        var input        = document.getElementById('rua');
        var autocomplete = new google.maps.places.Autocomplete(input);

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();

            place_endereco  = place['formatted_address'];
            place_latitude  = place.geometry.location.lat();
            place_longitude = place.geometry.location.lng();

            geocoder.geocode({
                "address": place_endereco,
                "region": "BR"
            }, (results, status) => {
                if (status == google.maps.GeocoderStatus.OK) {

                    if (results[0]) {
                        let latitude  = results[0].geometry.location.lat();
                        let longitude = results[0].geometry.location.lng();
                        let location  = new google.maps.LatLng(latitude, longitude);

                        marker.setPosition(location);
                        mapa.setCenter(location);
                        mapa.setZoom(18);

                        marker = new google.maps.Marker({
                            position: { lat: latitude, lng: longitude },
                            map:mapa,
                            title: "TESTE",
                            draggable:true,
                        });

                    }
                }
            });
        });
        //@formatter:on
    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>