<html>
<head>
<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.3.min.js"></script>
<script src="js/printThis/printThis.js"></script>
<link rel="stylesheet" href="css/impresionComprobante.css">
</head>
<body>
<button style='width:100%' onclick='imprimirPapel()'><big>Imprimir</big></button> <br>
<?=$texto;?>
<script>

function imprimirPapel(debugFalg)
{
    $(".impresionPapel").printThis({
      debug: debugFalg,             
      importCSS: true,           
      printContainer: true,      
      loadCSS: "css/impresionComprobante.css",             
      removeInline: false        
  });
}
</script>
</body>
</html>