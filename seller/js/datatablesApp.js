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
        "language": {
            "paginate": {
                "next": "Siguiente",
                "previous": "Anterior",
                "last": "Ultimo",
                "first": "Primero"
            },
            "info": 'Mostrando _START_ a _END_ de _TOTAL_ resultados',
            "emptyTable": 'No hay registros',
            "infoEmpty": '0 registros',
            "search": 'Buscar: '
        }
    });
});