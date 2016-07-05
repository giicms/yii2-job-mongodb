$(document).ready(function () {

    $('#basic2').selectpicker({
        liveSearch: true,
        maxOptions: 1
    });
});
$(document).ready(function () {

    $('#basic1').selectpicker({
        liveSearch: true,
        maxOptions: 1
    });
});
$(document).ready(function () {

    $('#basic3').selectpicker({
        liveSearch: true,
        maxOptions: 1
    });

});
$(document).ready(function () {

    $('.select-box').selectpicker({
        liveSearch: true,
        maxOptions: 1
    });

});
$(function () {
    $('.datetimepicker').datepicker({
        //beforeShowDay: $.datepicker.noWeekends,
        minDate  : 1,
        dateFormat : 'dd-mm-yy'
    });
});


$('input:radio').click(function () {
    $('input:radio[name=' + $(this).attr('name') + ']').parent().removeClass('active');
    $(this).parent().addClass('active');
});

$('.scroll').mCustomScrollbar({
    theme: "dark-3"
});




$('.openModal').click(function () {
//    $.pgwModal({
//        url: 'moi_nv.html',
//        loadingContent: '<span style="text-align:center">Loading in progress</span>',
//        closable: false,
//        titleBar: false
//    });
$.pgwModal({
    target: '#modalContent',
    title: $(this).attr('title'),
    maxWidth: 600
});
})
