<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Maps TomTom -->
    <link rel="stylesheet" href="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.25.0/maps/maps.css" />
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.25.0/maps/maps-web.min.js"></script>
</head>

<body>
    <div id="map" style="width: 100%; height: 300px;"></div>

    <script type="text/javascript">
        let latitude = {{ $latitude ?? 'null' }};
        let longitude = {{ $longitude ?? 'null' }};

        if (latitude && longitude) {
            const center = [longitude, latitude];

            const map = tt.map({
                key: "9Yq5kH65us12yazEXv9SX8bGsAYxX1fL",
                container: 'map',
                center: center,
                zoom: 15
            });

            map.on('load', () => {
                const marker = new tt.Marker().setLngLat(center).addTo(map);

                // Centra la mappa
                map.setCenter(center);
                map.resize();
            });
            window.addEventListener('resize', () => {
                map.setCenter(center);
            });
        } else {
            console.error("Latitudine o longitudine non definite correttamente.");
        }
    </script>
</body>

</html>
