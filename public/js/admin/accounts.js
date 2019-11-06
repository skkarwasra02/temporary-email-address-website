var inboxDataTable;
$(document).ready(function () {
    var totalRows = $('.dataTable tbody tr').length;
    $("#accountsTable").DataTable();
    $('time.timeago').timeago();
    inboxDataTable = $("#inboxtable").DataTable({
        "bLengthChange": false,
        "bInfo": false,
        "bFilter": false,
        "ordering": false,
        "columnDefs": [
            {
                className: "mail-message-control",
                "targets": [ 1 ]
            }
        ],
        fnDrawCallback: function () {
            $('time.timeago').timeago();
            if(totalRows < 11) {
                $('.dataTables_paginate').hide();
            } else {
                $('.dataTables_paginate').show();
            }
        }
    });
});
