$(function() {
	var ctx         = $("#chartAhorros");
	var uri         = window.location.origin + window.location.pathname + "Chart/";	// Dirección para obtener los datos del Chart
	var meses       = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
	var yearDefault = $("#year").val();	// Se obtiene el año seleccionado por defecto
	var colors      = ['#008b8b', '#ff0000', '#008000', '#ffff00', '#00ffff', '#8b008b', '#dc143c', '#ff7f50', '#b22222', '#ffd700', '#808080', '#ffa500'];

	// Se crea la instancia de la clase Chart
	var myChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: [],
			datasets: [{
				label: "",
				data: []
			}]
		},
		options: {
			scales: {
				yAxes: [{
					stacked: true,
					ticks: {
						beginAtZero:true,
						// Incluir símbolo de €
						callback: function(value, index, values){
							return value + " €";
						}
					}
				}],
				xAxes: [{
					stacked: true,
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
			legend: {
				display: false
			},
			tooltips: {
				// Se incluye el símbolo de € en el label del tooltip y se cambia el color del box
				callbacks: {
					label: function(tooltipItem, data){
						return tooltipItem.yLabel + " €";
					},
					labelColor: function(tooltipItem, chart){
						return {
							borderColor: 'white',
                        	backgroundColor: colors[tooltipItem.index]
						}
					}
				}
			},
			maintainAspectRatio: false
		}
	});

	// Maneja el evento change del input #year
	$("#year").change(function(event) {
		var year = $(this).val();

		// Se recargará con los datos correspondientes al año elegido
		chart(year);
	});

	function chart(year = yearDefault){
		$.getJSON(uri + year, function(data){
			// En caso de no obtener datos se mostrará una alerta
			if (!data.length) {
				// Se eliminan los alert que ya existan
				$(".chart-container div").remove();

				$("<div>")
					.addClass('alert alert-info text-center')
					.text('No hay datos para mostrar')
					.appendTo('.chart-container');

				// Se oculta el canvas
				ctx.hide();
				ctx.parent().css('height', 'auto');

				return;
			}
			
			let bgColor                 = "";
			let bgColorHover            = "";
			let backgroundsColor        = [];	// Colores de fondo asignados a cada item del chart
			let hoverBackgroundsColor   = [];	// Colores de fondo :hover asignados a cada item
			let datos                   = [];	// Datos del chart
			let labels                  = [];	// Labels del chart

			// Con los datos obtenidos se convierten para pasarlos como parametros del Chart
			$.each(data, function(index, val){
				// Labels que se mostrarán en el chart
				labels.push(meses[val.month-1]);

				// Datos reflejados en el chart
				datos.push(val.cantidad);

				// Color del background
				bgColor      = colors[index] + "ff";
				bgColorHover = colors[index] + "bb"

				// Se añade el background para cada item del chart
				backgroundsColor.push(bgColor);
				hoverBackgroundsColor.push(bgColorHover);
			});

			updateChart(datos, labels, backgroundsColor, hoverBackgroundsColor, year);
		});
	}
	
	// Función encargada de actualizar los datos del chart
	function updateChart(datos, labels, backgroundsColor, hoverBackgroundsColor, year){
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
	}

	/////////////////////////////////////////////////

	// Se llama la función chart al cargar por primera vez la página
	chart();
});