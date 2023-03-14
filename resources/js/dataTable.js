$(document).ready( function () {
    $('#dataTable').DataTable(
        {
            order: [[3, 'desc']],
            language: {
                decimal: ',',
                thousands: '.',
                search: 'Pesquisar por: ',
                lengthMenu: 'Exibir _MENU_ por página',
                info: 'Exibindo de _START_ a _END_ (Total _TOTAL_)',
                infoEmpty: 'Sem resultados disponíveis',
                infoFiltered: '(Filtrado de _MAX_ resultados)',
                zeroRecords: 'Nada para exibir!',
                paginate: {
                    first: 'Primeira',
                    last: 'Ultima',
                    next: 'Próxima',
                    previous: 'Anterior'
                }
            }
        }
    );
});