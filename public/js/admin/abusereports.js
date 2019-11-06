var reportsTable;
$(document).ready(function () {
    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $('time.timeago').timeago();
    reportsTable = $("#reportsTable").DataTable({
        fnDrawCallback: function () {
            $('time.timeago').timeago();
        }
    });
});
