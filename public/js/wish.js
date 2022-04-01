 $('#product_div').find('.women').each(function () {
       $id = $(this).find('.js-show-modal1').attr('value');
       console.log($id);
       $back = $(this);
       $.ajax({
          url: '/wishprec',
           data: {'id': $id},
           dataType: 'json',
           context: this,
           success: function (data) {
               if (data["esiste"] == 1){
                   console.log(1);
                   $(this).find('.icon-heart2').css('opacity', 0);
                   $(this).find('.icon-heart2').css('opacity', 1);
               }
               else {
                   console.log(0);
                   $(this).find('.icon-heart1').css('opacity', 1);
                   $(this).find('.icon-heart2').css('opacity', 0);
               }
           }
       });
    });


$('.js-wish-cart').click(function(e){
    e.preventDefault();
    $('.js-panel-wish').addClass('show-header-wish');
    $.ajax({
        url : "/wishlist",
        type: "GET",
        dataType: "html",
        success: function(data) {
            $('.header-wish-content').html(data);
        },
        error: function() {
            console.log('Errore inserimento');
        }
    });
});

$('.js-hide-wish').on('click',function(){
    $('.js-panel-wish').removeClass('show-header-wish');
});

$(document).ready(function(){
    $(document).on('click', '.js-addwish-b2', function(e){
        e.preventDefault();
        $nome = $(this).parent().parent().find('.js-name-b2').text();
        $id = $(this).parent().parent().parent().find('.js-show-modal1').attr('value');
        console.log($id);
        console.log("Cliccato", $nome);
            $(this).children('.icon-heart1').css('opacity', 0);
            $(this).children('.icon-heart2').css('opacity', 1);
            $.ajax({
                url: 'addwish',
                type: 'GET',
                data: {'id': $id},
                success: function () {
                    console.log('ehy');
                    swal({
                        title: $nome + "aggiunto alla Wishlist",
                        text: "Potrai visualizzare il prodotto in seguito",
                        icon: "success",
                        timer: 3000
                    });
                }
            });
    });
});

     $(document).on('click', '.header-wish-item-img', function(e){
         $id = $(this).attr('value');
         $.ajax({
             url: 'remwish',
             type: 'GET',
             data: {'id': $id},
             success: function () {
                 console.log('eliminato');
                 $.ajax({
                     url : "/wishlist",
                     type: "GET",
                     dataType: "html",
                     success: function(data) {
                         $('.header-wish-content').html(data);
                     },
                     error: function() {
                         console.log('Errore');
                     }
                 });
                 $('#product_div').find('.women').each(function () {
                     $id = $(this).find('.js-show-modal1').attr('value');
                     console.log($id);
                     $back = $(this);
                     $.ajax({
                         url: '/wishprec',
                         data: {'id': $id},
                         dataType: 'json',
                         context: this,
                         success: function (data) {
                             if (data["esiste"] == 1){
                                 console.log(1);
                                 $(this).find('.icon-heart2').css('opacity', 0);
                                 $(this).find('.icon-heart2').css('opacity', 1);
                             }
                             else {
                                 console.log(0);
                                 $(this).find('.icon-heart1').css('opacity', 1);
                                 $(this).find('.icon-heart2').css('opacity', 0);
                             }
                         }
                     });
                 });
             }
         });
     });


