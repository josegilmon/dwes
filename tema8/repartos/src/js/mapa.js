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