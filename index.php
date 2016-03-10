<!DOCTYPE html>
<html>
  <head>
    <title>Place Autocomplete</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
      .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
    </style>
  </head>
  <body>
    <input id="pac-input" class="controls" type="text"
        placeholder="Enter a location">
    <div id="type-selector" class="controls">
      <input type="radio" name="type" id="changetype-all" checked="checked">
      <label for="changetype-all">All</label>

      <input type="radio" name="type" id="changetype-establishment">
      <label for="changetype-establishment">Establishments</label>

      <input type="radio" name="type" id="changetype-address">
      <label for="changetype-address">Addresses</label>

      <input type="radio" name="type" id="changetype-geocode">
      <label for="changetype-geocode">Geocodes</label>
    </div>
    <div id="map"></div>
    <script>
      
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 21.0000, lng: 78.0000},
          zoom: 5
        });

        var input = (document.getElementById('pac-input'));
        var types = document.getElementById('type-selector');
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);
        var marker = new google.maps.Marker({
          map: map,
          anchorPoint: new google.maps.Point(0, -29),
          draggable: true
        });



        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            map.setCenter(pos);
            map.setZoom(15); 
	  		marker.setPosition(pos);
          google.maps.event.addListener(marker, 'dragend', function() { 
          	var geocoder; 
	        geocoder = new google.maps.Geocoder(); 
	        var latlng = new google.maps.LatLng(this.getPosition().lat(), this.getPosition().lng()); 

	        geocoder.geocode( 
	        	{'latLng': latlng}, function(results, status) { 
	        		if (status == google.maps.GeocoderStatus.OK) { 
	        			if (results[0]) { 
	        				var add= results[0].formatted_address ; 
	        				console.log(add);
	        				document.getElementById('pac-input').value = add;
	        			} else { 
	        				alert("address not found"); 
	        			} 
	        		} else { 
	        			alert("Geocoder failed due to: " + status); 
	        		} 
	        	} 
	        );
          });


          }, function() {
            handleLocationError(true, map.getCenter());
          });

        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, map.getCenter());
        }

        autocomplete.addListener('place_changed', function() {
          // clearMarkers();
          var place = autocomplete.getPlace();
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          }
         
	      marker.setPosition(place.geometry.location);
        }); 
        google.maps.event.addListener(marker, 'dragend', function() { 
          	var geocoder; 
	        geocoder = new google.maps.Geocoder(); 
	        var latlng = new google.maps.LatLng(this.getPosition().lat(), this.getPosition().lng()); 

	        geocoder.geocode( 
	        	{'latLng': latlng}, function(results, status) { 
	        		if (status == google.maps.GeocoderStatus.OK) { 
	        			if (results[0]) { 
	        				var add= results[0].formatted_address ; 
	        				console.log(add);
	        				document.getElementById('pac-input').value = add;
	        			} else { 
	        				alert("address not found"); 
	        			} 
	        		} else { 
	        			alert("Geocoder failed due to: " + status); 
	        		} 
	        	} 
	        );
          });     
    }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA34iBZT_qIIebJ1niy7DNvOJ2VJvbNluI&libraries=places&callback=initMap"
        async defer></script>
  </body>
</html>