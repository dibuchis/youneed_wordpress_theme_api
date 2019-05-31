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
            $("#panel-asociado").LoadingOverlay("show", {maxSize: 70 });
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
                      '<i class="fa fa-thumbs-down"></i> Ver carrito',
                    cancelButtonAriaLabel: 'Ver Carrito',
                  })
            }else{
                $("form#contratar-asociado").submit();
            }
        },
        complete: function(){
             $("#panel-asociado").LoadingOverlay("hide");
        }

    });
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