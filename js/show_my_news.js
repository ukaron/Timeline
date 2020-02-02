$(document).ready(function () {

    let inProgress = false;
    let startFrom = 10;

    $(window).scroll(function () {
        if($(window).scrollTop() + $(window).height() >= $(document).height() - 300 && !inProgress)
        {

            $.ajax({
                url: 'moder/handler',
                method: 'POST',
                data: {"start_from" : startFrom},
                beforeSend: function () {
                    inProgress = true;
                }
            }).done(function (data) {

                data = jQuery.parseJSON(data);
                if (data.length > 0){
                    $.each(data, function (subj, info) {
                        $("#post").append("<h1>" + info[1] + "</h1><br><h2>" + info[2] + "<br>" + info['public_date'] +
                            "</h2> <a href='/moder/edit_news/?'" + info[0] + ">Edit</a> <a href='/moder/delete_new/'" +
                        info[0] + ">Delete</a>");
                    });
                    inProgress = false;
                    startFrom += 10;

                }
            });
        }
    });
});