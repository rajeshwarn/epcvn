/**
 * jQuery GoogleMaps
 * Version 3.1 - 03/08/2010
 * @author Flavien Bucheton
 *
 * Permet de gérer les plans googlemaps (API V3)
 *
 * http://interne.sitti-base.com/wiki/doku.php/dev/plan/accueil
 * Langues : http://spreadsheets.google.com/pub?key=p9pdwsai2hDMsLkXsoM05KQ&gid=1
 **/

(function($) {
	var aMapTypeDefaut = ["ROADMAP","SATELLITE","HYBRID","TERRAIN"];

	var verifSettings = function(settings){
		var textErr = "";
		var erreur = false;
		var aMapType = settings.mapTypeControl.mapTypeIds.split(",");

		if(settings.zoom < 1 || settings.zoom > 17 || isNaN(parseInt(settings.zoom))){
			textErr += "\n - Le niveau zoom est invalide (doit être compris entre 1 et 17) !";
			erreur = true;
		}

		if($.inArray(settings.mode, aMapType) == -1){
			textErr += "\n - Le mode d'affichage est invalide (valeurs possibles: "+aMapType.join(", ")+") !";
			erreur = true;
		}

		$.each(settings.multi,function(i){
			if(this.zoom < 1 || this.zoom > 17 || isNaN(parseInt(this.zoom))){
				textErr += "\n - Le niveau zoom du point "+i+" est invalide (doit être compris entre 1 et 17) !";
				erreur = true;
			}

			if($.inArray(this.mode, aMapType) == -1){
				textErr += "\n - Le mode d'affichage du point "+i+" est invalide (valeurs possibles: "+aMapType.join(", ")+") !";
				erreur = true;
			}
		});

		if(erreur){
			alert("----- ERREUR DE CONFIGURATION -----\n"+textErr);
		}
		return erreur;
	};

	var verifSettingsItineraire = function(settings){
		var textErr = "";
		var erreur = false;
		var aMapType = settings.mapTypeControl.mapTypeIds.split(",");

		if(settings.zoom < 1 || settings.zoom > 17 || isNaN(parseInt(settings.zoom))){
			textErr += "\n - Le niveau zoom est invalide (doit être compris entre 1 et 17) !";
			erreur = true;
		}

		if($.inArray(settings.mode, aMapType) == -1){
			textErr += "\n - Le mode d'affichage est invalide (valeurs possibles: "+aMapType.join(", ")+") !";
			erreur = true;
		}

		if(settings.unitSystem != "METRIC" && settings.unitSystem != "IMPERIAL"){
			textErr += "\n - Le système unitaire est invalide (valeurs possibles: METRIC, IMPERIAL) !";
			erreur = true;
		}

		if(settings.travelMode != "BICYCLING" && settings.travelMode != "DRIVING" && settings.travelMode != "WALKING"){
			textErr += "\n - Le mode de transport est invalide (valeurs possibles: BICYCLING, DRIVING, WALKING) !";
			erreur = true;
		}

		if(erreur){
			alert("----- ERREUR DE CONFIGURATION -----\n"+textErr);
		}
		return erreur;
	};

	var search = function(maDiv, gmap, geocoder, settings, multi){
		if (geocoder) {
			geocoder.geocode( {'address': settings.search}, function(results, status) {
				if (status != google.maps.GeocoderStatus.OK) {
					alert("Adresse non trouvée !");
				}else{
					var point = results[0].geometry.location;
					if (multi) {
						loadPointMulti(gmap, point, settings, maDiv.point_def, maDiv.settings);
					}
					else{
						displayMarker = true;
						if (settings.multi || settings.infobulle.titre=="") {
							displayMarker = false;
							maDiv.point_def = point;
						}
						loadPoint(gmap, point, settings, displayMarker);
					}
				}
			});
		}
	};

	var loadPoint = function(gmap, point, settings, displayMarker){
		gmap.setCenter(point);
		gmap.setZoom(settings.zoom);


		if(displayMarker){
			var marker = new google.maps.Marker({
				map: gmap,
				position: point
			});

			if(settings.infobulle.titre!="" || settings.infobulle.adresse!=""){
				var html = settings.htmlInfoBulle.replace("\$1", settings.infobulle.titre);
				html = html.replace("\$2", settings.infobulle.adresse);

				var infowindow = new google.maps.InfoWindow({
					content: html
				});

				google.maps.event.addListener(marker, 'click', function() {
				  infowindow.open(gmap, marker);
				});
				infowindow.open(gmap, marker);
			}
		}
	};

	var loadPointMulti = function(gmap, point, settings, point_def, settings_def){
		var marker = new google.maps.Marker({
			map: gmap,
			position: point
		});

		google.maps.event.addListener(marker, 'click', function() {
			gmap.setCenter(point);
			gmap.setZoom(settings.zoom);
			gmap.setMapTypeId(eval("google.maps.MapTypeId."+settings.mode));
			if (settings.infobulle.titre != "" || settings.infobulle.adresse != "") {
				var html = settings_def.htmlInfoBulle.replace("\$1", settings.infobulle.titre);
				html = html.replace("\$2", settings.infobulle.adresse);
				var infowindow = new google.maps.InfoWindow({
					content: html
				});
				google.maps.event.addListener(infowindow, 'closeclick', function() {
					gmap.setCenter(point_def);
					gmap.setZoom(settings_def.zoom);
					gmap.setMapTypeId(eval("google.maps.MapTypeId."+settings_def.mode));
				});
				infowindow.open(gmap, marker);
			}
		});
	};

	var loadZone = function(gmap, urlXml){
		$.get(urlXml, null, function(xml){
			$(xml).children("zones").children().each(function(){
				var tabCoords = new Array();
				$(this).children().each(function(){
					tabCoords.push(new google.maps.LatLng($(this).attr("latitude"), $(this).attr("longitude")));
				});
				var poly;
				if($(this).get(0).nodeName=="polygon"){
					poly = new google.maps.Polygon({
								paths: tabCoords,
								strokeColor: $(this).attr("borderColor"),
								strokeOpacity: $(this).attr("borderOpacity"),
								strokeWeight: $(this).attr("borderWidth"),
								fillColor: $(this).attr("backgroundColor"),
								fillOpacity: $(this).attr("backgroundOpacity"),
								zIndex: $(this).attr("zIndex")
							});

				}
				if($(this).get(0).nodeName=="polyline"){
					poly = new google.maps.Polyline({
								path: tabCoords,
								strokeColor: $(this).attr("borderColor"),
								strokeOpacity: $(this).attr("borderOpacity"),
								strokeWeight: $(this).attr("borderWidth"),
								zIndex: $(this).attr("zIndex")
							});
				}
				if($(this).get(0).nodeName=="circle"){
					poly = new google.maps.Circle({
								center: tabCoords[0],
								radius: parseInt($(this).attr("rayon")),
								strokeColor: $(this).attr("borderColor"),
								strokeOpacity: $(this).attr("borderOpacity"),
								strokeWeight: $(this).attr("borderWidth"),
								fillColor: $(this).attr("backgroundColor"),
								fillOpacity: $(this).attr("backgroundOpacity"),
								zIndex: $(this).attr("zIndex")
							});
				}
				poly.setMap(gmap);
			});
		}, "xml");
	};

	var calcRoute = function(directionsService, directionsDisplay, settings){
		var request = {
			origin: settings.start,
			destination: settings.end,
			avoidHighways: settings.avoidHighways,
			avoidTolls: settings.avoidTolls,
			travelMode: eval("google.maps.DirectionsTravelMode."+settings.travelMode),
			unitSystem: eval("google.maps.DirectionsUnitSystem."+settings.unitSystem)
		};
		directionsService.route(request, function(response, status) {
			if (status == google.maps.DirectionsStatus.OK) {
					directionsDisplay.setDirections(response);
			}else{
				alert("Impossible de calculer l'itinéraire !");
			}
		});
	};


	$.fn.extend({
		loadMap: function(options) {
			//Chargement des paramètres
			this.settings = {
				htmlInfoBulle: '<div class="infosbulle"><span class="plan-titre">$1</span><br /><br /><span class="plan-adresse">$2</span></div>',
				mapTypeControl: {
					display: true,
					mapTypeIds: aMapTypeDefaut.join(","),
					position: "TOP_RIGHT",
					style: "DEFAULT"
				},
				mapNavigationControl: {
					display: true,
					position: "TOP_LEFT",
					style: "DEFAULT"
				},
				mapScaleControl: {
					display: true,
					position: "BOTTOM_LEFT",
					style: "DEFAULT"
				},

				search: "47.0102,2.3730",
				infobulle: {
					titre: "",
					adresse: ""
				},
				zoom: 14,
				mode: "ROADMAP",
				multi: "",
				zones: "",
				backgroundColor: "#FFFFFF",
				draggable: true,
				scrollwheel: true,
				keyboardShortcuts: true,
				streetview: true,
				disableDoubleClickZoom: false
			};
			$.extend(this.settings, options);
			$.each(this.settings.multi,function(i){
				if(!this.mode){
					this.mode = "ROADMAP";
				}
				if(!this.zoom){
					this.zoom = 14;
				}
			});

			//Vérification de la configuration
			if(verifSettings(this.settings)){return false;}
			
			var aMapType = new Array();
			$.each(this.settings.mapTypeControl.mapTypeIds.split(","), function(){
				aMapType.push(eval("google.maps.MapTypeId."+this));
			});
			var latlng = new google.maps.LatLng(47.0102, 2.3730);

			this.mapOption = {
				zoom: this.settings.zoom,
				center: latlng,
				mapTypeId: eval("google.maps.MapTypeId."+this.settings.mode),
				mapTypeControl: this.settings.mapTypeControl.display,
				mapTypeControlOptions: {
					mapTypeIds: aMapType,
					position: eval("google.maps.ControlPosition."+this.settings.mapTypeControl.position),
					style: eval("google.maps.MapTypeControlStyle."+this.settings.mapTypeControl.style)
				},
				navigationControl: this.settings.mapNavigationControl.display,
				navigationControlOptions: {
					position: eval("google.maps.ControlPosition."+this.settings.mapNavigationControl.position),
					style: eval("google.maps.NavigationControlStyle."+this.settings.mapNavigationControl.style)
				},
				scaleControl: this.settings.mapScaleControl.display,
				scaleControlOptions: {
					position: eval("google.maps.ControlPosition."+this.settings.mapScaleControl.position),
					style: eval("google.maps.ScaleControlStyle."+this.settings.mapScaleControl.style)
				},
				backgroundColor: this.settings.backgroundColor,
				draggable: this.settings.draggable,
				keyboardShortcuts: this.settings.keyboardShortcuts,
				scrollwheel: this.settings.scrollwheel,
				streetViewControl: this.settings.streetview,
				disableDoubleClickZoom: this.settings.disableDoubleClickZoom
			}


			this.gmap = new google.maps.Map(document.getElementById(this.attr("id")), this.mapOption);
			this.geocoder = new google.maps.Geocoder();
			search(this, this.gmap,this.geocoder, this.settings, false);

			var maDiv = this;
			$.each(this.settings.multi,function(i){
				search(maDiv, maDiv.gmap, maDiv.geocoder, this, true);
			});

			if(this.settings.zones!=""){
				loadZone(maDiv.gmap, this.settings.zones);
			}

			return false;
		},

		loadItineraire: function(options) {
			//Chargement des paramètres
			this.settings = {
				mapTypeControl: {
					display: true,
					mapTypeIds: aMapTypeDefaut.join(","),
					position: "TOP_RIGHT",
					style: "DEFAULT"
				},
				mapNavigationControl: {
					display: true,
					position: "TOP_LEFT",
					style: "DEFAULT"
				},
				mapScaleControl: {
					display: true,
					position: "BOTTOM_LEFT",
					style: "DEFAULT"
				},

				start: null,
				end: null,
				displayPanel: true,
				idPanel: "itineraireResult",
				zoom: 14,
				mode: "ROADMAP",
				backgroundColor: "#FFFFFF",
				draggable: true,
				scrollwheel: true,
				keyboardShortcuts: true,
				disableDoubleClickZoom: false,
				avoidHighways: false,
				avoidTolls: false,
				travelMode: "DRIVING",
				unitSystem: "METRIC"
			};
			$.extend(this.settings, options);
		
			//Vérification de la configuration
			if(verifSettingsItineraire(this.settings)){return false;}

			var aMapType = new Array();
			$.each(this.settings.mapTypeControl.mapTypeIds.split(","), function(){
				aMapType.push(eval("google.maps.MapTypeId."+this));
			});
			var latlng = new google.maps.LatLng(47.0102, 2.3730);

			this.mapOption = {
				zoom: this.settings.zoom,
				center: latlng,
				mapTypeId: eval("google.maps.MapTypeId."+this.settings.mode),
				mapTypeControl: this.settings.mapTypeControl.display,
				mapTypeControlOptions: {
					mapTypeIds: aMapType,
					position: eval("google.maps.ControlPosition."+this.settings.mapTypeControl.position),
					style: eval("google.maps.MapTypeControlStyle."+this.settings.mapTypeControl.style)
				},
				navigationControl: this.settings.mapNavigationControl.display,
				navigationControlOptions: {
					position: eval("google.maps.ControlPosition."+this.settings.mapNavigationControl.position),
					style: eval("google.maps.NavigationControlStyle."+this.settings.mapNavigationControl.style)
				},
				scaleControl: this.settings.mapScaleControl.display,
				scaleControlOptions: {
					position: eval("google.maps.ControlPosition."+this.settings.mapScaleControl.position),
					style: eval("google.maps.ScaleControlStyle."+this.settings.mapScaleControl.style)
				},
				backgroundColor: this.settings.backgroundColor,
				draggable: this.settings.draggable,
				keyboardShortcuts: this.settings.keyboardShortcuts,
				scrollwheel: this.settings.scrollwheel,
				disableDoubleClickZoom: this.settings.disableDoubleClickZoom
			}


			this.gmap = new google.maps.Map(document.getElementById(this.attr("id")), this.mapOption);
			this.directionsService = new google.maps.DirectionsService();
			this.directionsDisplay = new google.maps.DirectionsRenderer();
			this.directionsDisplay.setMap(this.gmap);
			if(this.settings.displayPanel){
				this.directionsDisplay.setPanel(document.getElementById(this.settings.idPanel));
			}
			calcRoute(this.directionsService, this.directionsDisplay, this.settings);
		
			return false;
		}
	});

})(jQuery);