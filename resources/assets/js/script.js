$(function () {
	var patternNoAp 	= /^[A-Za-z]{3,}(\s[A-Za-z]{3,})?/;	//Expresión regular para validar nombre y apellidos
	var patternEmail 	= /[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$/;	//Expresión regular para validar email
	var patternPw		= /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;	//Expresión regular para validar password
	var ok,
		newOk,
		newOkRePassword,
	 	okNombre,
		okApellidos,
		okEmail,
		okPassword,
		okRePassword	= false;
	var validado		= false;	//Indica que el formulario está validado

	// Se valida que el nombre introducido cumpla las condiciones
	$("input[name='registroNombre']").keyup(function(){
		nombre = $(this).val();

		if (!patternNoAp.test(nombre) || nombre.length < 3) {
			$("#nombreError").text("Debe contener solo letras (mínimo tres)");
			okNombre = false;
		}else{
			$("#nombreError").text("");

			if (nombre.length > 0) {
				okNombre = true;
			}
		}
	});

	// Se valida que los apellidos introducidos cumplan las condiciones
	$("input[name='registroApellidos']").keyup(function(){
		apellidos = $(this).val();

		if (!patternNoAp.test(apellidos) || apellidos.length < 3) {
			$("#apellidosError").text("Debe contener solo letras (mínimo tres)");
			okApellidos = false;
		}else{
			$("#apellidosError").text("");

			if (apellidos.length > 0) {
				okApellidos = true;
			}
		}
	});

	// Se valida que el email introducido sea correcto
	$("input[name='registroEmail']").keyup(function(){
		email = $(this).val();

		if (!patternEmail.test(email)) {
			$("#emailError").text("El email debe ser como 'example@gmail.com|es'");
			okEmail = false;
		}else{
			$("#emailError").text("");
			okEmail = true;
		}
	});

	// Se valida el campo password
	$("input[name='registroPassword']").keyup(function(){
		password = $(this).val();

		if (!patternPw.test(password)) {
			$("#pwError").text("Debe contener almenos un número, una mayúscula y una minúscula (8 caracteres como mínimo)");
			ok = false;
			okPassword = false;
		}else{
			$("#pwError").text("");
			ok = true;	//Se indica que el campo password es válido
			okPassword = true;
		}
	});

	// Se valida el campo Repite password
	$("input[name='registroRePassword']").keyup(function() {
		if (ok) {
			pw 		= $("input[name='registroPassword']").val();
			rePw 	= $(this);
			bColor 	= $(this).css("border-color");

			if (pw !== rePw.val() && pw.length != 0) {
				rePw.css("border-color", "red");
				okRePassword = false;
			}else{
				rePw.css("border-color", bColor);
				okRePassword = true;
			}
		}
	})

	// Se comprueba que todos los campos estén validados
	$("input[name='crear']").click(function(event){
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
	$("input[name='newPassword']").keyup(function(){
		password = $(this).val();

		if (!patternPw.test(password)) {
			$("#resetPwError").text("Debe contener almenos un número, una mayúscula y una minúscula (8 caracteres como mínimo)");
			newOk = false;
			newOkPassword = false;
		}else{
			$("#resetPwError").text("");
			newOk = true;	//Se indica que el campo password es válido
			newOkPassword = true;
		}
	});

	// Se valida el campo Repite password
	$("input[name='newRePassword']").keyup(function() {
		if (newOk) {
			pw 		= $("input[name='newPassword']").val();
			rePw 	= $(this);
			bColor 	= $(this).css("border-color");

			if (pw !== rePw.val() && pw.length != 0) {
				rePw.css("border-color", "red");
				newOkRePassword = false;
			}else{
				rePw.css("border-color", bColor);
				newOkRePassword = true;
			}
		}
	})

	// Se comprueba que todos los campos estén validados
	$("input[name='reset']").click(function(event){
		if (!newOkPassword || !newOkRePassword) {
			event.preventDefault();

			$("#formError").show().delay(3000).fadeOut(1000);
		}
	});
});