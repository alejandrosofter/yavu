<?php 
class YavuWeb extends CModel
{
    static $IMPORTE_RECOMIENDA=10;
 public static function model($className=__CLASS__)
 {
 return parent::model($className);
 }
 public function attributeNames()
 {
return array(
);
 }
  public static function consultarSolicitudesAfip()
 {
    $connection=Yii::app()->dbYavu;
    $sql="SELECT * from solicitudesAfip  WHERE idCliente=".Yii::app()->user->idCliente." order by id desc"; //solamente los pendientes
        $command=$connection->createCommand($sql);
        $res= $command->queryAll();
        return $res;
 }
 public static function cargarPedidoAfip($cuit,$clave)
 {
    $connection=Yii::app()->dbYavu;
    $fecha=Date('Y-m-d');
    $idCliente=Yii::app()->user->idCliente;
    $estado="PEDIDO";
    $sql="INSERT INTO  solicitudesAfip (
`id` ,
`fecha` ,
`idCliente` ,
`claveAFIP` ,
`cuitAFIP` ,
`estado` 
)
VALUES (
NULL ,  '$fecha',  '$idCliente',  '$clave',  '$cuit',  '$estado');"; //solamente los pendientes
        $command=$connection->createCommand($sql);
        $res= $command->query();
        return $res;
 }
 public static function getCliente()
 {
    $connection=Yii::app()->dbYavu;
    $sql="SELECT * from clientes  WHERE id=".Yii::app()->user->idCliente;
        $command=$connection->createCommand($sql);
        $res= $command->queryAll();
        return $res[0];
 }
  public static function getClienteMail($email)
 {
    $connection=Yii::app()->dbYavu;
    $sql="SELECT * from clientes  WHERE email='".$email."'";
        $command=$connection->createCommand($sql);
        $res= $command->queryAll();
        if(count($res)>0)return $res[0];
        return false;
 }
 public static function getRecomendador($email)
 {
    $connection=Yii::app()->dbYavu;
    $sql="SELECT * from clientes  WHERE email='".$email."'";
        $command=$connection->createCommand($sql);
        $res= $command->queryAll();
        if(count($res)>0)  return $res[0];
        return false;
 }
  public static function consultarRecomendados($contea=false)
 { 
        $connection=Yii::app()->dbYavu;
        $sql="SELECT * from clientes t  WHERE recomendado='".Yii::app()->user->emailCliente."' order by t.fechaVto desc";
        $command=$connection->createCommand($sql);
        $res= $command->queryAll();
        if($contea)return count($res);
        return $res;
 }
  public static function cambiarRecomendado($recomendado)
 { 
        $connection=Yii::app()->dbYavu;
        $sql="UPDATE clientes set recomendado='".$recomendado."'  WHERE id=".Yii::app()->user->id;
        $command=$connection->createCommand($sql);
        $res= $command->query();
        return $res;
 }
 public static function consultarDeuda()
 { 
        $connection=Yii::app()->dbYavu;
        $sql="(SELECT fecha, CONCAT(servicios.nombreServicio,' por el periodo ',t.fechaInicio,' - ',t.fechaFin )  as detalle, importe, estado from clientes_deudas t inner join servicios on servicios.id= t.idServicio WHERE idCliente=".Yii::app()->user->idCliente." ) UNION ";
        $sql.="(SELECT fecha, IF(idPagoRecomendado<>0,detalleRtaMP,CONCAT('PAGO DE SERVICO')) as detalle, - importe, estado from pagos where idCliente=".Yii::app()->user->idCliente." )";
        $sql.=" ORDER BY fecha asc";
        $command=$connection->createCommand($sql);
        $res= $command->queryAll();
        return $res;
 }
  public static function cargarPlan($idServicio)
 { 
        $serv=self::getServicio($idServicio);
        $fecha=Date('Y-m-d');
        $fechaInicio=$fecha;
        $fechaFin=$serv['fechaVto'];
        $importe=$serv['importeServicio'];
        $estado="ACTIVO";
        $idCliente=Yii::app()->user->idCliente;
        $connection=Yii::app()->dbYavu;
        $sql="INSERT INTO clientes_deudas (idServicio,fecha,fechaInicio,fechaFin,importe,importeSaldo,estado,idCliente) VALUES(".$idServicio.",'".$fecha."','".$fechaInicio."','".$fechaFin."',".$importe.",".$importe.",'".$estado."',".$idCliente.") ";
        $command=$connection->createCommand($sql);
        $res= $command->query();
        return $res;
 }
 public static function cargarSaldo($idServicio)
 { 
    $idCliente=Yii::app()->user->idCliente;
    $serv=self::getServicio($idServicio);
        $connection=Yii::app()->dbYavu;
        $sql="UPDATE clientes set importeSaldo=(importeSaldo+(select importeServicio from servicios where id=".$idServicio.")),fechaVto='".$serv['fechaVto']."'  WHERE id=".$idCliente." ";
        $command=$connection->createCommand($sql);
        $res= $command->query();
        return true;
 }
 public static function getServicio($id)
 { 
        $connection=Yii::app()->dbYavu;
        $sql="SELECT t.*, now() as fechaInicio,date_add(now(), INTERVAL (t.duracion) MONTH) as fechaVto from servicios t  WHERE id=".$id." ";
        $command=$connection->createCommand($sql);
        $res= $command->queryAll();
        return $res[0];
 }


}
?>