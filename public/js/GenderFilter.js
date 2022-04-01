/* Filtra i prodotti per (Uomo, Donna ecc) */
$(document).ready(function(){
    $('.js-home-filtering').click(function(e){
        e.preventDefault();
        $value = e.target.value;
        $.ajax({
            url : "/filter",
            type: "GET",
            data: {'type': $value},
            dataType: "json",
            success: function(data) {
                $('#product_div').hide().html(data).fadeToggle(1300);
            },
            error: function() {
                alert('AJAX error');
            }
        });
        console.log($value);
    });
});

$('.js-show-cart').click(function(e){
    e.preventDefault();
    $('.js-panel-cart').addClass('show-header-cart');
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

/*==================================================================
    [ Cart ] */ /*Javascript che mostra il carrello con i prodotti selezionati*/

$('.js-hide-cart').on('click',function(){
    $('.js-panel-cart').removeClass('show-header-cart');
});

/*==================================================================
[ Cart ]*/

$('.js-show-sidebar').on('click',function(){
    $('.js-sidebar').addClass('show-sidebar');
});

$('.js-hide-sidebar').on('click',function(){
    $('.js-sidebar').removeClass('show-sidebar');
});


//Shop blade, mostra il pannello per la scelta delle categorie, regola le animazioni e lo style dei pulsanti

//Categorie Femminili

$('.js-show-filter-woman').on('click',function(){
    if ($('.js-show-filter-man').hasClass('show-filter')){
        $('.js-show-filter-man').removeClass('show-filter');
        $('.panel-filter').slideUp(400);
    }
    $(this).toggleClass('show-filter');
    $.ajax({
        url : "/womanfilter",
        type : "GET",
        dataType: "json",
        data: {'gender': 'donna'},
        success: function (data) {
            $('.panel-filter').html(data);
            $('.panel-filter').slideToggle(400);
        },
        error: function () {
            console.log('errore');
        }
    });
});

//Categorie Maschili

$('.js-show-filter-man').on('click',function(){
    if ($('.js-show-filter-woman').hasClass('show-filter')){
        $('.js-show-filter-woman').removeClass('show-filter');
        $('.panel-filter').slideUp(400);
    }
    $(this).toggleClass('show-filter');
    $.ajax({
        url : "/womanfilter",
        type : "GET",
        dataType: "json",
        data: {'gender': 'uomo'},
        success: function (data) {
            console.log('man success');
            $('.panel-filter').html(data);
            $('.panel-filter').slideToggle(400);
        },
        error: function () {
            console.log('errore');
        }
    });
});

//Ajax carica le sotto categorie in base alla categoria principale cliccata
$(document).on('click', '.js-scelta-categoria-filtering', function () {
    $(this).css('color', '#717fe0');
    $(this).parent().siblings().each(function () {
        $(this).find('a').css('color', '#888')
    });
    if ($('.js-show-filter-woman').hasClass('show-filter')) $gender = 'donna';
    if ($('.js-show-filter-man').hasClass('show-filter')) $gender = 'uomo';
    $categoria = $(this).text();
   $.ajax({
        url: '/subcategoria',
        type: "GET",
        data: {'nome': $categoria, 'gender': $gender},
        dataType: "json",
      success: function (data) {
          $('.js-sub-categories-filtering').find('ul').hide().html("").fadeToggle(700);
          $.each(data["data"], function (key, value) {
              $('.js-sub-categories-filtering').find('ul').append('<li class="p-b-6">' +
                  '<a href="#" class="stext-106 cl6 hov1 bor3 trans-04 js-sub-product">'
                  + value["nome_sub"] +
                  '</a></li>'
          );
          });
      }
   });
});

$(document).on('click', '.js-sub-product', function () {
    if ($('.js-show-filter-woman').hasClass('show-filter')) $gender = 'donna';
    if ($('.js-show-filter-man').hasClass('show-filter')) $gender = 'uomo';
    $subcat = $(this).text();
    $.ajax({
        url: '/subcategoryfilter',
        data: {'subcat': $subcat, 'gender': $gender},
        type: "GET",
        dataType: "json",
        success: function (data) {
            $('#product_div').hide().html(data).fadeToggle(1300);
        },
        error: function () {
            console.log('errore');
        }
    });
});

