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
/******/ 	return __webpack_require__(__webpack_require__.s = 219);
/******/ })
/************************************************************************/
/******/ ({

/***/ 219:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(220);


/***/ }),

/***/ 220:
/***/ (function(module, exports) {

$(function () {
	var patternNoAp = /^[A-Za-z]{3,}(\s[A-Za-z]{3,})?/; //Expresión regular para validar nombre y apellidos
	var patternEmail = /[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$/; //Expresión regular para validar email
	var patternPw = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/; //Expresión regular para validar password
	var ok,
	    newOk,
	    newOkRePassword,
	    okNombre,
	    okApellidos,
	    okEmail,
	    okPassword,
	    okRePassword = false;
	var validado = false; //Indica que el formulario está validado
	var url = window.location; // Se obtiene la url actual de la pagina

	// Se valida que el nombre introducido cumpla las condiciones
	$("input[name='registroNombre']").keyup(function () {
		nombre = $(this).val();

		if (!patternNoAp.test(nombre) || nombre.length < 3) {
			$("#nombreError").text("Debe contener solo letras (mínimo tres)");
			okNombre = false;
		} else {
			$("#nombreError").text("");

			if (nombre.length > 0) {
				okNombre = true;
			}
		}
	});

	// Se valida que los apellidos introducidos cumplan las condiciones
	$("input[name='registroApellidos']").keyup(function () {
		apellidos = $(this).val();

		if (!patternNoAp.test(apellidos) || apellidos.length < 3) {
			$("#apellidosError").text("Debe contener solo letras (mínimo tres)");
			okApellidos = false;
		} else {
			$("#apellidosError").text("");

			if (apellidos.length > 0) {
				okApellidos = true;
			}
		}
	});

	// Se valida que el email introducido sea correcto
	$("input[name='registroEmail']").keyup(function () {
		email = $(this).val();

		if (!patternEmail.test(email)) {
			$("#emailError").text("El email debe ser como 'example@gmail.com|es'");
			okEmail = false;
		} else {
			$("#emailError").text("");
			okEmail = true;
		}
	});

	// Se valida el campo password
	$("input[name='registroPassword']").keyup(function () {
		password = $(this).val();

		if (!patternPw.test(password)) {
			$("#pwError").text("Debe contener almenos un número, una mayúscula y una minúscula (8 caracteres como mínimo)");
			ok = false;
			okPassword = false;
		} else {
			$("#pwError").text("");
			ok = true; //Se indica que el campo password es válido
			okPassword = true;
		}
	});

	// Se valida el campo Repite password
	$("input[name='registroRePassword']").keyup(function () {
		if (ok) {
			pw = $("input[name='registroPassword']").val();
			rePw = $(this);
			bColor = $(this).css("border-color");

			if (pw !== rePw.val() && pw.length != 0) {
				rePw.css("border-color", "red");
				okRePassword = false;
			} else {
				rePw.css("border-color", bColor);
				okRePassword = true;
			}
		}
	});

	// Se comprueba que todos los campos estén validados
	$("input[name='crear']").click(function (event) {
		if (!okNombre || !okApellidos || !okEmail || !okPassword || !okRePassword) {
			event.preventDefault();

			$("#formError").show().delay(3000).fadeOut(1000);
		}
	});

	/////////////////////////////////////////////////

	/*
 	Valida las nuevas contraseñas introducidas
 	*/

	// Se valida el campo password
	$("input[name='newPassword']").keyup(function () {
		password = $(this).val();

		if (!patternPw.test(password)) {
			$("#resetPwError").text("Debe contener almenos un número, una mayúscula y una minúscula (8 caracteres como mínimo)");
			newOk = false;
			newOkPassword = false;
		} else {
			$("#resetPwError").text("");
			newOk = true; //Se indica que el campo password es válido
			newOkPassword = true;
		}
	});

	// Se valida el campo Repite password
	$("input[name='newRePassword']").keyup(function () {
		if (newOk) {
			pw = $("input[name='newPassword']").val();
			rePw = $(this);
			bColor = $(this).css("border-color");

			if (pw !== rePw.val() && pw.length != 0) {
				rePw.css("border-color", "red");
				newOkRePassword = false;
			} else {
				rePw.css("border-color", bColor);
				newOkRePassword = true;
			}
		}
	});

	// Se comprueba que todos los campos estén validados
	$("input[name='reset'], #guardar").click(function (event) {
		if (!newOkPassword || !newOkRePassword) {
			event.preventDefault();

			$("#formError").show().delay(3000).fadeOut(1000);
		}
	});

	/////////////////////////////////////////////////

	/*
 	Muestra el formulario para editar el ingreso/gasto seleccionado
 	*/
	// 	$(".editForm").click(function(event) {
	// 		var id = $(this).val();
	// 		var url = window.location.pathname.substring(1, window.location.pathname.length) + "/";

	// 		if (url === 'gastos/') {
	// 			$("#formTipo").val($("#tipo-"+id).text());
	// 		}

	// 		$("#formConcepto").val($("#concepto-"+id).text());
	// 		$("#formFecha").val($("#fecha-"+id).text());
	// 		$("#formCantidad").val($("#cantidad-"+id+" span").text());
	// 		$("#formComentario").val($("#comentario-"+id).text());

	// 	// Asignar el valor a la propiedad 'action' del formulario con el id del ingreso seleccionado
	// 	// $(".formEdit form").attr('action', );("/id/" + id + "/edit");
	// 	$(".formEdit form").attr('action', url + id + "/edit");

	// 	// Se despliega el formulario
	// 	$(".formEdit").fadeIn('slow');
	// });

	/*
 	Oculta el formulario de edición de ingresos/gastos
 	*/
	// $("#cerrarForm").click(function(event) {
	// 	$(".formEdit").fadeOut('slow');
	// });

	/////////////////////////////////////////////////

	/*
 	Se asigna widget 'DATEPICKER' al campo fecha del formulario
 	*/
	$(".datepicker").datepicker({
		dateFormat: "yy-mm-dd"
	});

	/////////////////////////////////////////////////

	/*
 	Se obtiene los conceptos de ingresos/gastos del usuario
 	*/
	$("#dropdownConcepto").hide();

	// $(".dropdown-menu, .dropdown-menu .concepto").on('click', '.concepto', function(event) {
	// 	event.preventDefault();

	// 	$("#concepto").val($(this).text());
	// 	$("#dropdown-menu").toggle();
	// });

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

			$.each(data, function (index, val) {
				conceptos.push(val.concepto);

				$("<li>").append($("<a>").text(val['concepto']).addClass('concepto')).appendTo('#dropdownConcepto');
			});

			$("#concepto, #formConcepto").autocomplete({
				source: conceptos
			});

			$("#dropdownConcepto").removeAttr('style');
		});
	});

	/*
 	Se le añade al campo 'concepto' del formulario de ingreso la funcionalidad para obtener una
 	lista de valores que el usario ha introducido anteriormente como concepto
 	*/
	// var conceptos = [];
	var uri = url.pathname.substring(1, url.pathname.length);

	// if (uri == 'ingresos') {
	// 	$.getJSON('obtenerConceptos/'+uri, function(data) {
	// 		$.each(data, function(index, val) {
	// 			conceptos.push(val.concepto);
	// 		});

	// 		$("#concepto, #formConcepto").autocomplete({
	// 			source: conceptos
	// 		});
	// 	});
	// }

	/////////////////////////////////////////////////

	/*
 	Se genera el charts mostrando la evolución de los ingresos
 	*/
	// Función que devuelve el Chart que muestra la evolución de los ingresos en el año indicado
	var defaultYear = $("#year").val();
	var defaultTipo = $("#chartTipo").val();

	function getChart() {
		var year = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : defaultYear;

		$.getJSON(uri + 'Chart/' + year, function (data) {
			var datos = [];
			var values = [];
			var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

			switch (uri) {
				/*case 'ingresos':
    	var widthChart = $("#chartColumn-container").width();	// Ancho del contenedor CHART
    		$.each(data, function(index, val){
    		// Se añade un nuevo objeto al array datos
    		datos.push({
    			label: meses[val.month-1],
    			value: val.cantidad
    		});
    	});
    		$("#chartColumn-container").insertFusionCharts({
    		type: "column2d",
    		width: widthChart,
    		height: "350",
    		dataFormat: "json",
    		dataSource: {
    			chart: {
    				caption: "Evolución del Año " + year,
    				subCaption: " ",
    				numberPrefix: "€",
    				showBorder: 0,
    				showCanvasBorder: 0,
    				divLineDashed: 1,
    				bgColor:"#ffffff",
    				theme: "fint",
    				plotBorderAlpha: 10,
    			},
    			data: datos
    		}
    	});
    		break;*/
				case 'gastos':
					var widthChart = $("#chartStacked-container").width(); // Ancho del contenedor CHART
					var tipo = $("#chartTipo").val();
					var categorias = [];
					var aux = {};
					var seriesname = [];
					var ok = true;

					$.each(data, function (index, val) {
						if (aux.month != val.month) {
							// Se añade una nueva categoria
							categorias.push({
								label: meses[val.month - 1]
							});
						}

						indice = seriesname.findIndex(function (name) {
							return name.seriesname == this;
						}, val.tipo);

						if (indice == -1) {
							seriesname.push({
								seriesname: val.tipo
							});
						}

						aux = val;
					});

					$.each(seriesname, function (index1, name) {
						values = [];

						$.each(categorias, function (index2, categorias) {
							ok = false;
							$.each(data, function (index3, val) {
								if (val.tipo == name.seriesname && meses[val.month - 1] == categorias.label) {
									values.push({
										value: val.cantidad
									});
									ok = true;
									return false;
								}
							});

							if (!ok) {
								values.push({
									value: ""
								});
							}
						});

						datos.push({
							seriesname: name.seriesname,
							data: values
						});
					});

					$("#chartStacked-container").insertFusionCharts({
						type: "stackedcolumn2d",
						width: widthChart,
						height: "350",
						dataFormat: "json",
						dataSource: {
							chart: {
								caption: "Evolución del Año " + year,
								subCaption: " ",
								numberPrefix: "€",
								showBorder: 0,
								showCanvasBorder: 0,
								bgColor: "#ffffff",
								divLineDashed: 1,
								showSum: 1,
								theme: "fint",
								legendBorderAlpha: 0,
								legendShadow: 0,
								plotBorderAlpha: 10,
								showHoverEffect: 1
							},
							categories: [{
								category: categorias
							}],
							dataset: datos
						}
					});

					break;
				case 'ahorros':
					var width = $("#chartAhorros-container").width(); // Ancho del contenedor CHART

					$.each(data, function (index, val) {
						// Se añade un nuevo objeto al array datos
						datos.push({
							label: meses[val.month - 1],
							value: val.cantidad
						});
					});

					$("#chartAhorros-container").insertFusionCharts({
						type: "column2d",
						width: width,
						height: "350",
						dataFormat: "json",
						dataSource: {
							chart: {
								caption: "Evolución del Año " + year,
								subCaption: " ",
								numberPrefix: "€",
								showBorder: 0,
								showCanvasBorder: 0,
								divLineDashed: 1,
								bgColor: "#ffffff",
								theme: "fint",
								plotBorderAlpha: 10
							},
							data: datos
						}
					});

					break;
				default:
					break;
			}
		});
	}

	function getChartDoughnut() {
		var year = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : defaultYear;
		var tipo = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : defaultTipo;

		if (uri == 'gastos') {
			// Se obtienen los datos para mostrar el Chart Doughnut con los detalles de los gastos
			$.getJSON(uri + 'ChartDoughnut/' + year + '/tipo/' + tipo, function (data) {
				var datos = [];
				var total = 0;
				var width = $("#chartDoughnut-container").width();

				$.each(data, function (index, val) {
					datos.push({
						label: val.concepto,
						value: val.cantidad
					});

					// Se acumula el total de los gastos
					total += val.cantidad;
				});

				$("#chartDoughnut-container").insertFusionCharts({
					type: "doughnut2d",
					width: width, // Se divide el valor obtenido del contenedor
					height: "350",
					dataFormat: "json",
					dataSource: {
						chart: {
							caption: "Gastos " + tipo + " de " + year,
							numberPrefix: "€",
							showBorder: 0,
							showCanvasBorder: 0,
							use3DLighting: 0,
							bgColor: "#ffffff",
							enableSmartLabels: 0,
							startingAngle: 90,
							showShadow: 0,
							showLabels: 0,
							showPercentValues: 1,
							showLegend: 1,
							defaultCenterLabel: "Total " + total + "€",
							centerLabel: "$label" + ": " + "$value",
							centerLabelBold: 1,
							showTooltip: 0,
							plotBorderAlpha: 10,
							decimals: 0,
							useDataPlotColorForLabels: 1,
							legendBorderAlpha: 0,
							legendShadow: 0,
							theme: "fint"
						},
						data: datos
					}
				});
			});
		}
	}

	// Se muestra el Chart de evolución de ingresos cuando se carga el apartado Ingresos
	getChart();
	getChartDoughnut();

	// Cuando se elija otro año se recargará con los datos correspondientes al año elegido
	$("#year").change(function (event) {
		var year = $(this).val();
		var tipo = $("chartTipo").val();

		getChart(year);
		getChartDoughnut(year, tipo);
	});

	// Cuando se elija otro 'tipo' se recargará el chart doughnut con los datos correspondientes al tipo elegido
	$("#chartTipo").change(function (event) {
		var year = $("#year").val();
		var tipo = $("#chartTipo").val();

		getChartDoughnut(year, tipo);
	});

	/////////////////////////////////////////////////

	/*
 	Se comprueba los campos contraseña para que el usuario introduzca un valor válido
  */

	$("#password").keyup(function () {
		var password = $(this).val();

		if (!patternPw.test(password) && password.length > 0) {
			$("#messagePassword").show();
		} else {
			$("#messagePassword").hide();
		}
	});

	$("#rePassword").keyup(function () {
		var password = $(this).val();
		var borderColor = $(this).css('border-color');

		if (password !== $("#password").val() && password.length > 0) {
			$(this).css('border-color', 'red');
		} else {
			$(this).css('border-color', borderColor);
		}
	});
});

/***/ })

/******/ });