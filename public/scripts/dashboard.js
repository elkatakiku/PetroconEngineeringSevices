
function loadBarChart() 
{
    $.get(
        Settings.base_url + "/dashboard/projectsCountByYear", 
        { year : function () {return $(e.target).serialize();} },
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
}

$('select[name="projectYear"]').on('change', () => {
    alert($(this).val());
});