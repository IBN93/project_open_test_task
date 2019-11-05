$(document).ready(function() {
    $('form').submit(function() {
        $('#calculated-table').show();
        $('#calculated-table').html('');
        let file = $('input[type=\"file\"]')[0].files[0];
        console.log(file);
        let data = new FormData();
        data.append('file', file);
        $.ajax({
            type: "POST",
            url: "form_handler.php",
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            success: function(response) {
                $('#calculated-table').html(response);
            }
        });
        return false;
    });
});