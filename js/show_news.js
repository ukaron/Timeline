$(document).ready(function () {

    let inProgress = false;
    let startFrom = 10;
    let posts = document.getElementById('post');

    $(window).scroll(function () {
        if($(window).scrollTop() + $(window).height() >= $(document).height() - 300 && !inProgress)
        {

            $.ajax({
                url: 'main/handler',
                method: 'POST',
                data: {"start_from" : startFrom},
                beforeSend: function () {
                inProgress = true;
                }
            }).done(function (data) {
                data = $.parseJSON(data);
                if (data.length > 0){
                    let i = 0;
                    for (var value in data) {
                        for (var index in data[value]) {
                            let div = document.createElement('div');
                            div.id = index;
                            div.className= value;
                            posts.append(div);
                            if (index == 1 ) {
                                let h1 = document.createElement('h1');
                                h1.id = index;
                                div.append(h1);
                                h1.append(data[value][index]);
                            }
                            if (index == 2 ){
                                let h2 = document.createElement('h2');
                                h2.id = index;
                                div.append(h2);
                                h2.append(data[value][index]);
                            }
                            if (index == 3 ){
                                let h3 = document.createElement('h3');
                                h3.id = index;
                                div.append(h3);
                                h3.append(data[value][index]);
                            }
                            if (index == 'tag_name') {
                                let i = 0;
                                while (i++ < data[value][index].length - 1){
                                    let a = document.createElement('a');
                                    a.href = "/main/show_tag/?tag="+ data[value][index][i][1]+"&page=0";
                                    div.append(a);
                                    let h3 = document.createElement('h3');
                                    h3.id = index;
                                    a.append(h3);
                                    h3.append('#'+ data[value][index][i][0]);
                                }
                            }
                        }
                    }
                }
                inProgress = false;
                startFrom += 10;
            })
        }
    })
});