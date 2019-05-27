var datePicker = document.querySelector(".datepicker-here");

if(datePicker !== undefined && $datePicker !== null){
    var $picker = $('#fecha_servicio'),
        $content = $('#fecha_servicio_content');

    $picker.datepicker({
        language: 'es',
        dataTimepicker: true,
        onRenderCell: function (date, cellType) {

        },
        onSelect: function onSelect(fd, date) {
            $('strong', $content).html(date)
        }
    })

    // Select initial date from `eventDates`
    var currentDate = currentDate = new Date();
    $picker.data('datepicker').selectDate(new Date(currentDate.getFullYear(), currentDate.getMonth(), 10))
}