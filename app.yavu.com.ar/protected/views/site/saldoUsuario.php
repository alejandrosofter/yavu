<?php
$cliente=YavuWeb::getCliente();
$saldo=$cliente['importeSaldo']*1;
?>
<h1>DETALLE DE CUENTA <small>general</small>
<?php if($saldo>0) $this->renderPartial('/usuarios/pagoSaldo',array('idCliente'=>$cliente['id'],'saldo'=>$saldo))?></h1>
<table class='table table-condensed'>
<tr><th>FECHA</th><th>DETALLE</th><th>IMPORTE</th><th>SALDO</th></tr>
<tbody>
<?php
$data=YavuWeb::consultarDeuda();
$total=0;
$data2 = array_reverse($data);
for($i=0;$i<count($data);$i++){
	$item=$data[$i];
	$item2=$data2[$i];
	$impAux=$item['importe']*1;
$total+=-$impAux;
$color=$total>0?'blue':'red';
?>
<tr>
	<td><?=Yii::app()->dateFormatter->format("dd/MM/yy",$item['fecha'])?></td>
	<td><?=$item['detalle']?></td>
	<td >$ <?=number_format($impAux,2)?></td>
	<th style='color:<?=$color?>'><?=number_format($total,2)?></th>
</tr>
<?php }?>
</tbody>
</table>
<script>
$(function(){
    $("tbody").each(function(elem,index){
      var arr = $.makeArray($("tr",this).detach());
      arr.reverse();
        $(this).append(arr);
    });
});
</script>