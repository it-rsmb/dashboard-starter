import {authHeader} from '../../api/index'

$(document).ready(function () {


     $('#rolesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/api/roles',
            beforeSend: authHeader
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'guard_name', name: 'guard_name' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });


     // Open modal
    $("#btnAddRole").on("click", function () {
        $("#modalAddRole").removeClass("hidden");
    });

    // Close modal
    $("#btnCloseModal, #btnCancel").on("click", function () {
        $("#modalAddRole").addClass("hidden");
    });

});
