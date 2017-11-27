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

	// Se ocultan los alerts tras unos segundos
	$(".alert.alert-success").delay('3000').fadeOut('slow');

	// Se muestra el texto completo del comentario
	$(".show-more").click(function (event) {
		event.preventDefault();
		var id = $(this).attr('data-show');

		if ($(this).attr('data-state') == 'false') {
			$(this).attr('data-state', 'true');
			$(this).text('... menos');
		} else {
			$(this).attr('data-state', 'false');
			$(this).text('... más');
		}

		$(".text-completo-" + id + ", .text-abreviado-" + id).toggle();
	});

	/////////////////////////////////////////////////

	/*
 	Se asigna widget 'DATEPICKER' al campo fecha del formulario
 */
	$(".datepicker").datepicker({
		dateFormat: "yy-mm-dd"
	});

	/////////////////////////////////////////////////

	/*
 	Se oculta el select al cargar la página
 */
	$("#dropdownConcepto").hide();

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