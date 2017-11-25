$(function(){
	var ctx                   = $("#chartIngresos");	// Se obtiene el contexto o contenedor para el Chart
	var ctxHeight             = ctx.height;	// Height del canvas
	var uri                   = window.location.origin + window.location.pathname + "Chart/";	// Dirección para obtener los datos del Chart
	var meses                 = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
	var yearDefault           = $("#year").val();	// Se obtiene el año seleccionado por defecto
	var colors                = ['#008b8b', '#ff0000', '#008000', '#ffff00', '#00ffff', '#8b008b', '#dc143c', '#ff7f50', '#b22222', '#ffd700', '#808080', '#ffa500'];
console.log(uri);
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
					ticks: {
						beginAtZero:true,
						// Incluir símbolo de €
						callback: function(value, index, values){
							if (index == values.length-1) {
								return value + " €";
							}

							return value;
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
				// Se incluye el símbolo de € en el label del tooltip
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
	
	// Muestra el formulario para editar el ingreso/gasto seleccionado
	
	$(".editForm").click(function(event) {
		let id = $(this).val();
		let url = '/ingresos/';

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
	$.getJSON('/obtenerConceptos/ingresos', function(data) {
		let conceptos = [];
		
		$.each(data, function(index, val) {
			conceptos.push(val.concepto);
		});

		$("#concepto, #formConcepto").autocomplete({
			source: conceptos
		});
	});
	
	// Se obtiene los conceptos de ingresos del usuario
	$(".concepto").click(function(event) {
		event.preventDefault();

		$("#concepto").val($(this).text());
		$("#dropdown-menu").toggle();
	});


	/////////////////////////////////////////////////

	// Se llama la función chart al cargar por primera vez la página
	chart();
});