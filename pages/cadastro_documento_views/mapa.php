<!--<div class="mb-3">
    <label for="coordenadas" class="form-label">Coordenadas</label>
    <input
        type="text"
        class="form-control"
        id="coordenadas"
        aria-describedby="coordenadas"
    >
</div>

<div class="mb-3">
    <label for="poligono" class="form-label">Poligono</label>
    <input
        type="text"
        class="form-control"
        id="poligono"
        aria-describedby="poligono"
    >
</div>-->

<style>
    #mapa {
        position: relative;
        height: 500px;
        width: 100%;
        border: 1px solid;
    }
</style>


<div id="map"></div>

<script>
    $(function () {

        let geocoder = new google.maps.Geocoder();

        mapa = new google.maps.Map(document.getElementById("map"), {
            zoomControl: false,
            mapTypeControl: false,
            draggable: true,
            scaleControl: false,
            scrollwheel: false,
            navigationControl: false,
            streetViewControl: false,
            fullscreenControl: false,
        });
    });
</script>
