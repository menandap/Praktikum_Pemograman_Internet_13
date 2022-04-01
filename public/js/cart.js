/* Filtro per aggiunta dei prodotti nel Carrello e per la gestione grafica del Pop-up */
$(document).ready(function(){
    $('.js-addcart-detail').click(function(e){
        e.preventDefault();
        $nome = $(this).parent().parent().parent().parent().parent().find('.js-name-detail').text();
        console.log($nome);
        $value = $(this).attr('value');
        $taglia = $('#taglieselct').val();
        $numb = $('.num-product').val();
        $color = $('#colorselect').val();
        $imagedir = $('.js-get-image-cart').attr('value');
        console.log($imagedir);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url : "/addtocart",
            type: "POST",
            data: {'id': $value, 'quantità': $numb, 'colore': $color, 'taglia': $taglia, 'img': $imagedir},
            success: function (data) {
                console.log($nome);
                if($.isEmptyObject(data.error)){
                    $(".print-error-msg").css('visibility', 'hidden');
                    $(this).click(false);
                    $(this).addClass('js-addedwish-b2');
                    swal( $nome, "Aggiunto Al Carrello", "success");
                }
                else {
                    $(".print-error-msg").find("ul").html('');
                    $.each(data.error, function (key, value) {
                        $('.print-error-msg').find('ul').append('<li>' + value + '</li>');
                        $('.print-error-msg').css('visibility', 'visible');
                    });
                }
            }
        });
        $.ajax({
            url : '/getnumberitemcart',
            type: "GET",
            success: function(data) {
                $('.js-show-cart').attr('data-notify', data['count']);
            }
        });
    });
});

$(document).ready(function(){
    $.ajax({
        url : '/getnumberitemcart',
        type: "GET",
        success: function(data) {
            console.log(data);
            $('.js-show-cart').attr('data-notify', data['count']);
        }
    });
});

$(document).ready(function(){
    $('.header-cart-content').on('click', '.header-cart-item-img', function(e){
        e.preventDefault();
        $id = $(this).attr('value');
        console.log($id);
        $.ajax({
            url: '/eliminaprodottocarrello',
            type: "GET",
            dataType: "json",
            data: {'id': $id},
            success: function (data) {
                console.log(data["msg"]);
            },
            error: function() {
                console.log('Errore inserimento');
            }
        });
        $.ajax({
            url : '/getnumberitemcart',
            type: "GET",
            success: function(data) {
                console.log(data);
                $('.js-show-cart').attr('data-notify', data['count']);
            }
        });
        $.ajax({
            url : "/listacarrello",
            type: "GET",
            dataType: "html",
            success: function(data) {
                console.log('funziona, prodotto Inserito');
                $('.header-cart-content').html(data);
            },
            error: function() {
                console.log('Errore inserimento');
            }
        });
    });
});

$(document).ready(function(){
    $('.how-itemcart1').on('click', function(e){
        e.preventDefault();
        $id = $(this).attr('value');
        console.log($id);
        $.ajax({
            url: '/eliminaprodottocarrello',
            type: "GET",
            dataType: "json",
            data: {'id': $id},
            success: function (data) {
                console.log(data["msg"]);
                location.reload();
            },
            error: function() {
                console.log('Errore inserimento');
            }
        });
        $.ajax({
            url : '/getnumberitemcart',
            type: "GET",
            success: function(data) {
                console.log(data);
                $('.js-show-cart').attr('data-notify', data['count']);
            }
        });
    });
});

/*Aggiornamento Carrelo view Carrello.blade*/
$(document).ready(function() {
    $('.js-cartupdate').on('click', function(e){
        e.preventDefault();
        $('.table_row').each(function () {
            $num = $(this).find('.num-product').val();
            $id = $(this).find('.how-itemcart1').attr('value');
            console.log($num, $id);
            $.ajax({
                url: '/modificanumitems',
                type: "GET",
                data: {'id': $id, 'num': $num},
            });
        });
        location.reload();
    });
    $.ajax({
        url: '/getnumberitemcart',
        type: "GET",
        succes: function (data) {

        }
    })
});

//Effettua pagamento
$(document).ready(function () {
    $('.js-effettua-pagamento').on('click', function () {
        $indirizzo = $('#addreselect').val();
        $pagamento = $('#payselect').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: '/pagamento',
            type: "POST",
            data: {'indirizzo': $indirizzo, 'pagamento': $pagamento},
            success: function (data) {
                if ($.isEmptyObject(data.error)) {
                    console.log('inserito');
                    $('.print-error-msg-address').css('visibility', 'hidden');
                    swal({
                        title: "Pagamento effettuato con successo",
                        text: "Entra nel tuo profilo per visualizzare lo storico ordini",
                        icon: "success",
                        timer: 3000
                    }).then(() => {
                        window.location.href = '/';
                    });
                } else {
                    $(".print-error-msg").find("ul").html('');
                    $.each(data.error, function (key, value) {
                        $('.print-error-msg').find('ul').append('<li>' + value + '</li>');
                        $('.print-error-msg').css('visibility', 'visible');
                    });
                }
            }
        });
    });
});