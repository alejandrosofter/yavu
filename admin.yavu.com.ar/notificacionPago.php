<?php
//**************************************** RETORNA DE MP***************************************//
if(isset($_GET['topic']))
	if($_GET['topic']=='payment')
		if(isset($_GET['id'])){
            if( esDeSolicitudCertificado()){
                cargarSolicitud();
                return;
            }
            if(!existeId($_GET['id']))agregarPago();
            else modificarPago();


        }
//cargarSaldo(7,200);
//**************************************** RETORNA DE MP***************************************//

    //****************************************FUNCIONES DE BD***************************************//
        $g_link = false;
        function cargarSolicitud()
        {
            $res=estadoPre($_GET['id']);
            $col=($res['response']['collection']);
            $id= $col['external_reference'];
            $estado= $col['status'];
            $resArr=explode('_',$id);
            $idSolicitud=$resArr[0];
            $fecha= $col['date_created'];
            $arrFecha=explode("T", $fecha);
            if($estado=='approved')modificarSolicitud($idSolicitud,"EN PROCESO",$arrFecha[0]);
        }
        function modificarSolicitud($id,$estado,$fecha)
        {
            conectar();
            $sql="UPDATE solicitudesAfip set estado='".$estado."', fechaPago='".$fecha."' WHERE id=".$id;
            $res=consultar($sql);
        }
        function esDeSolicitudCertificado()
        {
            $res=estadoPre($_GET['id']);
            $col=($res['response']['collection']);
            $id= $col['external_reference'];
            $resArr=explode('_',$id);
        return count($resArr)>1; //ENTONCES ES DE CERTIFICADOS
    }
    function conectar()
    {
        global $g_link;
        if( $g_link )
            return $g_link;
        $g_link = mysql_connect( 'localhost', 'root', 'vertrigo') or die('Could not connect to server.' );
        mysql_select_db('yavu', $g_link) or die('Could not select database.');
        return $g_link;
    }
    function modificarPago()
    {
    	$res=estadoPre($_GET['id']);
      $col=($res['response']['collection']);
      $idVenta= $col['external_reference'];
      $estado= $col['status'];
      $detalleEstado= $col['status_detail'];
      $fecha= $col['date_created'];
      $arrFecha=explode("T", $fecha);
      $importe= $col['transaction_amount'];
      $importeTotal= $col['total_paid_amount']*1;
      $importeNeto= $col['net_received_amount']*1;
      $idRef=$_GET['id'];

      $detalle="DETALLE DE ESTADO: $detalleEstado";
      conectar();
      $sql="UPDATE pagos set fecha='".$arrFecha[0]."',estado='$estado',detalleRtaMP='$detalle' where idReferenciaMP=$idRef";
      echo $sql;
      consultar($sql);
      if($estado=='approved')cargarSaldo($idVenta,-$importeTotal);
  }
  function cargarSaldo($idCliente,$importe)
  {
    $cli=getClienteID($idCliente);

    cargarSaldoCliente($idCliente,$importe);
    cargarSaldoRecomendado($cli,$cli['recomendado'],$importe);
    cambiaEstadoCliente($cli);
}
function cambiaEstadoCliente($cli)
{
    $saldo=($cli['importeSaldo']*1);
    echo $saldo;
    if($saldo <=0 ) cambiarEstado($cli['id'],'ACTIVO');
}
function cambiarEstado($idCliente,$estado)
{
    echo 'cambiando';
    conectar();
    $sql="UPDATE clientes set estado='".$estado."' where id=$idCliente";
    consultar($sql);
}
function cargarSaldoCliente($idCliente,$importe)
{
    conectar();
    $sql="UPDATE clientes set importeSaldo=(importeSaldo+".$importe.") where id=$idCliente";
    consultar($sql);
}
function cargarSaldoRecomendado($cliente,$emailRecomendado,$importe)
{
    if($emailRecomendado!=''){
        $cli=getCliente($emailRecomendado);
        if($cli){
                $importeCarga=$importe*0.1; //EL DIEZ por ciento
                cargarSaldoCliente($cli['id'],$importeCarga);
                ingresarEnDetalle($cliente,$cli['id'],$importeCarga);
            }
        }
    }
    function ingresarEnDetalle($clienteBase,$idCliente,$importe)
    {
        conectar();
        $idClienteBase=$clienteBase['id'];
        $detalle='PAGO POR RECOMENDACION '.$clienteBase['email'];
        $sql="INSERT into pagos values(null,'".Date('Y-m-d')."',1,$importe,$idCliente,0,0,'PAGADO','$detalle',$importe,$idClienteBase)";
        consultar($sql);
    }
    function getClienteID($id)
    
    {
        conectar();
        $query = "SELECT * FROM clientes where id='".$id."'"; 
        
        $result = mysql_query($query) or die(mysql_error());

        while($item = mysql_fetch_array($result))return $item;
        return false;
    }
    function getCliente($email)
    {
        conectar();
        $query = "SELECT * FROM clientes where email='".$email."'"; 
        
        $result = mysql_query($query) or die(mysql_error());
        while($item = mysql_fetch_array($result))return $item;
        return false;
    }
    function modificarSaldoCliente($idCliente,$importeTotal)
    {
        conectar();
        $query = "SELECT * FROM clientes_deudas where idCliente=".$idCliente." AND estado<>'PAGADA' order by fecha asc"; 
        
        $result = mysql_query($query) or die(mysql_error());

        $importeResto=$importeTotal;
        while($item = mysql_fetch_array($result)){
            if($importeResto<=0)return;
            echo 'QUEDAN $'.$importeResto;
            $importeDebito=0;
            $estado='';
            //$importeResto-=($item['importeSaldo']*1);
            if(($importeResto-($item['importeSaldo']*1))<0){
                $estado='PAGO_PARCIAL';
                $importeDebito=$importeResto;
                $importeResto=0;
                
            }else{
                $estado='PAGADA';
                $importeDebito=($item['importeSaldo']*1);
                $importeResto-=($item['importeSaldo']*1);
            }
            
            restarDeuda($estado,$item['idCliente'],$importeDebito,($item['importeSaldo']*1),$item['id']);
        }
        if($importeResto>0)cargarSaldo($idCliente,$importeResto);
        echo 'SALDO: '.$importeResto;
        

    }
    function restarDeuda($estado,$idCliente,$importeDebito,$importeSaldo,$idDeuda)
    {
        conectar();
        $sql="UPDATE clientes_deudas set estado='".$estado."', importeSaldo=".($importeSaldo-$importeDebito)." WHERE id=".$idDeuda;
        $res=consultar($sql);
    }
    function agregarPago()
    {
    	$res=estadoPre($_GET['id']);
      $col=($res['response']['collection']);
      $idCliente= $col['external_reference'];
      $estado= $col['status'];
      $detalleEstado= $col['status_detail'];
      $fecha= $col['date_created'];
      $arrFecha=explode("T", $fecha);
      $importe= $col['transaction_amount'];
      $importeTotal= $col['total_paid_amount']*1;
      $importeNeto= $col['net_received_amount']*1;
      $idRef=$_GET['id'];

      $detalle=print_r($col,true);
      conectar();
      $sql="INSERT into pagos values(null,'".$arrFecha[0]."',1,$importe,$idCliente,0,".$idRef.",'$estado','$detalle',$importeNeto,0)";
      consultar($sql);
      if($estado=='approved')cargarSaldo($idCliente,-$importeTotal);
		//if($estado=='approved')modificarSaldoCliente($idCliente,$importeTotal);
  }
  function estadoPre($id)
  {
   require_once dirname(__FILE__)."/protected/extensions/sdk-php-master/lib/mercadopago.php";
   $mp = new MP('5839987130287087', 'v5vbB8PyLJy7l48TH8zWjbyHKSWpthBF');
  // $mp->sandbox_mode(TRUE);
   return($mp->get_payment_info($id));
}
function existeId($id)
{
   conectar();
   $sql="SELECT * from pagos where idReferenciaMP=".$id;
   echo $sql;
   $result = mysql_query($sql);
   while ($row = mysql_fetch_object($result)) return true;
   return false;


}
function consultar($sql)
{
   return mysql_query($sql) or die('Consulta fallida: ' . mysql_error());
}

function limpiar()
{
    global $g_link;
    if( $g_link != false )
        mysql_close($g_link);
    $g_link = false;
}
    //****************************************FUNCIONES DE BD***************************************//
?>