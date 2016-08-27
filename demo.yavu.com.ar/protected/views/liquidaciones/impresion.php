<html>
<head>
<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.3.min.js"></script>
<script src="js/printThis/printThis.js"></script>
<link rel="stylesheet" href="css/impresionExpensas.css">
</head>
<body>
<button style='width:100%' onclick='imprimirPapel()'><big>Imprimir</big></button> <br>
<?=$data;?>
Muestra Morosos <input type='checkbox' id='muestraMorosos' onclick='cambiaMorosos()' checked>

<script>
cambiaMorosos()
function cambiaMorosos()
{
	if($( "#muestraMorosos" ).prop( "checked"))$('#tablaMorosos').show();
	else $('#tablaMorosos').hide();
}
function imprimirPapel(debugFalg)
{
    $(".impresionPapel").printThis({
      debug: debugFalg,             
      importCSS: true,           
      printContainer: true,      
      loadCSS: "css/impresionExpensas.css",             
      removeInline: false        
  });
}
</script>
</body>
</html>