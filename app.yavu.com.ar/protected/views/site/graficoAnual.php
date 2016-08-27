<script type="text/javascript">
var opciones={
        chart: {
            type: 'column'
        },
        title: {
            text: 'ANUAL VS. ANUAL ANTERIOR'
        },
        xAxis: {
            categories: [
                'Enero',
                'Febrero',
                'Marzo','Abril','Mayo','Junio','Julio','Ago.','Sept.','Oct.','Nov.','Dic'
            ]
        },
        yAxis: [{
            min: 0,
            title: {
                text: 'MESES'
            }
        }, {
            title: {
                text: 'FACTURACION'
            },
            opposite: true
        }],
        legend: {
            shadow: false
        },
        tooltip: {
            shared: true
        },
        plotOptions: {
            column: {
                grouping: false,
                shadow: false,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Año en curso',
            color: 'rgba(165,170,217,1)',
            data: [150, 73, 20, 54,2,3,65,2,3,6,4,3],
            pointPadding: 0.3,
             tooltip: {
               
                pointFormat: "$ {point.y:.2f}"
            },
            pointPlacement: -0.2
        }, {
            name: 'Año Anterior',
            color: 'rgba(126,86,134,.9)',
            data: [140, 90, 40,33,65,4,23,65,8,9,2,11],
            pointPadding: 0.4,
            pointPlacement: -0.2
        }, ]
    };
    getDatos();
    function getDatos()
    {
        $.getJSON('index.php?r=site/graficaAnual',function(data){
            opciones.series[0].data=data.anoActual;
            opciones.series[1].data=data.anoAnterior;

            $(function () {$('#container').highcharts(opciones);});
        });
    }

		</script>
	</head>
	<body>
<script src="js/Highcharts-4.1.9/js/highcharts.js"></script>
<script src="js/Highcharts-4.1.9/js/modules/exporting.js"></script>

<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>