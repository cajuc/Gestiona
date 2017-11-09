$(function(){
	var ctx                   = $("#chartIngresos");	// Se obtiene el contexto o contenedor para el Chart
	var uri                   = "http://gestiona.app/ingresosChart/";	// Dirección para obtener los datos del Chart
	var meses                 = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
	var yearDefault           = $("#year").val();	// Se obtiene el año seleccionado por defecto
	var backgroundsColor      = [];	// Colores de fondo asignados a cada item del chart
	var hoverBackgroundsColor = [];	// Colores de fondo :hover asignados a cada item

	// Se crea la instancia de la clase Chart
	window.myChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: [],
			datasets: [{
				label: '',
				data: []
			}]
		},
		options: {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero:true,
						// Incluir símbolo de €
						callback: function(value, index, values){
							return value + '€';
						}
					},
					gridLines: {
						display: false
					}
				}],
				xAxes: [{
					gridLines: {
						display: false
					},
					ticks: {
						autoSkip: false
					}
				}]
			},
			animation: {
				easing: "easeInOutBack"
			},
			title: {
				display: true,
				fontSize: 14,
				text: 'Evolución de ' + yearDefault
			},
			legend: false,
			tooltips: {
				displayColors: false,
				// Se incluye el símbolo de € en el label del tooltip
				callbacks: {
					label: function(tooltipItem, data){
						return tooltipItem.yLabel + " €";
					}
				}
			}
		}
	});

	function chart(year = yearDefault){
		$.getJSON(uri + year, function(data){
			let ctxHeight               = myChart.height;
			let datos                   = [];
			let labels                  = [];
			let bgColor                 = "";
			let bgColorHover            = "";
			let gradient, gradientHover = "";
			let middleOffset            = 0;	// Valor offset del segundo addColorStop del gradient
			let yStart                  = 0;	// Valor que índica donde empieza a pintarse el gradient
			let colors                  = ['#008b8b', '#ff0000', '#008000', '#ffff00', '#00ffff', '#8b008b', '#dc143c', '#ff7f50', '#b22222', '#ffd700', '#20b2aa', '#ffa500'];

			// Se crea un array con las cantidades de los ingresos obtenidos
			let values = $.map(data, function(item, index) {
				return item.cantidad;
			});
			
			// Se obtiene el valor mayor del array
			let max = values.reduce(function(a, b){
				return Math.max(a, b);
			});

			// Con los datos obtenidos se convierten para pasarlos como parametros del Chart
			$.each(data, function(index, val){
				yStart = getHeight(max, val.cantidad, ctxHeight);

				gradient      = myChart.ctx.createLinearGradient(0,yStart,0,ctxHeight);
				gradientHover = myChart.ctx.createLinearGradient(0,yStart,0,ctxHeight);

				// Labels que se mostrarán en el chart
				labels.push(meses[val.month-1]);

				// Datos reflejados en el chart
				datos.push(val.cantidad);

				// Color del background
				bgColor = colors[index] + "ff";
				bgColorHover = colors[index] + "bb"

				// Se añade el color
				gradient.addColorStop(0, bgColor);
				gradient.addColorStop(1, 'white');
				
				gradientHover.addColorStop(0, bgColorHover);
				gradientHover.addColorStop(1, 'white');

				// Se añade el background para cada item del chart
				backgroundsColor.push(gradient);
				hoverBackgroundsColor.push(gradientHover);
			});

			// Se informa el chart con los datos obtenidos
			myChart.data.labels = labels;
			myChart.options.title.text = 'Evolución de ' + year;
			myChart.data.datasets.forEach((dataset) => {
				dataset.data                 = datos;
				dataset.backgroundColor      = backgroundsColor;
				dataset.hoverBackgroundColor = hoverBackgroundsColor;
			});

			// Se actualiza el chart
			myChart.update();

			// Función para obtener el valor de 'y0' por el que debe empezar a pintarse el gradient
			function getHeight(maxItem, currentItem, ctxHeight){
				return ctxHeight - Math.floor((ctxHeight * currentItem) / maxItem);
			}
		});
	}

	// Cuando se elija otro año se recargará con los datos correspondientes al año elegido
	$("#year").change(function(event) {
		var year = $(this).val();

		chart(year);
	});

	// Se llama la función chart al cargar por primera vez la página
	chart();
});