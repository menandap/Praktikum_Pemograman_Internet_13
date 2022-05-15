@extends ('layout')
@section('title', 'Product')
@section ('body')
<!-- Product -->
<div class="bg0 m-t-23">
		<div class="container">
			<div class="flex-w flex-sb-m p-b-52">
				<div class="flex-w flex-l-m filter-tope-group m-tb-10">
					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1" data-filter="*">
						All Products
					</button>

					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".women">
						Women
					</button>

					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".men">
						Men
					</button>

					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".bag">
						Bag
					</button>

					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".shoes">
						Shoes
					</button>

					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".watches">
						Watches
					</button>
				</div>

				<div class="flex-w flex-c-m m-tb-10">
					<div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
						<i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
						<i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
						 Filter
					</div>

					<div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
						<i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
						<i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
						Search
					</div>
				</div>
				
				<!-- Search product -->
				<div class="dis-none panel-search w-full p-t-10 p-b-15">
					<div class="bor8 dis-flex p-l-15">
						<button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
							<i class="zmdi zmdi-search"></i>
						</button>

						<input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product" placeholder="Search">
					</div>	
				</div>

			<div class="row isotope-grid">
				@foreach ($product as $products)
				<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
					<!-- Block2 -->
					<div class="block2">
						<div class="block2-pic hov-img0">
							@foreach($products->product_images as $image)
								<img src="{{ asset($image->image_name) }}" alt="IMG-PRODUCT" style="width:300px; height:400px;">
								@break
                            @endforeach
							@if (Auth::user())
							<a href="/usr-product/{{$products->id}}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
								See Product
							</a>
							@else
							<a href="/product/{{$products->id}}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
								See Product
							</a>
							@endif
						</div>
						
						<div class="block2-txt flex-w flex-t p-t-14">
							<div class="block2-txt-child1 flex-col-l ">
							<a href="/product/{{$products->id}}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
									{{$products->product_name}}
								</a>

								@php
									$value = 0;

									foreach ($discount as $discounts) {
										if($products->id == $discounts->product_id){
											$value = $discounts->percentage;
											break;
										}
									
									}

									$total = $products->price*((100-$value)/100);
                                @endphp
								<span class="stext-105 cl3">
								Rp. {{$total}},00
								</span>

								@php
                                	$tes = App\Models\Product_reviews::where('product_id', '=', $products->id)->count();
                                @endphp

								<div class="flex-l p-t-3">
									<a href="#" class="pos-relative">
										<i class="material-icons text-sm yellow lighten-1">star_border</i>
									</a>
									<a href="#" class="pos-relative">
										{{$products->product_rate}}/5  from  {{$tes}}  Review
									</a>
								</div>

								<div class="stext-105 cl3 pt-2">
									@foreach($discount as $discounts)  
										@if($products->id == $discounts->product_id)
										<button type="button" class="btn btn-danger">{{ $discounts->percentage }}% off</button>
										@endif
									@endforeach

									@foreach($discount as $discounts)
										@if($products->id == $discounts->product_id)  
										<span class="pos-relative">
											<del>Rp. {{$products->price}},00</del>
										</span>
										@endif
									@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>
				@endforeach 
			</div>

			<!-- Load more -->
			<div class="flex-c-m flex-w w-full p-t-45">
				<a href="#" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
					Load More
				</a>
			</div>
		</div>
	</div>

@endsection