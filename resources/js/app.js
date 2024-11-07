import './bootstrap';
import '~resources/scss/app.scss';
import '~icons/bootstrap-icons.scss';
import * as bootstrap from 'bootstrap';
import.meta.glob([
    '../img/**'
])


// SELEZIONE E CANCELLAZIONE DEGLI IMMOBILI
const deleteButtons = document.querySelectorAll('.delete-real-estate'); 

deleteButtons.forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const deleteUrl = button.getAttribute('data-url'); 
        console.log("URL di eliminazione:", deleteUrl);

        const modal = new bootstrap.Modal(document.getElementById('deleteRealEstateModal'));
        modal.show();

        const deleteForm = document.getElementById('deleteRealEstateForm'); 
        deleteForm.setAttribute('action', deleteUrl); 
    });
});




// INIZIALIZZAZIONE DELLA MAPPA
document.addEventListener("DOMContentLoaded", function() {
    var options = {
        searchOptions: {
            key: "9Yq5kH65us12yazEXv9SX8bGsAYxX1fL", 
            language: "it-IT",
            limit: 5,
            countrySet: ["IT"]
        },
        autocompleteOptions: {
            key: "9Yq5kH65us12yazEXv9SX8bGsAYxX1fL", 
            language: "it-IT",
            countrySet: ["IT"],
            resultSet:'addr'

        },
    };

    // Creazione del SearchBox
    var ttSearchBox = new tt.plugins.SearchBox(tt.services, options);
    var searchBoxHTML = ttSearchBox.getSearchBoxHTML();
    document.getElementById('searchBoxContainer').append(searchBoxHTML);

    // Inizializzazione della mappa
    const map = tt.map({
        key: "9Yq5kH65us12yazEXv9SX8bGsAYxX1fL", 
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

// OCCHIO LOGIN
    const show_pw_btn = document.querySelector('#showPassword')
    const show_pw_icon = show_pw_btn.querySelector('i')
    const pw_input = document.querySelector('#password')

    show_pw_btn.addEventListener('click', () => {
        pw_input.type = pw_input.type === 'password' ? 'text' : 'password'

        show_pw_icon.classList = show_pw_icon.classList.contains('bi-eye') ? 'bi-eye-slash' : 'bi-eye'
    })

    const show_pw_btn2 = document.querySelector('#showPassword2')
    const show_pw_icon2 = show_pw_btn2.querySelector('i')
    const pw_input2 = document.querySelector('#password-confirm')

    show_pw_btn2.addEventListener('click', () => {
        pw_input2.type = pw_input2.type === 'password' ? 'text' : 'password'

        show_pw_icon2.classList = show_pw_icon2.classList.contains('bi-eye') ? 'bi-eye-slash' : 'bi-eye'
    })
