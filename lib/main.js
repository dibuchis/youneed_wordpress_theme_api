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