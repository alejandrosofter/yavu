<div style=' font-size:12px; padding-right:20px'>
<input type="radio" name="tipoBusqueda"  value="expensas" checked> Expensas </input>
<input type="radio" name="tipoBusqueda"  value="contratos">Contratos
  <script type="text/javascript">
        $("input[name='tipoBusqueda']").change(function() {
            console.log("changed");
            if ($("input[name='tipoBusqueda']:checked").val() == 'expensas'){
               $("#idEdificio").select2("container").show();
               $("#s2id_idPropiedad").css('width','100px');
            }
            else if ($("input[name='tipoBusqueda']:checked").val() == 'contratos'){
              $("#idEdificio").select2("container").hide();
              $("#s2id_idPropiedad").css('width','200px');
            }
                
        });
    </script>


 <?php
$this->widget(
    'bootstrap.widgets.TbSelect2',
    array(
        'name' => 'idEdificio',
        'id'=>'idEdificio',
        'data' => CHtml::listData(Edificios::model()->findAll(), 'id', 'nombreEdificio'),
        'options' => array(
            'placeholder' => 'Edificio',
            'width' => '150px',
            'allowClear'=> true
        ),
        'htmlOptions'=>array('onchange'=>'cambiaEdificio()')
    )
);
?>
 -
<?php
$this->widget(
    'bootstrap.widgets.TbSelect2',
    array(
        'name' => 'idProp',
        'data' => CHtml::listData(Entidades::model()->findAll(), 'id', 'razonSocial'),
        'options' => array(
            'placeholder' => 'Entidad',
            'width' => '250px',
             'allowClear'=> true
        ),
        'htmlOptions'=>array('onchange'=>'cambiaPropietario()')
    )
);
?>
 -
<?php
$this->widget(
    'bootstrap.widgets.TbSelect2',
    array(
        'name' => 'idPropiedad',
        'data' => CHtml::listData(Propiedades::model()->findAll(), 'id', 'nombrePropiedad'),
        'options' => array(
            'placeholder' => 'Propiedades',
            'width' => '100px',
             'allowClear'=> true
        ),
        'htmlOptions'=>array('onchange'=>'cambiaPropiedad()')
    )
);
?>
 <a onclick='reset()' class="">x</a>
<script>
function reset()
{
  buscarPropiedades("","");
  buscarPropietarios("")
}
function buscarPropietarios(idEdificio)
{
  $('#idProp').children().remove();
  $('#idProp').append('<option selected="selected" value=""></option>');
    $.getJSON( "index.php?r=propiedades/getPropietarios&idEdificio="+idEdificio, function( data ) {
     for (i = 0; i < data.length; i++) 
        $('<option value='+data[i].id+'>'+data[i].razonSocial+'</option>').appendTo('#idProp');
      $("#idProp").select2({placeholder: data.length+" Propietarios"});
      });
$('#idProp').css('width','250px');
}
function buscarPropiedades(idEntidad,idEdificio)
{
  $('#idPropiedad').children().remove();
  $('#idPropiedad').append('<option selected="selected" value=""></option>');
    $.getJSON( "index.php?r=propiedades/getPropiedades&idEntidad="+idEntidad+"&idEdificio="+idEdificio, function( data ) {
     for (i = 0; i < data.length; i++) 
        $('<option value='+data[i].id+'>'+data[i].nombrePropiedad+'</option>').appendTo('#idPropiedad');
      $("#idPropiedad").select2({placeholder: data.length+" Propiedades"});
      });
$('#idPropiedad').css('width','200px');
}
function cambiaPropietario(data)
{
  $('#idPropiedad').children().remove();
  $('#idPropiedad').append('<option selected="selected" value=""></option>');
  buscarPropiedades($('#idProp').val(),$('#idEdificio').val());
}
function llenarPropietarios()
{
  buscarPropietarios($('#idEdificio').val());
  
}
function cambiaEdificio()
{
 llenarPropietarios();
 buscarPropiedades(null,$('#idEdificio').val());
}
function cambiaPropiedad()
{
  buscarDeuda($('#idPropiedad').val());
}
function buscarDeuda(id)
{
    $.getJSON( "index.php?r=paraCobrar/getDeuda&idPropiedad="+id, function( data ) {
      $('#resultadosDeuda').html(data.data);
      cambiarCliente(id);
      buscarCreditos();

      });
}

</script>
<a class="ventana" data-fancybox-type="iframe" id='btnImprime' href=""></a>

<script type="text/javascript">
$(document).ready(function()
{
  $(".ventana").fancybox({
    fitToView : false,
    width   : '80%',
    afterClose : function() {
        location.reload();
        return;
    },
    height    : '100%',
    autoSize  : false,
    closeClick  : false,
    openEffect  : 'elastic',
    closeEffect : 'elastic'
  });

    
});

</script>
</div>