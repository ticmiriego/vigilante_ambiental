$(document).ready(function(){
    Webcam.set({
        width: 320,
        height: 240,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    Webcam.attach('#camara');
    $('div#botones div.panel').css('display', 'none');
    $('div#botones button').click(function(){
        var valor = $(this).attr('id');
        $('div#botones button').removeClass('btn-lg');
        $(this).addClass('btn-lg');
        $('#id_tipo_denuncia').val(valor.substring(1));
        $('div#botones div.panel').css('display', 'none');
        $('#p'+valor.substring((1))).css('display', 'block');
        $('#denuncia').css('display', 'block');
    });
});