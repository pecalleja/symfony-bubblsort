/**
 * Created by pecalleja on 3/1/2016.
 */
(jQuery)(function () {
    (jQuery)('#container-grafico').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Usuario: pecalleja'
        },
        subtitle: {
            text: 'En el mes Agosto 2015 acumula: 150 MB'
        },
        xAxis: {
            title: {
                text: 'Dias del Mes'
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'MBytes'
            },
            plotLines: [
                {
                    color: 'orange',
                    value: '153', // Insert your average here
                    width: '1',
                    zIndex: 2, // To not get stuck below the regular plot lines
                    label: {
                        text: 'Promedio: 153 KB',
                        align: 'left'
                    }
                },
                {
                    color: 'red',
                    value: '217', // Insert your average here
                    width: '1',
                    zIndex: 2, // To not get stuck below the regular plot lines
                    label: {
                        text: 'Maximo: 217 KB',
                        align: 'left'
                    }
                }

            ]
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">Carga: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: "Carga Diaria",
            color: 'green',
            data: [49.9, 71.5, 0, 0, 0, 106.4, 129.2, 144.0, 0, 176.0, 135.6, 148.5, 0, 216.4, 194.1, 95.6, 54.4]

        }, {
            name: 'Maximo',
            color: 'red'
        }, {
            name: 'Promedio',
            color: 'orange'
        }
        ],
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -150,
            y: 5,
            floating: true,
            borderWidth: 1,
            enabled: true
        }
    });
});