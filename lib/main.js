var datePicker = document.querySelector("#datetimepicker12");

if(datePicker !== 'undefined'){
    jQuery(document).ready(function(){
        try{
        var dt = jQuery('#datetimepicker12').data("DateTimePicker").date();

        jQuery('#datetimepicker12').on('dp.change', function(e){ 
            var now = e.date.year() + '_' + (e.date.month()+1) + '_' + e.date.date() + '_' + e.date.hour() + '_' + e.date.minutes() + '_00'
            jQuery("#fecha_servicio").val(now);
        });
        
        }catch(e){

        }
    });
}

jQuery("#main").on("click", "#precontratar-asociado", function(e){
    e.preventDefault();
    jQuery.ajax({
        url : "https://youneed.com.ec/wp-admin/admin-ajax.php",
        type: 'post',
        data: {
            action : 'api_youneed_check_cart'
        },
        beforeSend: function(){
            jQuery("#panel-asociado").LoadingOverlay("show", {maxSize: 70 });
        },
        success: function(data){
            if(data){
                Swal.fire({
                    title: '<strong>Contrato en proceso</strong>',
                    type: 'info',
                    html:
                      'Usted tiene un contrato activo en el carrito, ' +
                      'elija "Nuevo carrito" para borrarlo y seguir con este contrato.',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,
                    confirmButtonText:
                      '<i class="fas fa-cart-arrow-down"></i> Nuevo carrito',
                    confirmButtonAriaLabel: 'Nuevo carrito',
                    cancelButtonText:
                      '<i class="fa fa-shopping-cart"></i> Ver carrito',
                    cancelButtonAriaLabel: 'Ver Carrito',
                  }).then((result) => {
                    if (result.value) {
                        jQuery.ajax({
                            url : "https://youneed.com.ec/wp-admin/admin-ajax.php",
                            type: 'post',
                            data: {
                                action : 'api_youneed_empty_cart'
                            },
                            success: function(data){
                                if(data){
                                    jQuery("form#contratar-asociado").submit();
                                }
                            }
                        });
                    }else{
                        window.location.replace("https://youneed.com.ec/contratar");
                    }
                  })
            }else{
                jQuery("form#contratar-asociado").submit();
            }
        },
        complete: function(){
            jQuery("#panel-asociado").LoadingOverlay("hide");
        }

    });
});


jQuery(document).ready(function(){

    jQuery.ajax({
        url : "https://youneed.com.ec/wp-admin/admin-ajax.php",
        type: 'post',
        data: {
            action : 'api_youneed_check_cart'
        },
        success: function(data){
            if(data){
                jQuery("#shopping-cart-menu > a > i").addClass("active-cart");
                jQuery("#shopping-cart-menu > a ").append("<span class='items-in-cart'>1</span>");
            }
        },
    })
});
// }
//         jQuery('#datetimepicker12').datetimepicker({
//             inline: true,
//             sideBySide: true
//         });
// }

//     var picker = $('#fecha_servicio'),
//         content = $('#fecha_servicio_content');

//     picker.datepicker({
//         language: 'es',
//         dataTimepicker: true,
//         onRenderCell: function (date, cellType) {

//         },
//         onSelect: function onSelect(fd, date) {
//             $(picker).val(date);
//             $(content).html(date);
//         }
//     })

//     // Select initial date from `eventDates`
//     var currentDate = currentDate = new Date();
//     picker.data('datepicker').selectDate(new Date(currentDate.getFullYear(), currentDate.getMonth(), 10))
// }

function initAutocomplete() {
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: -33.8688, lng: 151.2195},
      zoom: 13,
      mapTypeId: 'roadmap'
    });

    // Create the search box and link it to the UI element.
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
      searchBox.setBounds(map.getBounds());
    });

    var markers = [];
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function() {
      var places = searchBox.getPlaces();

      if (places.length == 0) {
        return;
      }
      
      $("#map").removeClass('hidden');

      // Clear out the old markers.
      markers.forEach(function(marker) {
        marker.setMap(null);
      });
      markers = [];

      // For each place, get the icon, name and location.
      var bounds = new google.maps.LatLngBounds();
      places.forEach(function(place) {
        if (!place.geometry) {
          console.log("Returned place contains no geometry");
          return;
        }
        var icon = {
          url: place.icon,
          size: new google.maps.Size(71, 71),
          origin: new google.maps.Point(0, 0),
          anchor: new google.maps.Point(17, 34),
          scaledSize: new google.maps.Size(25, 25)
        };

        // Create a marker for each place.
        markers.push(new google.maps.Marker({
          map: map,
          icon: icon,
          title: place.name,
          position: place.geometry.location
        }));

        if (place.geometry.viewport) {
          // Only geocodes have viewport.
          bounds.union(place.geometry.viewport);
        } else {
          bounds.extend(place.geometry.location);
        }
        $('#lat-map').val(place.geometry.location.lat);
        $('#lng-map').val(place.geometry.location.lng);
      });
      map.fitBounds(bounds);
    });
  }