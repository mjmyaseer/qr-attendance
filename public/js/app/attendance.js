$("#search_button").click(function () {

    var customer = $("#search_txt").val();

    if (customer == '') {
        $("#sear_txt").text("Search Field is required");
        return false;
    }else{
        $("#sear_txt").text("");
    }



    $.ajax({
        method: "get",
        url: '/qr-attendance/public/secure/sear-attend',
        data: {keyword: customer}
    }).done(function (data) {
        if (data) {

            var selOpts = "";
            $('#example').html('');

            selOpts += "<thead> <tr>" +
                "<th>#ID</th>" +
                "<th>Customer Name</th>" +
                "<th>Event Name</th>" +
                "<th>NIC</th>" +
                "<th>Phone</th>" +
                "<th>Attended Date</th>" +
                "</tr></thead>";
            var cal = 1;
            $.each(data, function (k, v) {
                var id = data[k].id;
                var city_name = data[k].city_name;
                var customer_name = data[k].customer_name;
                var event_name = data[k].event_name;
                var customer_nic = data[k].customer_nic;
                var customer_telephone = data[k].customer_telephone;
                var attended_date = data[k].attended_date;


                selOpts += "<tr class='gradeX'>" +
                    "<td>" + cal + "</td>" +
                    "<td>" + customer_name + "</td>" +
                    "<td>" + event_name + "</td>" +
                    "<td>" + customer_nic + "</td>" +
                    "<td>" + customer_telephone + "</td>" +
                    "<td>" + attended_date + "</td>";
                cal ++;
            });
            $('#example').append(selOpts);

        } else {
        }
    });
});