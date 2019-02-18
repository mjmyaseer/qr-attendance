$("#search_button").click(function () {

    var category = $("#search_txt").val();

    if (category == '') {
        $("#sear_txt").text("Search Field is required");
        return false;
    }else{
        $("#sear_txt").text("");
    }



    $.ajax({
        method: "get",
        url: '/qr-attendance/public/secure/sear-city',
        data: {keyword: category}
    }).done(function (data) {
        if (data) {

            var selOpts = "";
            $('#example').html('');

            selOpts += "<thead> <tr>" +
                "<th>#ID</th>" +
                "<th>Name</th>" +
                "<th>Edit</th>" +
                "</tr></thead>";
            var cal = 1;
            $.each(data, function (k, v) {
                var id = data[k].id;
                var city_name = data[k].city_name;


                selOpts += "<tr class='gradeX'>" +
                    "<td>" + cal + "</td>" +
                    "<td>" + city_name + "</td>" +
                    "<td style='text-align: center'>" +
                    "<a href='/qr-attendance/public/secure/add-city/"+ id +"'>Edit</a></td>";
                cal ++;
            });
            $('#example').append(selOpts);

        } else {
        }
    });
});