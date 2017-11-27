$(function() {
	var ctxBar         = $("#chartBarGastos");	// Se obtiene el contexto o contenedor para el Chart tipo Bar
	var ctxDonut       = $("#chartDonutGastos");	// Se obtiene el contexto o contenedor para el Chart tipo Donut
	var uri            = window.location.origin + window.location.pathname;	// Dirección para obtener los datos del Chart
	var meses          = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
	var yearDefault    = $("#year").val();	// Se obtiene el año seleccionado por defecto
	var tipoDefault    = $("#chartTipo").val();	// Se obtiene el tipo seleccionado por defecto
	var colors         = ['#008b8b', '#ff0000', '#008000', '#ffff00', '#00ffff', '#8b008b', '#dc143c', '#ff7f50', '#b22222', '#ffd700', '#808080', '#ffa500'];

	// Se crea la instancia de la clase Chart
	var myChart = new Chart(ctxBar, {
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
				position: 'bottom',
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
                        	backgroundColor: colors[tooltipItem.datasetIndex]
						}
					}
				}
			},
			maintainAspectRatio: false
		}
	});

	// Se crea la instancia de la clase Chart
	var myChartDonut = new Chart(ctxDonut, {
		type: 'doughnut',
		data: {
			labels: [],
			datasets: [{
				label: "",
				data: []
			}]
		},
		options: {
			animation: {
				easing: "easeInOutBack"
			},
			title: {
				display: true,
				fontSize: 14,
				text: "Detalles de Gastos '" + tipoDefault + "'"
			},
			legend: {
				position: 'bottom',
			},
			tooltips: {
				// Se incluye el símbolo de € en el label del tooltip y se cambia el color del box
				callbacks: {
					label: function(tooltipItem, data){
						let value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
						let label = data.labels[tooltipItem.index];

						return label + ": " + value + "€";
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

	// Cuando se elija otro año se recargará con los datos correspondientes al año elegido
	$("#year").change(function(event) {
		let year = $(this).val();
		let tipo = $("chartTipo").val();

		chartBar(year);
		chartDonut(year, tipo);
	});

	// Cuando se elija otro 'tipo' se recargará el chart donut con los datos correspondientes al tipo elegido
	$("#chartTipo").change(function(event){
		let year = $("#year").val();
		let tipo = $("#chartTipo").val();

		chartDonut(year, tipo);
	});

	function chartBar(year = yearDefault){
		$.getJSON(uri + "Chart/" + year, function(data){
			// En caso de no obtener datos se mostrará una alerta
			if (!data.length) {
				// Se eliminan los alert que ya existan
				$(".chart-container div").remove();

				$("<div>")
					.addClass('alert alert-info text-center')
					.text('No hay datos para mostrar')
					.appendTo('.chart-container');

				// Se oculta el canvas
				ctxBar.hide();
				ctxBar.parent().css('height', 'auto');

				return;
			}

			let bgColor               = "";
			let bgColorHover          = "";
			let datos                 = [];	// Datos del chart
			let labels                = [];	// Labels del chart
			let categorias            = [];
			let aux                   = {};
			let ok                    = true;

			$.each(data, function(index, val) {
				if (aux.month != val.month) {
					// Se añade una nueva categoria
					categorias.push(meses[val.month-1])
				}

				indice = labels.findIndex(function(label){
					return label == this;
				}, val.tipo);

				if (indice == -1) {
					labels.push(val.tipo);
				}

				aux = val;
			});

			$.each(labels, function(index1, label) {
				values       = [];
				bgColor      = colors[index1] + "ff";
				bgColorHover = colors[index1] + "bb";

				$.each(categorias, function(index2, categoria) {
					ok = false;
					$.each(data, function(index3, val) {
						if (val.tipo == label && meses[val.month-1] == categoria) {
							values.push(val.cantidad);
							ok = true;
							return false;
						}
					});

					if (!ok) {
						values.push("");
					}
				});

				datos.push({
					label: label,
					data: values,
					backgroundColor: bgColor,
					hoverBackgroundColor: bgColorHover
				});

			});

			updateChartBar(datos, categorias, year);
		});
	}

	function chartDonut(year = yearDefault, tipo = tipoDefault){
		// Se obtienen los datos para mostrar el Chart Doughnut con los detalles de los gastos
		$.getJSON(uri+'ChartDoughnut/'+year+'/tipo/'+tipo, function(data) {
			// En caso de no obtener datos se mostrará una alerta
			if (!data.length) {
				// Se eliminan los alert que ya existan
				$(".chart-container.chart-donut div").remove();

				$("<div>")
					.addClass('alert alert-info text-center')
					.text('No hay datos para mostrar')
					.appendTo('.chart-container.chart-donut');

				// Se oculta el canvas
				ctxDonut.hide();
				ctxDonut.parent().css('height', 'auto');

				return;
			}else{
				ctxDonut.show();
			}

			let bgColor               = "";
			let bgColorHover          = "";
			let datos                 = [];
			let labels                = [];
			let backgroundsColor      = [];
			let hoverBackgroundsColor = [];
			let total                 = 0;

			// Con los datos obtenidos se convierten para pasarlos como parametros del Chart
			$.each(data, function(index, val){
				// Labels que se mostrarán en el chart
				labels.push(val.concepto);

				// Datos reflejados en el chart
				datos.push(val.cantidad);

				// Color del background
				bgColor      = colors[index] + "ff";
				bgColorHover = colors[index] + "bb"

				// Se añade el background para cada item del chart
				backgroundsColor.push(bgColor);
				hoverBackgroundsColor.push(bgColorHover);
			});

			updateChartDonut(datos, labels, backgroundsColor, hoverBackgroundsColor, tipo);
		});
	}

	// Función encargada de actualizar los datos del chart Bar
	function updateChartBar(datos, labels, year){
		// Se informa el chart con los datos obtenidos
		myChart.data.labels        = labels;
		myChart.options.title.text = 'Evolución de ' + year;
		myChart.data.datasets      = datos;

		// Se actualiza el chart
		myChart.update();
	}

	// Función encargada de actualizar los datos del chart Donut
	function updateChartDonut(datos, labels, backgroundsColor, hoverBackgroundsColor, tipo){
		// Se informa el chart con los datos obtenidos
		myChartDonut.options.title.text           = "Detalles de Gastos '" + tipo + "'";
		myChartDonut.data.labels                  = labels;
		myChartDonut.data.datasets.forEach((dataset) => {
			dataset.data                 = datos;
			dataset.backgroundColor      = backgroundsColor;
			dataset.hoverBackgroundColor = hoverBackgroundsColor;
		});

		// Se actualiza el chart
		myChartDonut.update();
	}


	/////////////////////////////////////////////////
	
	// Muestra el formulario para editar el ingreso/gasto seleccionado
	
	$(".editForm").click(function(event) {
		let id = $(this).val();
		let url = '/gastos/';

		$("#formTipo").val($("#tipo-"+id).text());
		$("#formConcepto").val($("#concepto-"+id).text());
		$("#formFecha").val($("#fecha-"+id).text());
		$("#formCantidad").val($("#cantidad-"+id+" span").text());
		$("#formComentario").val($("#comentario-"+id).attr('data-value'));

		// Asignar el valor a la propiedad 'action' del formulario con el id del ingreso seleccionado
		// $(".formEdit form").attr('action', );("/id/" + id + "/edit");
		$(".formEdit form").attr('action', url + id + "/edit");

		// Se despliega el formulario
		$(".formEdit").fadeIn('slow');
	});

	
	// Oculta el formulario de edición de ingresos/gastos

	$("#cerrarForm").click(function(event) {
		$(".formEdit").fadeOut('slow');
	});


	/////////////////////////////////////////////////

	/*
		Se le añade al campo 'concepto' del formulario de ingreso la funcionalidad para obtener una
		lista de valores que el usario ha introducido anteriormente como concepto
	*/
	$.getJSON('/obtenerConceptos/gastos', function(data) {
		let conceptos = [];

		$.each(data, function(index, val) {
			conceptos.push(val.concepto);
		});

		$("#concepto, #formConcepto").autocomplete({
			source: conceptos
		});
	});

	/*
		Se obtiene los tipos de gasto del usuario
	*/

	$(".dropdown-menu .tipo").click(function(event) {
		event.preventDefault();
		let tipo = $(this).text();

		$("#tipo, #tipoConcepto").val($(this).text());

		// Se carga los conceptos en base al tipo de concepto seleccionado
		$.getJSON('/obtenerConceptos/gastos/tipo/'+tipo, function(data) {
			// Primero se eliminan, si hubieran, los conceptos existentes
			$("#dropdownConcepto li").remove();
			let conceptos = [];
			
			$.each(data, function(index, val) {
				conceptos.push(val.concepto);

				$("<li>").append($("<a>").text(val.concepto).addClass('concepto')).appendTo('#dropdownConcepto');
			});

			$("#concepto, #formConcepto").autocomplete({
				source: conceptos
			});

			$("#dropdownConcepto").removeAttr('style');
		});	
	});

	/*
		Se obtiene los conceptos de ingresos/gastos del usuario
	*/
	$(".dropdown-menu, .dropdown-menu .concepto").on('click', '.concepto', function(event) {
		event.preventDefault();

		$("#concepto").val($(this).text());
		$("#dropdown-menu").toggle();
	});


	/////////////////////////////////////////////////

	// Se cargan los chart por primera vez al cargar la página
	chartBar();
	chartDonut();
});