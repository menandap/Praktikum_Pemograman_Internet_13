//script al primo caricamento per gestire la visualizzazione del voto in formato stella
$(document).ready(function () {
    $('.js-comments').find('.js-comment-div-start').each(function () {
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

//Script Jquery/Ajax che gestiste la paginate dei commenti;
$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    $id = $('.js-comments').attr('value');
    console.log($id);
    $url = $(this).attr('href').split('page=')[1];
    $.ajax({
        url: '/ajax?page=' +$url,
        data: {'idprod': $id},
    }).done(function (data) {
        $('.js-comments').hide().html(data).fadeToggle(600);
        $('.js-comments').find('.js-comment-div').each(function () {
            $num = $(this).find('.js-star-comm').attr('value');
            var i = 0;
            $(this).find('.js-star-comm').children('i').each(function () {
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
       $idprod = $('.js-add-review').attr('value');
       $idcommento = $('#review').val();
       $voto = 0;
       $('.js-addstarreview').children('i').each(function () {
           if ($(this).attr('class') == 'item-rating pointer zmdi zmdi-star')
               $voto += 1;
       });
       $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       });
       $.ajax({
          type : "POST",
          url : '/addreview',
          data : {'idprod': $idprod, 'comment': $idcommento, 'voto': $voto},
          success: function (data) {
              if($.isEmptyObject(data.error)){
                  $(".print-error-msg-review").find("ul").html('');
                  $(".print-error-msg-review").find("ul").html('');
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
          }
       });
   })
});