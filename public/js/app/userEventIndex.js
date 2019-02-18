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
        url: '/qr-attendance/public/secure/sear-userEvent',
        data: {keyword: category}
    }).done(function (data) {

        if (data) {
            var selOpts = "";
            $('#example').html('');

            selOpts += "<thead> <tr>" +
                "<th>#ID</th>" +
                "<th>Event Name</th>" +
                "<th>Customer Name</th>" +
                "<th>Created By</th>" +
                "</tr></thead>";
            var cal = 1;
            $.each(data, function (k, v) {
                var id = data[k].id;
                var event_name = data[k].event_name;
                var customer_name = data[k].customer_name;
                var created_by = data[k].created_by;

                selOpts += "<tr class='gradeX'>" +
                    "<td>" + cal + "</td>" +
                    "<td>" + event_name + "</td>" +
                    "<td>" + customer_name + "</td>" +
                    "<td>" + created_by + "</td>" +
                    "<td style='text-align: center'>" +
                    "<a href='/qr-attendance/public/secure/add-userEvent/"+ id +"'>Edit</a></td>";
                cal ++;
            });
            $('#example').append(selOpts);

        } else {
        }
    });
});