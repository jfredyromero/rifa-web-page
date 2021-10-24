$(function() {

    $('#registros').DataTable({
        "paging": true,
        "pageLength": 10,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "Language": {
            paginate: {
                next: "Siguiente",
                previous: "Anterior",
                last: "Ultimo",
                first: "Primero"
            },
            info: 'Mostrando _START_a_END_de_TOTAL_ resultados',
            emptyTable: 'No hay registros',
            infoEmpty: '0 registros',
            search: 'Buscar: '
        }
    });
});