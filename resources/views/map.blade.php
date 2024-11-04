<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Maps Tomtom --}}
    <link rel="stylesheet" type="text/css" href="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.25.0/maps/maps.css" />

    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.25.0/maps/maps-web.min.js"></script>
</head>

<body>
    <div id="map" style="width: 100%; height: 400px"></div>
</body>
<script type="text/javascript">
    let center = [4, 44.4]
    const map = tt.map({
        key: "9Yq5kH65us12yazEXv9SX8bGsAYxX1fL",
        container: 'map',
        center: center,
        zoom: 10
    })
    map.on('load', () => {
        new tt.Marker().setLngLat(center).addTo(map)
    })
</script>

</html>
