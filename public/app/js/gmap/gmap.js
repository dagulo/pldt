var lVue = new Vue({
    el:'#lDiv',
    data:{
        location:[],
        lat:0,
        lon:0
    },
    methods:{

    },
    ready:function(){

    }
});
var map;
$("#map").css({ opacity: 0, zoom: 0 });

function initMap( ){
    if( !lVue.$data.lat ){
        return
    }
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center: {lat: lVue.$data.lat, lng: lVue.$data.lon },
        //center: {lat:7.070539951324463, lng: 125.59806823730469 },
        mapTypeId: 'terrain'
    });

    //var tcoords = JSON.parse(lVue.$data.location.coverage);
    var tcoords = [ {lat:7.086066, lng:125.595332},{lat:7.079178, lng:125.594873},{lat:7.073877, lng:125.590235},{lat:7.066938, lng:125.600901},{lat:7.074149, lng:125.607950},{lat:7.083367, lng:125.611931},{lat:7.083381, lng:125.609430} ];
    // Construct the polygon.
    var tpoly = new google.maps.Polygon({
        paths: tcoords,
        strokeColor: '#FF0000',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#00FF00',
        fillOpacity: 0.35
    });
    tpoly.setMap(map);

    var pcoords = [
        {lat:7.316688,lng:125.678772},
        {lat:7.309901,lng:125.673327},
        {lat:7.305429,lng:125.675573},
        {lat:7.300923,lng:125.686801},
        {lat:7.306947,lng:125.695068}
    ];
    // Construct the polygon.
    var ppoly = new google.maps.Polygon({
        paths: pcoords,
        strokeColor: '#FF0000',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#00FF00',
        fillOpacity: 0.35
    });
    ppoly.setMap(map);

}

function hideMap(){
    $("#map").css({ opacity: 0, zoom: 0 });
}


