<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap-editable/js/bootstrap-editable.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="js/jquery.sticky.js"></script>

<link href="js/select2-master/dist/css/select2.css" rel="stylesheet" type="text/css"></link>  
<script src="js/select2-master/dist/js/select2.full.js"></script>  
<script src="js/turn/turn.html4.min.js"></script>  



<h1><img src='images/iconos/glyphicons/glyphicons_235_pen.png'/> Agregar <small>Comprobante</small>

<?php if(count($_SESSION["paraFacturar"])>0){?>
  <button onclick='agregarSolicitudes()' id='btnAgregarSolicitudes' class="btn btn-info" type="button"><i class=" icon-plus-sign icon-white"></i> (<?=count($_SESSION["paraFacturar"]);?>) Solicitudes para facturar</button>
   <button onclick='quitarSolicitudes()' id='btnquitarSolicitudes' class="btn btn-danger" type="button"><i class=" icon-remove icon-white"></i> Vaciar Solicitudes</button>
 <?php }?>
</h1>
<div  class="btn-group btn-group-vertical"  style='float:right;padding-top:50px' id='botones'>
<button onclick="agregarItem()" id='btnAgregar' class="btn  btn-inverse" type="button"><i class=" icon-plus-sign icon-white"></i> Nuevo Item        </button>


</div>
<div style='margin: auto;
    width: 75%;padding-top: 50px;'>
<?=$plantilla?>
</div>

<?=$this->renderPartial('_finalizarComprobante',array());?>

<div style="width:100%;padding-top:50px">
  <button style="float:right" onclick="abreVentana()" id='btnAceptar' class="btn btn-success" type="button"><h1>FINALIZAR </h1> </button>
</div>
<script type="text/javascript">


var dataComprobante={idTipoComprobante:<?=$params['idTipoComprobante']?>,fecha:"<?=$params['fecha']?>",idEntidad:<?=$params['idEntidad']?>,esElectronica:<?=$params['hayElectronica']?>};
init();
var facturaSolicitudes=false;
function init()
{
    iniciarStickBotonera();
 //   setTimeout(mover, 2000);
    iniciarEditores();
    tooltipsBotonera();
    chequearTipoFactura(dataComprobante.idTipoComprobante);
    setDatosEntidad(<?=$params['idEntidad']?>);
}
  function agregarSolicitudes()
  {
   
    $.blockUI({ css: { backgroundColor: '#ccc', color: '#fff'},message: '<h1>AGREGANDO ITEMS ...</h1>',  });
		$.getJSON("index.php?r=solicitudesServicio/facturarCanasta",function(data){
			sweetAlert("Genial!", "Se han agregado las solicitudes, termina el comprobante para que se marquen como facturados!", "success");
      $('#paraFacturar').html("");
      quitarItem(1);
      agregarItemsCanasta(data);
      facturaSolicitudes=true;
      $('#btnAgregarSolicitudes').hide();
      $('#btnquitarSolicitudes').hide();
      $.unblockUI();
		});
    
  }
  function agregarItemsCanasta(data)
  {
    data.forEach(function(item) {
    agregarItem(item.cantidad,item.requerimiento,0);
});
  }
  function quitarSolicitudesServer()
  {
    $.blockUI({ css: { backgroundColor: '#ccc', color: '#fff'},message: '<h1>VACIANDO CANASTA ...</h1>',  });
		$.get("index.php?r=solicitudesServicio/vaciarFacturar",function(data){
			sweetAlert("Genial!", "Se ha vaciado la canasta!", "success");
      $('#paraFacturar').html("");
      $('#btnAgregarSolicitudes').hide();
      $('#btnquitarSolicitudes').hide();
      $.unblockUI();
		});
  }
  function quitarSolicitudes() {
    sweetAlert({
      title: "Estas seguro de vaciar las solicitudes?",
      text: "Igualmente las solicitudes seguiran estando, solo vaciaras la canasta de solicitudes",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Si vaciar!",
      closeOnConfirm: false
    }, function() {
      quitarSolicitudesServer();
    });
  }
function abreVentana()
{
    if(datosValidos())abrir();  
    //$(".btn").button("reset");
}
function tieneItems()
{
    var res=false;
    items.forEach(function(item) {
        if(item.habilitado){res= true;return;}
    });
    return res;
}

