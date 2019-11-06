var mailsDataTable;
$(document).ready(function () {
    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $('time.timeago').timeago();
    mailsDataTable = $("#mailsTable").DataTable({
        fnDrawCallback: function () {
            $('time.timeago').timeago();
        }
    });
});
