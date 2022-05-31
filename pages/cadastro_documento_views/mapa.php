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
    #map {
        position: relative;
        height: 500px;
        width: 100%;
    }
</style>


<div id="map">
    <div style="border-style: solid; border-color: rgb(52, 86, 132) rgb(108, 157, 223) rgb(108, 157, 223) rgb(52, 86, 132); border-width: 1px; font-size: 12px; font-weight: bold;">
        Map
    </div>
</div>

<script>
    $(function () {
        //@formatter:off


        triangleCoords = '[{"lat": -3.1290166608296457,"lng": -60.02377578828007},{"lat": -3.129080937873819,"lng": -60.02377847048909},{"lat": -3.1290889725040736,"lng": -60.02363698396355},{"lat": -3.1290240259078232,"lng": -60.02363229009777},{"lat": -3.1290200085924607,"lng": -60.02371275636822}]';

        poligono = new google.maps.Polygon({
            paths: triangleCoords,
            strokeColor   : "#FF0000",
            fillColor     : "#FF0000",
            strokeOpacity : 0.8,
            strokeWeight  : 2,
            fillOpacity   : 0.35,
            editable      : true,
        });

        poligono.setMap(mapa);

        mapa.addListener('click', addLatLng);

        google.maps.event.addListener(poligono, "dragend", getPolygonCoords);
        google.maps.event.addListener(poligono, "dragend", getPolygonCoords);
        google.maps.event.addListener(poligono.getPath(), "insert_at", getPolygonCoords);
        google.maps.event.addListener(poligono.getPath(), "remove_at", getPolygonCoords);
        google.maps.event.addListener(poligono.getPath(), "set_at", getPolygonCoords);

        // ** Função que adicionar um poligono **
        function addLatLng(e) {
            var path = poligono.getPath();
            path.push(e.latLng);
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

        function getPolygonCoords() {
            var len = poligono.getPath().getLength();
            var htmlStr = "";
            for (var i = 0; i < len; i++) {
                htmlStr = poligono.getPath().getAt(i).toUrlValue(5) + "<br>";
                //console.log(htmlStr);
            }


        }

        const centerControlDiv = document.createElement("div");

        CenterControl(centerControlDiv, mapa);

        mapa.controls[google.maps.ControlPosition.TOP_LEFT].push(centerControlDiv);

    });
</script>