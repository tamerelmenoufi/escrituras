<html>
<head>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
  <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSnblPMOwEdteX5UPYXf7XUtJYcbypx6w&v=weekly&language=pt&region=BR&libraries=places&v=weekly"></script>
    
</head>
<body>

<div id="map" style="width: 100%; height: 500px"></div>

<script>  
  
  map = "";
  poly = "";

function initMap() {  
   map = new google.maps.Map(
    document.getElementById("map"),
    {
      zoom: 5,
      center: { lat: 24.886, lng: -70.268 },
      mapTypeId: "terrain",
    }
  );
  
     triangleCoords = [
    { lat: 25.774, lng: -80.19 },
    { lat: 18.466, lng: -66.118 },
    { lat: 32.321, lng: -64.757 },
    { lat: 25.774, lng: -80.19 },
  ];

  bermudaTriangle = new google.maps.Polygon({  
    paths: triangleCoords,
    strokeColor: "#FF0000",
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: "#FF0000",
    fillOpacity: 0.35,
  });  

  bermudaTriangle.setMap(map);  
  
  // Add a listener for the click event  
  //map.addListener('click', addLatLng);  
}  
  
// Add a new point to the Polyline.  



initMap();
    </script>
</body>
</html> 