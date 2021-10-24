$(document).ready(function () {

	$(".borrar_registro_try").on("click", function (e) {

		e.preventDefault();
		let id = $(this).attr("data-id");
		let a = $("a[data-id='"+id+"']").parents("tr").remove();
		console.log(id);
		console.log(a);
		
	});
});
