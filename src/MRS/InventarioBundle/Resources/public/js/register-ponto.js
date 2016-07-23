var $registerponto = jQuery.noConflict();


function enviarAjax($registerponto,dados)
{
    $registerponto.ajax({
        type: "POST",
        url: "/horario/horarioregister",
        data: {data : dados},

        beforeSend: function()
        {
            $registerponto(".btn-primary").hide();
        },

        complete: function(data)
        {
            $registerponto(".btn-primary").show();
            console.log(data);
        },

        success: function(data)
        {
            $registerponto(".btn-primary").show();
            data = $registerponto.parseJSON(data);
            $registerponto(".error").html(data.message);
            console.log(data);

        },

        error: function(data)
        {
            $registerponto(".btn-primary").show();
            console.log(data);
        }
    });

    return false;
}

$registerponto(document).ready(function(){

    $registerponto("#registerponto").click(function(){

        var data = 'Dados de Envio';
        enviarAjax($registerponto,data);

    });

});

