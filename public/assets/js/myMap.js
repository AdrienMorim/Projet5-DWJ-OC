// -------------------------------------------------------------
// Google Map
// -------------------------------------------------------------
let myMap = {

    initMap: function (){

        let chelles = {
            lat: 48.8777304,
            lng: 2.5878141
        };

        let myLatlng = new google.maps.LatLng(chelles.lat, chelles.lng);

        let styles = [
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

        let mapOptions = {
            zoom: 12,
            scrollwheel: false,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true,
            styles: styles
        };

        let map = new google.maps.Map(document.getElementById('mapCanvas'), mapOptions);

        let iconMarker = {url: 'assets/images/ico/marker.png'};

        let marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            icon: iconMarker,
            animation: google.maps.Animation.DROP,
            title: 'Hello World!'
        });

        let contentString = '<div>' +
            '<h5>Morim Adrien</h5>' +
            '<h6> Freelance</h6>' +
            '<hr>' +
            '<p>Développeur intégrateur d\'applications web</br>' +
            'Web Designer autodidacte</p>' +
            '</div>';

        let infowindow = new google.maps.InfoWindow({
            content: contentString,
            maxWidth: 300
        });

        google.maps.event.addListener(marker, 'click', function () {
            infowindow.open(map, marker);
        });
    }
};