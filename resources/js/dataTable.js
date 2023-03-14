$(document).ready( function () {
    $('#dataTable').DataTable(
        {
            language: {
                decimal: ',',
                thousands: '.',
                search: 'Pesquisar por: ',
                lengthMenu: 'Exibir _MENU_ por página',
                info: 'Exibindo _PAGE_ de _PAGES_',
                infoEmpty: 'Sem resultados disponíveis',
                infoFiltered: '(Filtrado de _MAX_ resultados)',
                zeroRecords: 'Nada para exibir!',
                paginate: {
                    first: 'Primeira',
                    last: 'Ultima',
                    next: 'Próxima',
                    previous: 'Anterior'
                },
            },
        }
    );
});