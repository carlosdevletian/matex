function initMap() {
	/*Aqui se fija la direccion con latitud y longitud*/
	var location = {lat: 10.507727, lng: -66.852446};
	var map = new google.maps.Map(document.getElementById('Map'), {
		center: location,
		zoom: 17,
		disableDefaultUI: true,
		zoomControl: true,
		mapTypeControl: false,
		scaleControl: false,
		streetViewControl: false,
		rotateControl: false,
		fullscreenControl: false,
		scrollwheel: false,
	});
	/*El marker (pin) se puede cambiar seleccionando una imagen*/
	var image = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png';
	var marker = new google.maps.Marker({
		position: location,
		map: map,
		icon: image
	});
	/*Cuando le das click al marker, se abren las direcciones*/
	marker.addListener('click', function() {
		window.open("https://maps.google.com?saddr=Current+Location&daddr=10.507727,-66.852446");
	});
}
