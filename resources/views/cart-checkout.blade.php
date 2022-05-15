@extends('layout')

@section('title', 'Preview Transaction')

@section('body')
<div class="container">
    <div class="bread-crumb flex-w ">
        <a class="stext-109 cl8 hov-cl1 trans-04">
            Cart
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <span class="stext-109 cl4">
            Preview Transaction
        </span>
    </div>
</div>
<div class="bg0">
    <div class="container  m-t-40 m-b-60">
        <div class="row">
            <div class="col-lg">
                <h3 class="card-title m-b-50 flex-c-m">This Information is Preview of Your Transaction  :</h3>
                <form method="post" action="{{route('keranjang-bayar')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-9">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <h4 class="card-title m-t-25">User Name</h4>
                                        <input type="text" class="form-control" readonly value="{{auth()->user()->name}}" name="username">
                                    </div>
                                    <div class="form-group">
                                        <h4 class="card-title m-t-25">Provinsi</h4>
                                        <input type="text" class="form-control" readonly value="{{$province_name}}" name="province">
                                    </div>
                                    <div class="form-group">
                                        <h4 class="card-title m-t-25">Kabupaten/Kota</h4>
                                        <input type="text" class="form-control" readonly value="{{$regency_name}}" name="regency">
                                    </div>
                                    <div class="form-group">
                                        <h4 class="card-title m-t-25">Alamat</h4>
                                        <input type="text" class="form-control" readonly value="{{$address}}" name="address">
                                    </div>
                                    <div class="form-group">
                                        <h4 class="card-title m-t-25">Kurir</h4>
                                        <input type="text" class="form-control" readonly value="{{$kurir->courier}}" name="courier">
                                    </div>
                                </div>
                            </div>

                            @foreach($keranjang as $keranjangs)
                            <div class="card">
                                @php
                                $gambar = App\Models\Product_images::where('product_id', '=', $keranjangs->product->id)->first();
                                @endphp
                                <div class="row g-0">
                                    <div class="col-md-3">
                                        <img img class="img-fluid rounded-start" src="{{ asset($gambar->image_name) }}"style="height:200px;">
                                    </div>

                                    @php
                                    $stoks_detail = App\Models\Product_stok_details::where('id', '=', $keranjangs->stok)->first();
                                    $stoks = App\Models\Product_stoks::where('id', '=', $stoks_detail->stok_id)->first();
                                    @endphp

                                    <div class="col-md-9">
                                        <div class="card-body">
                                            <h4 class="card-title">{{$keranjangs->product->product_name}} ({{$stoks->stok_name}})</h4>

                                            @php
                                            $tanggal = Carbon\Carbon::now()->format('Y-m-d');
                                            $diskon = App\Models\Discounts::where('product_id', '=', $keranjangs->product->id)->where('start', '<=', $tanggal)->where('end', '>=', $tanggal)->get();
                                                $harga = $keranjangs->product->price;
                                                if (count($diskon) > 0) {
                                                foreach ($diskon as $diskons) {
                                                $harga = $harga - ($harga * $diskons->percentage / 100);
                                                }

                                                }
                                                @endphp

                                                <div class="form-inline">
                                                    <h5 class="card-subtitle mb-2 mt-2 text-muted">Rp. {{$harga}},00 </h5>
                                                    @if(count($diskon)>0)
                                                    <h5 class="card-subtitle mb-2 mt-2 ms-2 text-muted text-decoration-line-through"> (from Rp.{{$keranjangs->product->price}},00)</h5>
                                                    @endif
                                                </div>


                                                @if(count($diskon)>0)
                                                <h5 class="card-subtitle mb-2 text-muted m-t-5">
                                                    Diskon&nbsp;&nbsp;:
                                                    @foreach($diskon as $diskons)
                                                    @if($loop->index==0)
                                                    <span>{{$diskons->percentage}}% OFF</span>
                                                    @else
                                                    <span> + {{$diskons->percentage}}% OFF</span>
                                                    @endif
                                                    @endforeach
                                                </h5>
                                                @endif

                                                <div class="text-end">
                                                    <div class="form-inline">
                                                        <h5 class="card-subtitle mb-2 mt-2 text-muted">Rp.</h5>
                                                        <h5 class="card-subtitle mb-2 mt-2 text-muted">{{$harga}}</h5>
                                                        <h5 class="card-subtitle mb-2 mt-2 text-muted">&nbsp;x&nbsp;</h5>
                                                        <h5 class="card-subtitle mb-2 mt-2 text-muted">{{$keranjangs->qty}}</h5>
                                                        <h5 class="card-subtitle mb-2 mt-2 text-muted">&nbsp;=&nbsp;</h5>
                                                        <h5 class="card-subtitle mb-2 mt-2 text-muted">Rp.</h5>
                                                        <h5 class="card-subtitle mb-2 mt-2 text-muted">{{$selling_price[$loop->index] * $keranjangs->qty}}</h5>
                                                    </div>

                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="number" class="form-control" value="{{$keranjangs->id}}" name="keranjang[]" hidden>
                                <input type="number" class="form-control" value="{{$discount[$loop->index]}}" name="discount[]" hidden>
                                <input type="number" class="form-control" value="{{$selling_price[$loop->index]}}" name="selling_price[]" hidden>
                            </div>
                            @endforeach
                        </div>

                        <div class="col-3">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title m-t-25 m-b-30">Pembayaran</h4>
                                    <div class="row">
                                        <div class="col-5">
                                            <h5 class="card-subtitle mb-3 text-muted">Subtotal</h5>
                                            <h5 class="card-subtitle text-muted">Ongkir</h5>
                                        </div>
                                        <div class="col-7">
                                            <div class="form-inline mb-3">
                                                <h5 class="card-subtitle text-muted">Rp.</h5>
                                                <h5 class="card-subtitle text-muted">{{$subtotal}}</h5>
                                            </div>
                                            <div class="form-inline">
                                                <h5 class="card-subtitle text-muted">Rp.</h5>
                                                <h5 class="card-subtitle text-muted">{{$shipping_cost}}</h5>
                                            </div>
                                        </div>
                                        <div class="progress-container mb-4">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <h5 class="card-subtitle mb-2 text-muted">Total</h5>
                                        </div>
                                        <div class="col-7">
                                            <div class="form-inline">
                                                <h5 class="card-subtitle mb-2 text-muted">Rp.</h5>
                                                <h5 class="card-subtitle mb-2 text-muted">{{$total}}</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="number" class="form-control" value="{{$subtotal}}" name="subtotal" hidden>
                                    <input type="number" class="form-control" value="{{$shipping_cost}}" name="shipping_cost" hidden>
                                    <input type="number" class="form-control" value="{{$total}}" name="total" hidden>

                                    <row>
                                    <button type="submit" class="m-l-15 m-t-40 m-b-40 flex-c-m p-lr-15 m-tb-10 size-119 stext-101 cl2 bg8 bor13 hov-btn3" style="width:200px;">	Check-out </button>			
                                    </row>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $('#kota').on('click', function() {
        $("#kota option").each(function() {
            if ($(this).attr("id") == $('#provinsi').children(":selected").attr("id")) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
</script>
@endsection