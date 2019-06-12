var datePicker = document.querySelector("#datetimepicker12");
var dia = [
    'Domingo',
    'Lunes',
    'Martes',
    'Miércoles',
    'Jueves',
    'Viernes',
    'Sábado'
];

if(datePicker !== 'undefined'){
    jQuery(document).ready(function(){
        try{
        var dt = jQuery('#datetimepicker12').data("DateTimePicker").date();

        jQuery('#datetimepicker12').on('dp.change', function(e){ 
            var now = e.date.year() + '_' + (e.date.month()+1) + '_' + e.date.date() + '_' + e.date.hour() + '_' + e.date.minutes() + '_00';
            var nowFormated = dia[e.date.getUTCDay()] + ' ' + e.date.year() + '/' + (e.date.month()+1) + '/' + e.date.date() + ' ' + e.date.hour() + ':' + e.date.minutes();
            jQuery("#fecha_servicio").val(now);
            jQuery("#time-service").val(nowFormated);
            // console.log(e.date);
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