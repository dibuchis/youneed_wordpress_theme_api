var datePicker = document.querySelector("#fecha_servicio");

if(datePicker !== undefined && datePicker !== null){
    $(document).ready(function(){
        $('#datetimepicker12').datetimepicker({
            inline: true,
            sideBySide: true
        });
    });
}

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