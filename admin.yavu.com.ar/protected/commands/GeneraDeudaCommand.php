<?php
class GeneraDeudaCommand extends CConsoleCommand 
{
    public function run($args) {
    	$this->generarDeuda();
    }
    //ESTE SCRIPT DEBE EJECUTARSE 1 VEZ POR DIA MEDIANTE UN CRON
    // crontab -e
    // ej. 0 12 * * * /usr/bin/php /var/www/yavu.com.ar/cron.php generaDeuda
    // este script se ejecutara todos los dias a las 12 del medio dia
    private function generarDeuda()
    {
    	$model=Ventas::model()->activos();
    	foreach($model as $item)
    		if($item->proximaFacturacion==0){
    			$this->facturar($item->id);
    			$item->proximaFacturacion=$item->periodicidad*30;//vuelvo el contador al inicio
    			$item->save();
    		}
    			else{
    				$item->proximaFacturacion=$item->proximaFacturacion-1;
    				$item->save();
    			}
	}
	private function facturar($idVenta)
	{
		$model=Ventas::model()->findByPk($idVenta);
		$deuda=new VentasDeuda;
		$actual=new DateTime(Date('Y-m-d'), new DateTimeZone("UTC"));
		$deuda->fecha=$actual->format('Y-m-d');
		$actual->add(new DateInterval('P10D'));
		$deuda->idVenta=$idVenta;

		$deuda->detalle="En concepto del periodo ".$actual->format('M Y');
		$deuda->importe=$model->importe;
		$deuda->importeSaldo=$model->importe;
		$deuda->fechaVto=$actual->format('Y-m-d');

		$deuda->estado='PENDIENTE';
		$deuda->save();
		$this->modificaSaldoCliente($model->importe,$model->idCliente);
	}
	private function modificaSaldoCliente($importe,$idCliente)
	{
		$cliente=Clientes::model()->findByPk($idCliente);
		$cliente->restaSaldo($importe);
	}
}
?>