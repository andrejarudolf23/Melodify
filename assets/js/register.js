$(document).ready(function() {

	$("#hideLogin").click(function() {

		$("#loginForm").hide("slow");
		$("#registerForm").fadeIn("slow");

	});

	$("#hideRegister").click(function() {

		$("#registerForm").hide();
		$("#loginForm").fadeIn("slow");

	});

});