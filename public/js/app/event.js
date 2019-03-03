$("#search_button").click(function () {

    var category = $event['event_id'];

    $.ajax({
        method: "get",
        url: '/attendance/public/secure/qr-code',
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
                var branch_name = data[k].branch_name;


                selOpts += "<tr class='gradeX'>" +
                    "<td>" + cal + "</td>" +
                    "<td>" + branch_name + "</td>" +
                    "<td style='text-align: center'>" +
                    "<a href='/attendance/public/secure/add-branch/"+ id +"'>Edit</a></td>";
                cal ++;
            });
            $('#example').append(selOpts);

        } else {
        }
    });
});