// -------------------------------------------------------------
// Google Map
// -------------------------------------------------------------
var myMap = {

    initMap: function (){

        // Chelles centre
        var myLatlng = {
            lat: 48.8777304,
            lng: 2.5878141
        };

        var styles = [
            {
                featureType: "landscape",
                stylers: [
                    { color: '#f7f7f7' }
                ]
            },{
                featureType: "road",
                stylers: [
                    { hue: '#0099FF' },
                    { saturation: -50 },
                    { visibility: "simplified" }
                ]
            },{
                featureType: "administrative",
                elementType: "labels",
                stylers: [
                    { hue: '' }
                ]
            },{
                featureType: "poi", //points of interest
                stylers: [
                    { hue: '' }
                ]
            }
        ];

        var mapOptions = {
            zoom: 12,
            scrollwheel: false,
            center: myLatlng,
            mapTypeId: 'roadmap',
            disableDefaultUI: true,
            styles: styles
        };

        var map = new google.maps.Map(document.getElementById('mapCanvas'), mapOptions);

        var iconMarker = {url: 'assets/images/ico/marker.png'};

        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            icon: iconMarker,
            animation: google.maps.Animation.DROP,
            title: 'Hello World!'
        });

        var contentString = '<div>' +
            '<h5>Morim Adrien</h5>' +
            '<h6> Freelance</h6>' +
            '<hr>' +
            '<p>Développeur intégrateur d\'applications web</br>' +
            'Web Designer autodidacte</p>' +
            '</div>';

        var infowindow = new google.maps.InfoWindow({
            content: contentString,
            maxWidth: 300
        });

        google.maps.event.addListener(marker, 'click', function () {
            infowindow.open(map, marker);
        });
    }
};

function initMap() {

    myMap.initMap();

}