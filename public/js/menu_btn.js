$(function() {
$('.menu_btn').click(function(event)
{
    $('#targetPage')[0].value = $(this)[0].name;
    $('#frmMenu').submit();
})
});