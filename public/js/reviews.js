//script al primo caricamento per gestire la visualizzazione del voto in formato stella
$(document).ready(function () {
    $('.js-comments-blog').find('.js-comment-div-start').each(function () {
        $num = $(this).find('.js-startcomment').attr('value');
        console.log($num);
        var i = 0;
        $(this).find('.js-startcomment').children('i').each(function () {
            if (i < $num) {
                $(this).addClass('zmdi zmdi-star');
                i++;
            }
        });
    });
});

//Script Jquery/Ajax che gestiste la paginate dei commenti;
$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    $url = $(this).attr('href').split('page=')[1];
    $idblog = $('.js-comments-blog').attr('value');
    console.log($idblog);
    $.ajax({
        url: '/ajaxblog?page=' +$url,
        data: {'idblog': $idblog}

    }).done(function (data) {
        $('.js-comments-blog').hide().html(data).fadeToggle(600);
        $('.js-comments-blog').find('.js-comment-div-start').each(function () {
            $num = $(this).find('.js-startcomment').attr('value');
            var i = 0;
            $(this).find('.js-startcomment').children('i').each(function () {
                if (i < $num) {
                    $(this).addClass('zmdi zmdi-star');
                    i++;
                }
            });
        });
    });
});

$(document).ready(function () {
    $('.js-add-review').on('click', function (e) {
        e.preventDefault();
        $idarticolo = $('.js-add-review').attr('value');
        $idcommento = $('#review').val();
        $voto = 0;
        $('.js-addstarreview').children('i').each(function () {
            if ($(this).attr('class') == 'item-rating pointer zmdi zmdi-star') {
                $voto += 1;
            }
        });
        console.log($idarticolo, $idcommento, $voto);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type : "POST",
            url : '/addReviewBlog',
            data : {'idarticolo': $idarticolo, 'comment': $idcommento, 'voto': $voto},
            success: function (data) {
                if($.isEmptyObject(data.error)){
                    $(".print-error-msg-review").css('visibility', 'hidden');
                    swal({
                        title: "Commento Inserito",
                        text: "Grazie per la collaborazione",
                        icon: "success",
                        button: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                }
                else {
                    $(".print-error-msg-review").find("ul").html('');
                    $.each(data.error, function (key, value) {
                        $('.print-error-msg-review').find('ul').append('<li>' + value + '</li>');
                        $('.print-error-msg-review').css('visibility', 'visible');
                    });
                }
            },
            error: function () {
                console.log('errore');
            }
        });
    });
});