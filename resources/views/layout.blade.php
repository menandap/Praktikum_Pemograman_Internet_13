<!DOCTYPE html>
<html lang="en">
<head>
	<title>
		@yield('title')
	</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="{{URL::asset('img/icons/favicon.png')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{URL::asset('vendor/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('fonts/iconic/css/material-design-iconic-font.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{URL::asset('vendor/animate/animate.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{URL::asset('vendor/css-hamburgers/hamburgers.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{URL::asset('vendor/animsition/css/animsition.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{URL::asset('vendor/select2/select2.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{URL::asset('vendor/daterangepicker/daterangepicker.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{URL::asset('vendor/slick/slick.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{URL::asset('vendor/MagnificPopup/magnific-popup.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{URL::asset('vendor/perfect-scrollbar/perfect-scrollbar.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}">
<!--===============================================================================================-->
	 <!--Import Google Icon Font-->
 	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<!--Import materialize.css-->
	<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	
</head>
<body class="animsition">

	 <!--JavaScript at end of body for optimized loading-->
	 <script type="text/javascript" src="js/materialize.min.js"></script>
	
	<!-- Header -->
	<header class="header-v4">
		<!-- Header desktop -->
		<div class="container-menu-desktop">
			<div class="wrap-menu-desktop how-shadow1">
				<nav class="limiter-menu-desktop container">
					
					<!-- Logo desktop -->		
					<a href="#" class="logo">
						<img src="/images/icons/logo-01.png" alt="IMG-LOGO">
					</a>

					<!-- Menu desktop -->
					<div class="menu-desktop">
						<ul class="main-menu">
							@if (Auth::user())
							<li class="active-menu">
								<a href="{{ route('homepage') }}">Home</a>
							</li>
							@else
							<li class="active-menu">
								<a href="{{ route('home') }}">Home</a>
							</li>
							@endif

							@if (Auth::user())
							<li>
								<a href="{{ route('product') }}">Shop</a>
							</li>
							@else
							<li>
								<a href="{{ route('homeproduct') }}">Shop</a>
							</li>
							@endif

							<li class="label1" data-label1="hot">
								<a href="{{ route('cart') }}">Your Cart</a>
							</li>

							@if (Auth::user())
							<li>
								<a href="{{route('transaksi')}}">Transaction</a>
							</li>
							@endif
						</ul>
					</div>	

					<!-- Icon header -->
					<div class="wrap-icon-header flex-w flex-r-m">
						<div class="p-r-11 p-lr-11 icon-header-item cl2 hov-cl1 trans-04 js-show-modal-search">
							<i class="zmdi zmdi-search"></i>
						</div>

						@if (Auth::user())
						@php

						$user_id = auth()->user()->id;
						$cek = App\Models\Carts::where('user_id', '=', $user_id)->where('status', '=', 'aktif')->count();								

						@endphp

						<div class="p-r-11 p-lr-11 icon-header-item cl2 hov-cl1 trans-04 icon-header-noti js-show-cart" data-notify="{{$cek}}">
							<i class="zmdi zmdi-shopping-cart"></i>
						</div>
						@else
						<a href="{{route('login')}}" class="p-r-11 p-lr-11 dis-block icon-header-item cl2 hov-cl1 trans-04 icon-header-noti" data-notify="0">
							<i class="zmdi zmdi-shopping-cart"></i>
						</a>
						@endif

						<ul class="icon-header-item main-menu">
							<li class="active-menu">
								<i class="fa fa-user"></i>
								@if (Auth::user())
								<h4 class="d-sm-inline d-none">{{auth()->user()->name}}</h4>
								<ul class="sub-menu">
										<li class="scroll-to-section"><a href="{{ route('logout') }}" onclick="event.preventDefault();
											document.getElementById('logout-form').submit()">Log out</a></li>

										<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
											@csrf
										</form>
								</ul>
								@else
								<!-- <span class="d-sm-inline d-none">Non User</span> -->
								<ul class="sub-menu">
										<li class="submenu"><a href="{{route('login')}}">Login</a></li>
								</ul>
								@endif
							</li>
						</ul>

						<ul class="main-menu">
							<li class="active-menu">
							@if (Auth::user())	
								@php $user_notifikasi = App\Models\User_notifications::where('notifiable_id', Auth::user()->id)->where('read_at', NULL)->orderBy('created_at','desc')->get(); @endphp
								@php $user_unRead = App\Models\User_notifications::where('notifiable_id', Auth::user()->id)->where('read_at', NULL)->orderBy('created_at','desc')->count(); @endphp

								<i class="fa fa-bell icon-header-item cl2 hov-cl1 trans-04 icon-header-noti" data-notify="{{$user_unRead}}"></i>


								<ul class="sub-menu">
								@forelse ($user_notifikasi as $notifikasi)
								@php $notif = json_decode($notifikasi->data); @endphp
								<li>
									<a href="{{ route('notification', $notifikasi->id) }}" class="dropdown-item btnunNotif" data-num=""><small>[{{ $notif->nama }}] {{ $notif->message }}</small></a>
								</li>
								@empty
									<li>
									<a href="#" class="dropdown-item btnunNotif" data-num="" >
										&nbsp;<small>Tidak ada notifikasi</small>
									</a>
									</li>
								@endforelse
								</ul>
							@else 
							@endif
							</li>
						</ul>

					</div>
				</nav>
			</div>	
		</div>
		
		<!-- Modal Search -->
		<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
			<div class="container-search-header">
				<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
					<img src="images/icons/icon-close2.png" alt="CLOSE">
				</button>

				<form class="wrap-search-header flex-w p-l-15">
					<button class="flex-c-m trans-04">
						<i class="zmdi zmdi-search"></i>
					</button>
					<input class="plh3" type="text" name="search" placeholder="Search...">
				</form>
			</div>
		</div>
	</header>

	<!-- Content -->
	@yield('body')

	<!-- Footer -->
	<footer class="bg3 p-t-75 p-b-32">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Categories
					</h4>

					<ul>
						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Women
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Men
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Shoes
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Watches
							</a>
						</li>
					</ul>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Help
					</h4>

					<ul>
						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Track Order
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Returns 
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Shipping
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								FAQs
							</a>
						</li>
					</ul>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						GET IN TOUCH
					</h4>

					<p class="stext-107 cl7 size-201">
						Any questions? Let us know in store at 8th floor, 379 Hudson St, New York, NY 10018 or call us on (+1) 96 716 6879
					</p>

					<div class="p-t-27">
						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-facebook"></i>
						</a>

						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-instagram"></i>
						</a>

						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-pinterest-p"></i>
						</a>
					</div>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Newsletter
					</h4>

					<form>
						<div class="wrap-input1 w-full p-b-4">
							<input class="input1 bg-none plh1 stext-107 cl7" type="text" name="email" placeholder="email@example.com">
							<div class="focus-input1 trans-04"></div>
						</div>

						<div class="p-t-18">
							<button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
								Subscribe
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</footer>


	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>

	<script src="{{asset('vendor/jquery/jquery-3.2.1.min.js')}}"></script>
	<script src="{{URL::asset('vendor/MagnificPopup/jquery.magnific-popup.min.js')}}"></script>
	<script src="{{asset('vendor/animsition/js/animsition.min.js')}}"></script>
	<script>
        $('.gallery-lb').each(function() { // the containers for all your galleries
            $(this).magnificPopup({
                delegate: 'a', // the selector for gallery item
                type: 'image',
                gallery: {
                    enabled:true
                },
                mainClass: 'mfp-fade'
            });
        });
	</script>

	<!--===============================================================================================-->
	<script src="{{asset('vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<!--===============================================================================================-->
	<script src="{{asset('vendor/select2/select2.min.js')}}"></script>
	<script>
        $(".js-select2").each(function(){
            $(this).select2({
                minimumResultsForSearch: 20,
                dropdownParent: $(this).next('.dropDownSelect2')
            });
        })
	</script>
	<!--===============================================================================================-->
	<script src="{{URL::asset('vendor/daterangepicker/moment.min.js')}}"></script>
	<script src="{{URL::asset('vendor/daterangepicker/daterangepicker.js')}}"></script>
	<!--===============================================================================================-->
	<script src="{{asset('vendor/slick/slick.min.js')}}"></script>
	<script src="{{URL::asset('js/slick-custom.js')}}"></script>
	<!--===============================================================================================-->
	<script src="{{URL::asset('vendor/parallax100/parallax100.js')}}"></script>
	<script>
        $('.parallax100').parallax100();
	</script>
	<!--===============================================================================================-->
	<script src="{{URL::asset('vendor/MagnificPopup/jquery.magnific-popup.min.js')}}"></script>
	<script>
        $('.gallery-lb').each(function() { // the containers for all your galleries
            $(this).magnificPopup({
                delegate: 'a', // the selector for gallery item
                type: 'image',
                gallery: {
                    enabled:true
                },
                mainClass: 'mfp-fade'
            });
        });
	</script>
	<!--===============================================================================================-->
	<!--<script src="{{URL::asset('vendor/isotope/isotope.pkgd.min.js')}}"></script>  Filtro per il filtraggio degli items  -->
	<!--===============================================================================================-->
	<script src="{{URL::asset('vendor/sweetalert/sweetalert.min.js')}}"></script>
	<!--===============================================================================================-->
	<script src="{{URL::asset('vendor/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
	<script>
        $('.js-pscroll').each(function(){
            $(this).css('position','relative');
            $(this).css('overflow','hidden');
            var ps = new PerfectScrollbar(this, {
                wheelSpeed: 1,
                scrollingThreshold: 1000,
                wheelPropagation: false,
            });

            $(window).on('resize', function(){
                ps.update();
            })
        });
	</script>
	<script src="{{URL::asset('js/cart.js')}}"></script>
	<script src="{{URL::asset('js/main.js')}}"></script>
	<script src="{{URL::asset('js/GenderFilter.js')}}"></script>
	<script src="{{URL::asset('js/LiveSearch.js')}}"></script>
	<script src="{{URL::asset('js/profile.js')}}"></script>
	<script src="{{URL::asset('js/comments.js')}}"></script>
	<script src="{{URL::asset('js/reviews.js')}}"></script>
	<script src="{{URL::asset('js/wish.js')}}"></script>
	<script>
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('google_map'), {
          center: {lat: 42.028528, lng: 13.425751},
          zoom: 8
        });
      }
    </script>
	<!--===============================================================================================-->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBq7gUuC_A9LdVf0_HGomR6Gymh7Ed5mP4&callback=initMap"
			async defer></script>
	<script src="js/map-custom.js"></script>
	<!--===============================================================================================-->
</body>
</html>