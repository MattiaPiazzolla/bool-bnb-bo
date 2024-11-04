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


