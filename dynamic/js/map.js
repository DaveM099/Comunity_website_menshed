function draw_map() {
    var mapSpaces = document.getElementsByClassName("map_space");

    Array.from(mapSpaces).forEach(function (mapSpace) {

        var map_ops = {
            center: new Microsoft.Maps.Location(51.230090, -1.300720),
            zoom: 13,
            mapTypeId: Microsoft.Maps.MapTypeId.road,
            showLocateMeButton: false,
            disableMapTypeSelectorMouseOver: true
        };

        var theMap = new Microsoft.Maps.Map(mapSpace, map_ops);

        var loc = new Microsoft.Maps.Location(51.230090, -1.300720);


        var icon01 = 'Shed_img/Shed02.png';


        var layer = new Microsoft.Maps.Layer();
        //Create Pushpin

        var pin = new Microsoft.Maps.Pushpin(loc, {
            title: 'Test Valley',
            subTitle: 'The Mens Shed',
            icon: icon01
        });



        //Add the pushpin to the map
        layer.add(pin);

        theMap.layers.insert(layer);

        //add infobox to pins
        //pin
        var center = theMap.getCenter();

        var infobox = new Microsoft.Maps.Infobox(center, { title: 'Test Valley Mens Shed', description: 'Directions:<a href="https://maps.app.goo.gl/hLmDxnQmcMcVGeuc6">Test Valley</a>', visible: false });
        infobox.setMap(theMap);
        Microsoft.Maps.Events.addHandler(pin, 'click', function () {
            infobox.setOptions({ visible: true });
        });
        theMap.entities.push(pin);


    });

}


