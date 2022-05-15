@extends ('layout')
@section('title', 'Detail Product')
@section ('body')

	<!-- breadcrumb -->
	@foreach($products as $product)
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-lr-0-lg">
			<a class="stext-109 cl8 hov-cl1 trans-04">
				| Home |
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<a class="stext-109 cl8 hov-cl1 trans-04">
				|
				@foreach($categories as $category) 
					{{$category->category_name}} |
				@endforeach
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				| {{ $product->product_name }} |
			</span>
		</div>
	</div>
		

	<!-- Product Detail -->
	<section class="sec-product-detail bg0 p-t-65">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-lg-7 p-b-30">
					<div class="p-l-25 p-r-30 p-lr-0-lg">
						        
						<div class="wrap-slick3 flex-sb flex-w">
							<div class="wrap-slick3-dots"></div>
							<div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

							<div class="slick3 gallery-lb">
								@foreach($image as $images)         
								<div class="item-slick3" data-thumb="{{ asset($images->image_name) }}">
									<div class="wrap-pic-w pos-relative">
										<img src="{{ asset($images->image_name) }}" alt="IMG-PRODUCT">

										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="{{ asset($images->image_name) }}">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>
								@endforeach   
							</div>
						</div>  
					</div>
				</div>
					
				<div class="col-md-6 col-lg-5 p-b-30">
					<div class="p-r-50 p-t-5 p-lr-0-lg">
						<h4 class="mtext-105 cl2 js-name-detail p-b-14">
							{{ $product->product_name }}
						</h4>
						
						@php
							$value = 0;

							foreach ($discount as $discounts) {
								if($product->id == $discounts->product_id){
									$value = $discounts->percentage;
									break;
								}
							}

							$total = $product->price*((100-$value)/100);
							$id_product = $product->id;
						@endphp
						<span class="mtext-106 cl2">
							Rp. {{ $total }},00
						</span>

						<div class="stext-105 cl3 p-t-10">
							@foreach($discount as $discounts)  
								@if($product->id == $discounts->product_id)
								<button type="button" class="btn btn-danger">{{ $discounts->percentage }}% off</button>
								@endif
							@endforeach

							@foreach($discount as $discounts)
								@if($product->id == $discounts->product_id)  
								<span class="pos-relative">
									<del>Rp. {{$product->price}},00</del>
								</span>
								@endif
							@endforeach
						</div>

						<div class="flex-l p-t-3">
								<a href="#" class="pos-relative">
									<i class="material-icons text-sm yellow lighten-1">star_border</i>
								</a>
								<a href="#" class="pos-relative">
								{{$product->product_rate}}/5  from  0 Review
								</a>
						</div>
						
						<p class="stext-102 cl3 p-t-20">
							Description  : {{ $product->description }}
						</p>

						<p class="stext-102 cl3 p-t-5">
							Total Weight : {{ $product->weight }} kg
						</p>


						<!-- <p class="stext-102 cl3 p-t-5">
							Choose Yours :
						</p>
						
						<div class="p-t-5">
							<div class="flex-w flex-r-m p-b-10">
								<div class="size-203 flex-c-m respon6">
									Size
								</div>

								<div class="size-204 respon6-next">
									<div class="rs1-select2 bor8 bg0">
										<select class="js-select2" name="time">
											@forelse($stoks as $stok) 
												<option>Size {{ $stok->stok_name }} (Stok : {{ $stok->stok }})</option>
											@empty
												<option>Stok Kosong</option>
											@endforelse  
										</select>
										<div class="dropDownSelect2"></div>
									</div>
								</div>
							</div> -->

							<!-- <div class="flex-w flex-r-m p-b-10">
								<div class="size-204 flex-w flex-m respon6-next">
									<div class="wrap-num-product flex-w">
										<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-minus"></i>
										</div>

										<input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product" value="1">

										<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-plus"></i>
										</div>
									</div>
								</div>
							</div>	 -->

							<p class="stext-102 cl3 p-t-5">Pilih Stok</p>
							<!-- <div class="size-204 respon6-next">
								<div class="rs1-select2 bor8 bg0">
									<select class="js-select2" name="stok">
										@forelse($stoks as $stok) 
											<option value="{{$stok->stok_name}}">Size {{ $stok->stok_name }} (Stok : {{ $stok->stok }})</option>
										@empty
											<option>Stok Kosong</option>
										@endforelse  
									</select>
									<div class="dropDownSelect2"></div>
								</div>
							</div> -->
							<form id="addcartform" action="{{ route('keranjang-tambah', $product->id) }}" method="POST"  enctype="multipart/form-data">
								@csrf
								<input type="number" class="form-control" value="1" id="keranjang" name="jumlah_keranjang" hidden>
								<!-- <input type="number" class="form-control" value="1" id="" name="stok" hidden> -->
								<!-- <select class="form-control" name="stok_name">
								@foreach($stoks as $stok)
                                    <option value="{{$stok->stok_name}}">Size {{ $stok->stok_name }} (Stok : {{ $stok->stok }})</option>   
                                @endforeach
								</select> -->
								<div class="size-204 respon6-next">
									<div class="rs1-select2 bor8 bg0">
										<select class="js-select2" name="stok">
											@forelse($stoks as $stok) 
												<option value="{{$stok->id}}">Size {{ $stok->stok_name }} (Stok : {{ $stok->stok }})</option>
											@empty
												<option>Stok Kosong</option>
											@endforelse  
										</select>
										<div class="dropDownSelect2"></div>
									</div>
								</div>
							</form>

							<div>
							<p class="stext-102 cl3 p-t-10">Atur Jumlah</p>
							<div class="row">
								<div class="col-9">

							<input class="form-control form-control-lg" type="number" value="1" id="jumlah" min="1" onkeyup="if(this.value<0){this.value= this.value * -1}else if(this.value==0){this.value = 1}">
							<h6 class="stext-102 cl3">Subtotal : Rp. <span id="subtotal">
									@if(!empty($discount))
									{{$total}}
									@else
									{{$product->price}}
									@endif
							</span><span>,00</span></h6>

								</div>
							</div>

							@if (Auth::user())
							<button class="stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04" href="{{route('keranjang-tambah', $product->id)}}"
								onclick="event.preventDefault();
									document.getElementById('addcartform').submit();">
								Add to cart
							</button>

							<!-- <form class="d-grid" method="post" action="{{route('keranjang-tambah', $product->id)}}" enctype="multipart/form-data">
								<button class="stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
									Add to cart
								</button>
							</form> -->

								<button class="stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
									Buy Now
								</button>
							</div>
							@else
							<a href="{{route('login')}}">
								<button class="stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
									Add to cart
								</button>
							</a>
							<a href="{{route('login')}}">
							<button class="stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
								Buy Now
							</button>
							</a>
							@endif					
						</div>
					</div>
				</div>
			</div>

			@php
				$tes = App\Models\Product_reviews::where('product_id', '=', $product->id)->count();
			@endphp

			<div class="bor10 m-t-50 p-t-43 p-b-40">
				<!-- Tab01 -->
				<div class="tab01">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item p-b-10">
							<a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Reviews ({{$tes}})</a>
						</li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content p-t-43">

						<!-- - -->
						<div class="tab-pane fade show active" id="reviews" role="tabpanel">
							<div class="row">
								<div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
									<div class="p-b-30 m-lr-15-sm">
										<!-- Review -->
										@foreach($reviews as $review)  
										<div class="flex-w flex-t pb-5">
											<div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">
												<img src="/images/avatar-01.jpg" alt="AVATAR">
											</div>

											@php
                                            $user = App\Models\User::where('id', '=', $review->user_id)->first();
                                            @endphp

											<div class="size-207">
												<div class="flex-w flex-sb-m p-b-17 pt-4">
													<span class="mtext-107 cl2 p-r-20">
														{{$user->name}}
													</span>

													<span class="fs-18 cl11">
													<span class="">{{$review->rate}}/5<i class="zmdi zmdi-star"></i> </span>
													</span>
												</div>

												<p class="stext-102 ">
													Ulasan : {{$review->content}}
												</p>


												@foreach($responses as $response)
												@if($response->review_id==$review->id)
												@php
												$admin = App\Models\Admin::where('id', '=', $response->admin_id)->first();
												@endphp  
												<p class="stext-102 cl6">
													This Review was Responded "{{$response->content}}" by {{$admin->name}}
												</p>
												@endif
												@endforeach

											</div>
										</div>
										@endforeach

										@if (Auth::user())

										@php
									
										$check = App\Models\Product_reviews::where('user_id', '=', auth()->user()->id)->where('product_id', '=', $id_product)->count();
										@endphp


										@if	($cek != 0)
										<!-- Add review -->
										<form class="w-full form-signin" action="/{{$product->id}}/addReview" method="post" enctype="multipart/form-data">
											<h5 class="mtext-108 cl2 p-b-7">
												Add a review
											</h5>
                           					@csrf

											<div class="col-lg">
												<div class="input-group input-group-static my-3">
													<input type="text" id="" class="form-control"  name="user_id" value="{{auth()->user()->id}}" hidden>
												</div>
											</div>

											<div class="flex-w flex-m p-b-23">
												<span class="stext-102 cl3 m-r-16">
													Your Rating
												</span>

												<span class="wrap-rating fs-18 cl11 pointer">
													<i class="item-rating pointer zmdi zmdi-star-outline" value ="1"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline" value ="2"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline" value ="3"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline" value ="4"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline" value ="5"></i>
													<input class="dis-none" type="number" name="rate">
												</span>
											</div>

											<div class="row p-b-25">
												<div class="col-12 p-b-5">
													<label class="stext-102 cl3" for="review">Your review</label>
													<textarea class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10" id="review" name="content"></textarea>
												</div>
											</div>

											<button class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10" type="submit">
												Submit
											</button>
										</form>
										@endif
										@endif
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	<div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
		<span class="stext-107 cl6 p-lr-25">
			Categories:
			@foreach($categories as $category)
			[{{$category->category_name}}]
			@endforeach
		</span>
	</div> 
	</section>
    @if(!empty($discount))
    @php
    $harga_fix = $total;
    @endphp
    @else
    @php
    $harga_fix = $product->price
    @endphp
    @endif
	@endforeach
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		var jumlah = "jumlah";
		var harga = "<?php echo $harga_fix; ?>";
		$("#" + jumlah).change(function() {
			var hasil = harga * $("#jumlah").val();
			$("#subtotal").text(hasil);
			$("#keranjang").val($("#jumlah").val());
			$("#beli").val($("#jumlah").val());
		});
	});
</script>

@endsection