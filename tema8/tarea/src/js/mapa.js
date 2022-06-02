function loadMapScenario() {
    data = $("#miMapa").data();
    map = new Microsoft.Maps.Map(document.getElementById('miMapa'), {
        center: new Microsoft.Maps.Location(data.lat, data.lon),
        mapTypeId: Microsoft.Maps.MapTypeId.canvasLight,
        zoom: 17
    });
    var center = map.getCenter();

    //Create custom Pushpin
    var pin = new Microsoft.Maps.Pushpin(center, {});

    //Add the pushpin to the map
    map.entities.push(pin);
}

function loadMapRoute() {

    var data = $("#miMapa").data();
    var points = data.routepath.split('|');
    var start = points[0].split(',');

    var map = new Microsoft.Maps.Map(document.getElementById('miMapa'), {
        center: new Microsoft.Maps.Location(start[0], start[1]),
        mapTypeId: Microsoft.Maps.MapTypeId.canvasLight,
        zoom: 15
    });

    var coords = [];
    points.forEach(p => {
        var point = p.split(',')
        coords.push(new Microsoft.Maps.Location(point[0], point[1]));
    });

    //Create a polyline
    var line = new Microsoft.Maps.Polyline(coords, {
        strokeColor: 'red'
    });

    //Add the polyline to map
    map.entities.push(line);
}