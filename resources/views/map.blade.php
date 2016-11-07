<div class="row Map__section">
	<div class="col-xs-4 col-xs-offset-1 Map__text">
		<p>Address</p>
		<!--Modificar coordenadas en link. El target blank hace que abra en un nuevo tab-->
		<a target="_blank" href="https://maps.google.com?saddr=Current+Location&daddr=10.507727,-66.852446" class="btn btn-primary" role="button">Directions</a>
	</div>
    <div id="Map" class="Map"></div>
</div>

@push('scripts')
	<!--Script del mapa, puede ser map.js o styledmap.js (al styled se le pueden poner colores)-->
	<script src="{{ URL::to('js/map.js') }}"></script>
	<!--Se puede cambiar el lenguaje al final del src-->
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrA2CwdNDt-62Ka7eWq_CNiPeF3jUUpcM&callback=initMap&language=en"></script>
@endpush
