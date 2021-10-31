<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(function () {
        $('#dataTable').DataTable({
            language: {
                'url': "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            columnDefs: [{
                'targets': "no-sort",
                'orderable': false,
            }],
        });
    });
</script>