<!DOCTYPE html>
<html class="use-all-space">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <title>SearchBox</title>
    <link rel="stylesheet" type="text/css"
        href="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.3-public-preview.0/SearchBox.css" />
    <link rel="stylesheet" href="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.25.0/maps/maps.css" />
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.25.0/maps/maps-web.min.js"></script>
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.1.2-public-preview.15/services/services-web.min.js">
    </script>
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.3-public-preview.0/SearchBox-web.js">
    </script>
</head>

<body>
    <div class="d-flex justify-content-between my-5 position-relative">
        <div id="searchBoxContainer" style="width: 30%; position:absolute; z-index: 1; top: 10px; left: 10px"></div>
        <div id='map' class='map' style="width: 100%; height: 500px"></div>
    </div>

    <input type="hidden" name="latitude" id="latitude" value="">
    <input type="hidden" name="longitude" id="longitude" value="">
    <input type="hidden" name="address" id="address" value="">
    <input type="hidden" name="city" id="city" value="">

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            var options = {
                searchOptions: {
                    key: "9Yq5kH65us12yazEXv9SX8bGsAYxX1fL", // Inserisci qui la tua API Key
                    language: "it-IT",
                    limit: 5,
                    countrySet: ["IT"]
                },
                autocompleteOptions: {
                    key: "9Yq5kH65us12yazEXv9SX8bGsAYxX1fL", // Inserisci qui la tua API Key
                    language: "it-IT",
                    countrySet: ["IT"]
                },
            };

            // Creazione del SearchBox
            var ttSearchBox = new tt.plugins.SearchBox(tt.services, options);
            var searchBoxHTML = ttSearchBox.getSearchBoxHTML();
            document.getElementById('searchBoxContainer').append(searchBoxHTML);

            // Inizializzazione della mappa
            const map = tt.map({
                key: "9Yq5kH65us12yazEXv9SX8bGsAYxX1fL", // Inserisci qui la tua API Key
                container: 'map',
                center: [14.942989, 42.675696],
                zoom: 4.5
            });

            let marker; // Variabile per mantenere il riferimento al marker

            // Gestione dell'evento di selezione del risultato
            ttSearchBox.on("tomtom.searchbox.resultselected", function(event) {
                const result = event.data.result;
                console.log("Risultato selezionato:", result);

                if (result && result.position) {
                    const coordinates = result.position;
                    console.log("Coordinate:", coordinates);

                    if (typeof coordinates.lng === 'number' && typeof coordinates.lat === 'number') {
                        // Rimuovere il marker precedente se esiste
                        if (marker) {
                            marker.remove();
                        }

                        // Centrare la mappa e aggiungere un nuovo marker
                        map.setCenter([coordinates.lng, coordinates.lat]);
                        map.setZoom(14);
                        marker = new tt.Marker().setLngLat([coordinates.lng, coordinates.lat]).addTo(map);

                        // Aggiornare i campi nascosti con latitudine e longitudine
                        document.getElementById('latitude').value = coordinates.lat;
                        document.getElementById('longitude').value = coordinates.lng;

                        // Aggiornare l'indirizzo e la città
                        const address = result.address.freeformAddress || ''; // Indirizzo completo
                        const city = result.address.municipality || ''; // Comune

                        document.getElementById('address').value = address; // Imposta l'indirizzo
                        document.getElementById('city').value = city; // Imposta la città

                        console.log("Indirizzo:", address);
                        console.log("Città:", city);
                    } else {
                        console.error("Le coordinate non sono valide:", coordinates);
                    }
                } else {
                    console.error("Coordinate non disponibili nel risultato:", result);
                }
            });
        });
    </script>
</body>

</html>
