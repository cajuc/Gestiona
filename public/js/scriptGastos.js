/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 225);
/******/ })
/************************************************************************/
/******/ ({

/***/ 225:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(226);


/***/ }),

/***/ 226:
/***/ (function(module, exports) {

$(function () {
	var ctxBar = $("#chartBarGastos"); // Se obtiene el contexto o contenedor para el Chart tipo Bar
	var ctxDonut = $("#chartDonutGastos"); // Se obtiene el contexto o contenedor para el Chart tipo Donut
	var ctxBarHeight = ctxBar.height; // Height del canvas
	var ctxDonutHeight = ctxDonut.height; // Height del canvas
	var uri = window.location.origin + window.location.pathname; // Dirección para obtener los datos del Chart
	var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
	var yearDefault = $("#year").val(); // Se obtiene el año seleccionado por defecto
	var tipoDefault = $("#chartTipo").val(); // Se obtiene el tipo seleccionado por defecto
	var colors = ['#008b8b', '#ff0000', '#008000', '#ffff00', '#00ffff', '#8b008b', '#dc143c', '#ff7f50', '#b22222', '#ffd700', '#808080', '#ffa500'];

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
						beginAtZero: true,
						// Incluir símbolo de €
						callback: function callback(value, index, values) {
							if (index == values.length - 1) {
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
				position: 'bottom'
			},
			tooltips: {
				// Se incluye el símbolo de € en el label del tooltip y se cambia el color del box
				callbacks: {
					label: function label(tooltipItem, data) {
						return tooltipItem.yLabel + " €";
					},
					labelColor: function labelColor(tooltipItem, chart) {
						return {
							borderColor: 'white',
							backgroundColor: colors[tooltipItem.datasetIndex]
						};
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
				position: 'bottom'
			},
			tooltips: {
				// Se incluye el símbolo de € en el label del tooltip y se cambia el color del box
				callbacks: {
					label: function label(tooltipItem, data) {
						var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
						var label = data.labels[tooltipItem.index];

						return label + ": " + value + "€";
					},
					labelColor: function labelColor(tooltipItem, chart) {
						return {
							borderColor: 'white',
							backgroundColor: colors[tooltipItem.index]
						};
					}
				}
			},
			maintainAspectRatio: false
		}
	});

	// Cuando se elija otro año se recargará con los datos correspondientes al año elegido
	$("#year").change(function (event) {
		var year = $(this).val();
		var tipo = $("chartTipo").val();

		chartBar(year);
		chartDonut(year, tipo);
	});

	// Cuando se elija otro 'tipo' se recargará el chart donut con los datos correspondientes al tipo elegido
	$("#chartTipo").change(function (event) {
		var year = $("#year").val();
		var tipo = $("#chartTipo").val();

		chartDonut(year, tipo);
	});

	function chartBar() {
		var year = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : yearDefault;

		$.getJSON(uri + "Chart/" + year, function (data) {
			var bgColor = "";
			var bgColorHover = "";
			var datos = []; // Datos del chart
			var labels = []; // Labels del chart
			var categorias = [];
			var aux = {};
			var ok = true;

			$.each(data, function (index, val) {
				if (aux.month != val.month) {
					// Se añade una nueva categoria
					categorias.push(meses[val.month - 1]);
				}

				indice = labels.findIndex(function (label) {
					return label == this;
				}, val.tipo);

				if (indice == -1) {
					labels.push(val.tipo);
				}

				aux = val;
			});

			$.each(labels, function (index1, label) {
				values = [];
				bgColor = colors[index1] + "ff";
				bgColorHover = colors[index1] + "bb";

				$.each(categorias, function (index2, categoria) {
					ok = false;
					$.each(data, function (index3, val) {
						if (val.tipo == label && meses[val.month - 1] == categoria) {
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

	function chartDonut() {
		var year = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : yearDefault;
		var tipo = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : tipoDefault;

		// Se obtienen los datos para mostrar el Chart Doughnut con los detalles de los gastos
		$.getJSON(uri + 'ChartDoughnut/' + year + '/tipo/' + tipo, function (data) {
			var bgColor = "";
			var bgColorHover = "";
			var datos = [];
			var labels = [];
			var backgroundsColor = [];
			var hoverBackgroundsColor = [];
			var total = 0;

			// Con los datos obtenidos se convierten para pasarlos como parametros del Chart
			$.each(data, function (index, val) {
				// Labels que se mostrarán en el chart
				labels.push(val.concepto);

				// Datos reflejados en el chart
				datos.push(val.cantidad);

				// Color del background
				bgColor = colors[index] + "ff";
				bgColorHover = colors[index] + "bb";

				// Se añade el background para cada item del chart
				backgroundsColor.push(bgColor);
				hoverBackgroundsColor.push(bgColorHover);
			});

			updateChartDonut(datos, labels, backgroundsColor, hoverBackgroundsColor, tipo);
		});
	}

	// Función encargada de actualizar los datos del chart Bar
	function updateChartBar(datos, labels, year) {
		// Se informa el chart con los datos obtenidos
		myChart.data.labels = labels;
		myChart.options.title.text = 'Evolución de ' + year;
		myChart.data.datasets = datos;

		// Se actualiza el chart
		myChart.update();
	}

	// Función encargada de actualizar los datos del chart Donut
	function updateChartDonut(datos, labels, backgroundsColor, hoverBackgroundsColor, tipo) {
		// Se informa el chart con los datos obtenidos
		myChartDonut.options.title.text = "Detalles de Gastos '" + tipo + "'";
		myChartDonut.data.labels = labels;
		myChartDonut.data.datasets.forEach(function (dataset) {
			dataset.data = datos;
			dataset.backgroundColor = backgroundsColor;
			dataset.hoverBackgroundColor = hoverBackgroundsColor;
		});

		// Se actualiza el chart
		myChartDonut.update();
	}

	/////////////////////////////////////////////////

	// Muestra el formulario para editar el ingreso/gasto seleccionado

	$(".editForm").click(function (event) {
		var id = $(this).val();
		var url = '/gastos/';

		$("#formTipo").val($("#tipo-" + id).text());
		$("#formConcepto").val($("#concepto-" + id).text());
		$("#formFecha").val($("#fecha-" + id).text());
		$("#formCantidad").val($("#cantidad-" + id + " span").text());
		$("#formComentario").val($("#comentario-" + id).attr('data-value'));

		// Asignar el valor a la propiedad 'action' del formulario con el id del ingreso seleccionado
		// $(".formEdit form").attr('action', );("/id/" + id + "/edit");
		$(".formEdit form").attr('action', url + id + "/edit");

		// Se despliega el formulario
		$(".formEdit").fadeIn('slow');
	});

	// Oculta el formulario de edición de ingresos/gastos

	$("#cerrarForm").click(function (event) {
		$(".formEdit").fadeOut('slow');
	});

	/////////////////////////////////////////////////

	/*
 	Se le añade al campo 'concepto' del formulario de ingreso la funcionalidad para obtener una
 	lista de valores que el usario ha introducido anteriormente como concepto
 */
	$.getJSON('/obtenerConceptos/gastos', function (data) {
		var conceptos = [];

		$.each(data, function (index, val) {
			conceptos.push(val.concepto);
		});

		$("#concepto, #formConcepto").autocomplete({
			source: conceptos
		});
	});

	/*
 	Se obtiene los tipos de gasto del usuario
 */

	$(".dropdown-menu .tipo").click(function (event) {
		event.preventDefault();
		var tipo = $(this).text();

		$("#tipo, #tipoConcepto").val($(this).text());

		// Se carga los conceptos en base al tipo de concepto seleccionado
		$.getJSON('/obtenerConceptos/gastos/tipo/' + tipo, function (data) {
			// Primero se eliminan, si hubieran, los conceptos existentes
			$("#dropdownConcepto li").remove();
			var conceptos = [];

			$.each(data, function (index, val) {
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
	$(".dropdown-menu, .dropdown-menu .concepto").on('click', '.concepto', function (event) {
		event.preventDefault();

		$("#concepto").val($(this).text());
		$("#dropdown-menu").toggle();
	});

	/////////////////////////////////////////////////

	// Se cargan los chart por primera vez al cargar la página
	chartBar();
	chartDonut();
});

/***/ })

/******/ });