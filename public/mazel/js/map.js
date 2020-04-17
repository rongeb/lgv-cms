// ---------------------------------------------------------------------------------------------------------------------------->
// MAP ELEMENT  ||-----------
// ---------------------------------------------------------------------------------------------------------------------------->


// function init() {
    window.onload = function() {
        L.mapquest.key = 'AyaMcmkLalgP4jKH0RK2GOHcsfJel3SO';
        var baseLayer = L.mapquest.tileLayer('map');

        var map = L.mapquest.map('map', {
            center: [46.079692, 4.675880],
            layers: L.mapquest.tileLayer('hybrid'),
            scrollWheelZoom: false,
            zoom: 17
        });

        L.control.layers({
            'Hybrid': L.mapquest.tileLayer('hybrid'),
            'Map': baseLayer
        }).addTo(map);


        var customPopup = L.popup({ closeButton: true })
            .setLatLng([46.07994, 4.675880])
            .setContent('<strong> Marielle et Christian Jaffre</strong>'+
            '<br> Domaine du vieux celliers<br>Garanche'+
            '<br>69220 Charentay'+
            '<br>Coordonnées GPS:'+
            '<br>Lat : 46.07994, Lng : 4.675880')
            .openOn(map);

        /*
         L.mapquest.icons.marker({
         primaryColor: '#22407F',
         secondaryColor: '#3B5998',
         shadow: false,
         size: 'sm'
         })
         */

       L.marker([46.079692, 4.675880], {
            // icon: L.mapquest.icons.marker(),
            icon:   L.mapquest.icons.marker(),
            draggable: false
        }).bindPopup(customPopup)
            .addTo(map);
    }
// };
