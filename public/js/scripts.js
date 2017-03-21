$(document).ready(function() {

    $('#project_name').change(function () {
        var name = $(this).val();
        $('#results_list tr').show();
        if (name == -1) {
            $('#results_list tr').show();
            return false;
        }
        $('#results_list tr').each(function(index) {
            console.log(index);
            if ((index > 1) && (name != $(this).find("td:eq(1)").text()))
                $(this).hide();
        });
    });

    $('#title').keyup(function () {
        var searchText = $(this).val().toLowerCase();
        console.log(searchText);
        $('#results_list tr').show();

        $('#results_list tr').each(function(index) {
            var component = $(this).find("td:eq(3)").text().toLowerCase();
            if ((index > 1) && component.indexOf(searchText) == -1)
                $(this).hide();
        });
    });
});