function importeFacturaValido()
{
    var total=0;
    items.forEach(function(item) {
        total+=item.importe;
    });
    return total>0;
}
function getImporteTotal()
{
    var total=0;
    items.forEach(function(item) {
        if(item.habilitado)
        total+=(item.importe*1)*(item.cantidad*1);
    });
    return total;
}
function datosValidos()
{
    if(!tieneItems()){
        
       sweetAlert("Oops...", "Debe ingresar por lo menos 1 item!", "error");
        
        return false;
    }
    if(!importeFacturaValido()){
       sweetAlert("Oops...", "Los items ingresados deben tener un importe!", "error");
        return false;
    }
    if((dataComprobante.letraComprobante=='A' || dataComprobante.letraComprobante=='B') && !validaCuit(dataComprobante.cuit)){
       sweetAlert("Oops...", "El cuit ingresado "+dataComprobante.cuit+" es erroneo", "error");
        return false;
    }
    
    return true;
}
function abrir()
{
    $('#ventanaFinaliza').modal();
    calcularFinal();
}
function cancelarComprobante()
{
    swal({   title: "Estas seguro/a de cancelar el comprobante?",   text: "No podrá recuperar los datos cargados...",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Cancelar Comprobante!",   closeOnConfirm: false },function(){   location.reload() });
}
function tooltipsBotonera()
{
    $('#btnAceptar').popover({content:'Queda 1 paso para finalizar el comprobante',trigger:'hover',placement:'bottom'});
     $('#btnAgregar').popover({content:'Agregar Item',trigger:'hover',placement:'bottom'});
      $('#btnRenovar').popover({content:'Borrar Factura',trigger:'hover',placement:'bottom'});
}
function iniciarStickBotonera()
{
     $("#botones").stick_in_parent();
}

function chequearTipoFactura(tipoFactura)
{
    console.log('TIPO FACT: '+tipoFactura);
    $.getJSON('index.php?r=talonarios/getTalonario',{idTal:tipoFactura},function(data){
        if(data!=null){
        if(data.letraTalonario!='A' && data.letraTalonario!='B'){
            $('#pieItems').hide();
             $('td:nth-child(4)').hide();
             $('th:nth-child(4)').hide();
             console.log('es a o b');
        }else{
            $('#pieItems').show();
             $('td:nth-child(4)').show();
              $('th:nth-child(4)').show();
        };
        if(data.tipoElectronico==null){
            $('#facturaElectronica').hide();
            dataComprobante.puedeElectronica=0;
        }else{
            $('#facturaElectronica').show();
            dataComprobante.puedeElectronica=1;
        } 
        $('#nroComprobante').html(str_pad(data.proximo,6,'0','STR_PAD_LEFT'));
        dataComprobante.letraComprobante=data.letraComprobante;
    }
    });
}
function setDatosEntidad(idEntidad)
{
    $.getJSON('index.php?r=entidades/getEntidad',{idEntidad:idEntidad},function(data){
        dataComprobante.cuit=data.datos.cuit;
        dataComprobante.idEntidad=data.datos.id;
        dataComprobante.emailEntidad=data.datos.email;
        $('#condicionIvaReceptor').html(data.condicionIva);
        $('#direccionReceptor').html(data.datos.domicilio==''?'s/n':data.datos.domicilio);
        $('#cuitReceptor').html(data.datos.cuit==''?'s/n':data.datos.cuit);
    });
}
function iniciarComprobantes()
{
    $.getJSON('index.php?r=talonarios/getTipoTalonarios',function(data){
        $('#letraComprobante').editable({
            value:<?=$params['idTipoComprobante']?>,
            source: data,
             success: function(response, newValue) {
                dataComprobante.idTipoComprobante=newValue;
                
                $('#razonSocial_receptor').editable('show');
                chequearTipoFactura(newValue);
                
            }

        });
    });
}
function calcularLinea(linea)
{
    console.log(items);
    console.log('LINEA: '+linea);
    id=linea-1;
    var bruto=Number(items[id].importe)/1.21;
    var total=items[id].importe*items[id].cantidad;
    $('#importeNeto_'+linea).html(format_number(bruto,'$'));
    $('#importeTotal_'+linea).html(format_number(total,'$'));
}
function format_number(n, currency) {
    var x=Number(n);
    var cu=currency==null?'':currency;
    return cu + " " + x.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
}
function calcularGral()
{
    totalGral=0;
    totalBruto=0;
    totalIva=0;
    items.forEach(function(item) {
        if(item.habilitado){
        var bruto=(Number(item.importe)/1.21)*item.cantidad;
        var iva=(item.importe-(Number(item.importe)/1.21))*item.cantidad;
        var total=item.importe*item.cantidad;

        totalGral+=total;
        totalBruto+=bruto;
        totalIva+=iva;
    }
    });
    dataComprobante.importeTotal=totalGral;
    $('#gral_iva21').html(format_number(totalIva,'$'));
    $('#gral_bruto21').html(format_number(totalBruto,'$'));
    $('#totalGral').html(format_number(totalGral,''));
}
function iniciarEntidades()
{
    $.getJSON('index.php?r=entidades/getEntidades',function(data){
        $('#razonSocial_receptor').editable({
            source: data,
            value:dataComprobante.idEntidad,
            success: function(response, newValue) {
                setDatosEntidad(newValue);
                $('#1_cantidades_editable').editable('show');
            }
        });
    });
}
function iniciarElectronica()
{
    $('#facturaElectronica').editable({
        success: function(response, newValue) {
                dataComprobante.esElectronica=newValue.length>0?1:0;
                
            },
        emptytext:'Factura Normal',
        value: ['Factura Electronica'],    
        source: [
              {value: 'Factura Electronica', text: 'Factura Electronica'}
           ]
    });
}
function consultarFinalizoItem()
{
    swal({   title: "Desea agregar otro item?",   text: "",   type: "info",   showCancelButton: true,   confirmButtonColor: "#01c148",cancelButtonColor: "#c70000",   confirmButtonText: "Agregar Item",cancelButtonText:'Continuar',   closeOnConfirm: true }, 
        function(isConfirm){   if (isConfirm) agregarItem();  });
}
var items=Array();
agregarItem();
function agregarItem(cantidad_,detalle_,importe_)
{
  cantidad_=cantidad_==null?1:cantidad_;
  detalle_=detalle_==null?"ingrese el detalle":detalle_;
  importe_=importe_==null?0:importe_;
    var prox=items.length+1;
    var cad="<tr id='fila_"+prox+"'>";
          cad+="<td><a itemNro='"+prox+"' tipo='cantidad' id='"+prox+"_cantidades_editable' href='#'>"+cantidad_+"</a></td>";
          cad+="          <td><a itemNro='"+prox+"' tipo='detalle' data-type='textarea' id='"+prox+"_data_detalle' href='#'>"+detalle_+"</a></td>";
          cad+="        <td><a itemNro='"+prox+"' tipo='importe'  id='"+prox+"_data_importe' href='#'>"+importe_+"</a></td><td id='importeNeto_"+prox+"'>$ 0.00</td><td id='importeTotal_"+prox+"'>$ 0.00</td>";
           cad+="   <td style='width:10px'><img title='Quitar Item' data-placement='left' data-toggle='tooltip' onclick='quitarItem("+prox+")' style='cursor:pointer' src='images/iconos/glyphicons/glyphicons_207_remove_2.png'/></td>";
           cad+="   </tr>";
    $('#tablaItems tr:last').after(cad);
    
   var aux={ cantidad:cantidad_ , detalle:detalle_ , importe:importe_, habilitado:true };
    items.push(aux);
    iniciarEditorItem(prox);
    var sel='#'+prox+'_cantidades_editable';
   chequearTipoFactura(dataComprobante.idTipoComprobante);
    setTimeout(function(){$(sel).editable('show')},400);
}
function quitarItem(id)
{
    $("#fila_"+id).fadeOut();
    items[(id-1)].habilitado=false;
    calcularGral();
}
function iniciarEditores()
{
    iniciarElectronica();
    iniciarEntidades();
    iniciarComprobantes();
    $('#fechaComprobante').editable({
        success: function(response, newValue) {
                dataComprobante.fecha= (newValue.getDate()+1)+'/'+(newValue.getMonth()+1)+'/'+newValue.getFullYear();
            },
        format: 'yyyy-mm-dd',    
        viewformat: 'dd/mm/yyyy',    
        combodate: {
                minYear: 2000,
                maxYear: 2015,
                minuteStep: 1
           }
        });

     
}
function iniciarEditorItem(row)
{

    // LAS CANTIDADES
    $('#'+row+'_cantidades_editable').editable({
        emptytext:'ingrese...',
        inputclass:'number',
        validate: function(value) {

    if($.trim(value) == '') {
        return 'Debe ingresar un valor!';
    }
    if(!/^[0-9]+$/.test(value))return('Debe ingresar solamente numeros!');
},
      success: function(response, newValue) {
        var id=$(this).attr('itemNro');
        items[(id-1)].cantidad=newValue;
        calcularLinea(id);
        calcularGral();
        var lab= '#'+id+'_data_detalle';
        $(lab).editable('show');
}
    });
    // LOS DETALLES
    $('#'+row+'_data_detalle').editable({
         emptytext:'ingrese...',
        rows:5,
          validate: function(value) {
   if($.trim(value) == '') 
        return 'Debe ingresar un valor!';

},
      success: function(response, newValue) {
        var id=$(this).attr('itemNro');
        items[(id-1)].detalle=newValue;
    $('#'+$(this).attr('itemNro')+'_data_importe').editable('show');
}
    });
    // LOS IMPORTES
    $('#'+row+'_data_importe').editable({
         emptytext:'ingrese...',
         inputclass:'number',
        display: function(value) {
            if(value=='')return;
      $(this).text(format_number(value,'$'));
    } ,
          validate: function(value) {
            
   if($.trim(value) == '') {

        return 'Debe ingresar un valor!';
    }
    var num=Number(value);
    if(num.toFixed(2)=='NaN') return('Debe ingresar un numero real!');
    //if(!/^[0-9]+$/.test(value))

},
      success: function(response, newValue) {
        id=$(this).attr('itemNro');
        items[(id-1)].importe=newValue;
        calcularLinea(id);
        calcularGral();
   consultarFinalizoItem();
}
    });
    
    
}

function mover()
{
    $( "#contenedorComprobate" ).effect( "shake" );
}

</script>
