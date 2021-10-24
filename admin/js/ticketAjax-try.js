$(document).ready(function () {
	$("#registros-try").DataTable({
		"paging": true,
		"pageLength": 3,
		"lengthChange": false,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": false,
		"responsive": true,
		"language": {
			"paginate": {
				"next": "Siguiente",
				"previous": "Anterior",
				"last": "Ultimo",
				"first": "Primero",
			},
			"info": "Mostrando _START_ a _END_ de _TOTAL_ resultados",
			"emptyTable": "No hay registros",
			"infoEmpty": "0 registros",
			"search": "Buscar: ",
		},
	});

	$(".borrar_registro_try").on("click", function (e) {

		e.preventDefault();
		let id = $(this).attr("data-id");
		let a = $("a[data-id='"+id+"']").parents("tr").remove();
		console.log(id);
		console.log(a);


		
	});
});
