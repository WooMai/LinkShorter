var api_token = '7dPe95ShE5aQkMU46VzWuUCm';

$('#submit').click(function () {
    $.ajax({
        method: 'POST',
        url: '/api/create',
        headers: {
            "API-Token": api_token
        },
        data: {
            target: $('#target').val()
        },
        success: function (rsp) {
            if (rsp.ok) {
                let data = rsp.data;
                $('#status').append('<div class="alert alert-success mt-3" role="alert">\n' +
                    '                        链接创建成功！<br>\n' +
                    '                        <b><a href="' + data.shorten_url + '" target="_blank">' + data.shorten_url + '</a></b>\n' +
                    '                    </div>');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: '创建失败',
                    text: rsp.msg,
                });
            }
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '请求发生错误，请检查网络状态',
            });
        }
    });
});


// 别骂了别骂了
$(function () {
    $(window).trigger('resize');
});

$(window).resize(function () {
    let main = $('#main');

    if ($(window).width() >= 320) {
        let empty_space = $(window).height() - main.height();
        let margin_top = Math.floor(empty_space * 0.4);
        main.css('margin-top', margin_top);
    } else {
        main.css('margin-top', 0);
    }

    let empty_space = $(window).width() - main.width();
    let margin_left = Math.floor(empty_space * 0.5);
    main.css('margin-left', margin_left);
});