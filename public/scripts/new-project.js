$('#newProject').submit(function (e) { 
    e.preventDefault();

    $.post(
        Settings.base_url + "/project/newProject", 
        { form : function () {return $(e.target).serialize();} },
        function (data, textStatus) {
            console.log(data);
            let jsonData = JSON.parse(data);

            // Shows alert/error message
            if (jsonData.statusCode != 200) {
                $(e.target).find('.alert-danger')
                .addClass('show')
                .text(jsonData.message);
            } else {
                window.location.href = Settings.base_url + "/project/details/" + jsonData.data.id;
            }
        }
    );
});