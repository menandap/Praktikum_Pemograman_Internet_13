@extends ('layout')
@section('title', 'Cart')
@section ('body')

    <!-- breadcrumb -->
    <div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-lr-0-lg">
			<a class="stext-109 cl8 hov-cl1 trans-04">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				Shoping Cart
			</span>
		</div>
	</div>

    <form class="bg0 p-t-75 p-b-85" method="post" action="{{route('keranjang-alamat')}}" enctype="multipart/form-data">
		@csrf
		
		@php
			$harga_static = 0;
			$i = 0;
			$array_harga = array();
		@endphp

		<div class="container">
			<div class="row">
				<div class="col-lg col-xl m-lr-auto m-b-50">
					<div class="m-l-25 m-r--38 m-lr-0-xl">
						@php

						$user_id = auth()->user()->id;
						$cek = App\Models\Carts::where('user_id', '=', $user_id)->where('status', '=', 'aktif')->count();								

						@endphp

						@if($cek != 0)
						<div class="wrap-table-shopping-cart">
							<table class="table-shopping-cart">
								<tr class="table_head">
									<th class="column-1">Product</th>
									<th class="column-2">Name</th>
									<th class="column-3">Stok Name</th>
									<th class="column-3">Price</th>
									<th class="column-3">Quantity</th>
								</tr>

								@foreach($keranjang as $keranjangs)
								@php
								$gambar = App\Models\Product_images::where('product_id', '=', $keranjangs->product->id)->first();
								@endphp


								@php
									$tanggal = Carbon\Carbon::now()->format('Y-m-d');
									$discount = App\Models\Discounts::where('product_id', '=', $keranjangs->product->id)->where('start', '<=', $tanggal)->where('end', '>=', $tanggal)->get();
									$harga = $keranjangs->product->price;
									if (count($discount) > 0) {
									foreach ($discount as $discounts) {
									$harga = $harga - ($harga * $discounts->percentage / 100);
									}

									}
									$harga_static = $harga_static + ($harga * $keranjangs->qty);
									array_push($array_harga, $harga);
                                @endphp

								<tr class="table_row">  
									<td class="column-1">
										<div class="m-t-30">
											<img src="{{ asset($gambar->image_name) }}" style="height:200px;width:auto!important;">
										</div>
									</td>
									@php
									$stoks_detail = App\Models\Product_stok_details::where('id', '=', $keranjangs->stok)->first();
									$stoks = App\Models\Product_stoks::where('id', '=', $stoks_detail->stok_id)->first();
									@endphp
									<td class="column-2">{{$keranjangs->product->product_name}}</td>
									<td class="column-3">{{$stoks->stok_name}}</td>
									<td class="column-3">Rp. {{$harga}},00</td>
									<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
									<td class="column-4">
										<div class="form-inline" >
											<input class="form-control form-control-lg m-r-20" style="width:70px;" type="number" name="jumlah[]" value="{{$keranjangs->qty}}" id="jumlah{{$i}}" min="1" onkeyup="if(this.value<0){this.value= this.value * -1}else if(this.value==0){this.value = 1}">
											<a onclick="return confirm('Apa yakin ingin menghapus product ini dari Cart?')" href="{{route('keranjang-hapus', $keranjangs->id)}}"> <i class="material-icons text-sm">delete</i>&nbsp;&nbsp;</li> </a>      
										</div>
									</td>
								</tr>

								@php
                                $i++;
                                @endphp

								@endforeach
								
							</table>
						</div>

						<div class="flex-c p-t-18 p-b-15">
							<div class="flex-c-m m-tb-5">
								<span class="size-207 m-r-20"> Total Harga </span>
								<span >Rp.</span>
								<span id="total">{{$harga_static}}</span>
								<span >,00</span>
							</div>
						</div>
						<!-- <div class="flex-c-m p-lr-15 m-tb-10 size-119 stext-101 cl2 bg8 bor13 hov-btn3"> -->
							<button type="submit" class="btn-block flex-c-m p-lr-15 m-tb-10 size-119 stext-101 cl2 bg8 bor13 hov-btn3">	Procces Cart to Buy </button>
						<!-- </div> -->

						@else
							<h4 class="mtext-105 cl2 js-name-detail p-b-14 text-center">Nothing in Your Cart</h4>								
						@endif
					</div>
				</div>				
			</div>
		</div>
	</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("input.form-control.form-control-lg").click(function() {
            var array_harga = <?php echo json_encode($array_harga, true); ?>;
            var total = 0;
            var indeks = 0;
            $("input.form-control.form-control-lg").each(function() {
                total = total + (array_harga[indeks] * $(this).val());
                indeks++;
            });
            $("#total").text(total);
        });
    });
</script>

@endsection