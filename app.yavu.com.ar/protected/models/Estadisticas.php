<?php 
class Estadisticas extends CModel
{
 public static function model($className=__CLASS__)
 {
 return parent::model($className);
 }
 public function attributeNames()
 {
return array(
);
 }
 public static function consultar($periodo,$tabla,$anterior=false)
 { 
  $clase=ucfirst($tabla);
  $res=$clase::model()->$periodo($anterior);
  return number_format($res,2);
 }
 public static function graficaAnual($ano){
 	$res=Array();
 	for($i=1;$i<=12;$i++)
 		$res[]=Comprobantes::model()->importeMes($i,$ano)*1;
 	return $res;
 }
}
?>