// ---------------------------------------------------------------------------------------------------------------------------->
// MAP ELEMENT  ||-----------
// ---------------------------------------------------------------------------------------------------------------------------->


// function init() {
    window.onload = function() {
        L.mapquest.key = 'putYourKey';
        var baseLayer = L.mapquest.tileLayer('map');

        var map = L.mapquest.map('map', {
            center: [48.858370, 2.294481],
            layers: L.mapquest.tileLayer('hybrid'),
            scrollWheelZoom: false,
            zoom: 17
        });

        L.control.layers({
            'Hybrid': L.mapquest.tileLayer('hybrid'),
            'Map': baseLayer
        }).addTo(map);


        var customPopup = L.popup({ closeButton: true })
            .setLatLng([48.858370, 2.294481])
            .setContent('<strong> Eiffel Tower</strong><br>Paris, FRANCE')
            .openOn(map);

        /*
         L.mapquest.icons.marker({
         primaryColor: '#22407F',
         secondaryColor: '#3B5998',
         shadow: false,
         size: 'sm'
         })
         */

       L.marker([48.858370, 2.294481], {
            // icon: L.mapquest.icons.marker(),
            icon:   L.mapquest.icons.marker(),
            draggable: false
        }).bindPopup(customPopup)
            .addTo(map);
    }
// };
