@extends('layout')

@section('title', 'Transaction Detail')

@section('body')
<div class="container">
    <div class="bread-crumb flex-w ">
        <a class="stext-109 cl8 hov-cl1 trans-04">
            Cart
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <span class="stext-109 cl4">
            My Transaction
        </span>
    </div>
</div>
<div class="bg0">
    <div class="container  m-t-40 m-b-60">
        <div class="row">
            <div class="col-lg">
            <div class="row">
                <div class="col-9">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="cl8 hov-cl1 text-center">Your Detail Transaction</h4>
                            <h4 class="cl8 hov-cl1 m-t-50">Date : ({{$transaction->created_at}})</h4>
                            <div class="form-group">
                                <h4 class="cl8 hov-cl1 m-t-25">User Name</h4>
                                <input type="text" class="form-control" readonly value="{{auth()->user()->name}}" name="username">
                            </div>
                            <div class="form-group">
                                <h4 class="cl8 hov-cl1 m-t-25">Provinsi</h4>
                                <input type="text" class="form-control" readonly value="{{$transaction->province}}" name="province">
                            </div>
                            <div class="form-group">
                                <h4 class="cl8 hov-cl1 m-t-25">Kabupaten/Kota</h4>
                                <input type="text" class="form-control" readonly value="{{$transaction->regency}}" name="regency">
                            </div>
                            <div class="form-group">
                                <h4 class="cl8 hov-cl1 m-t-25">Alamat</h4>
                                <input type="text" class="form-control" readonly value="{{$transaction->address}}" name="address">
                            </div>
                            <div class="form-group">
                                <h4 class="cl8 hov-cl1 m-t-25">Kurir</h4>
                                <input type="text" class="form-control" readonly value="{{$transaction->courier->courier}}" name="courier">
                            </div>
                        </div>
                    </div>

                    @foreach($transaction_detail as $transaction_details)
                    @php
                    $stoks_detail = App\Models\Product_stok_details::where('id', '=', $transaction_details->stok)->first();
                    $stoks = App\Models\Product_stoks::where('id', '=', $stoks_detail->stok_id)->first();
                    @endphp

                    <a href="{{route('detail_product', $transaction_details->product_id)}}">
                    <div class="card mt-5">
                        @php
                        $gambar = App\Models\Product_images::where('product_id', '=', $transaction_details->product_id)->first();
                        @endphp
                        <div class="row g-0">
                            <div class="col-md-3">
                                <img img class="img-fluid rounded-start" src="{{ asset($gambar->image_name) }}"style="height:200px;">
                            </div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <h4 class="card-title">{{$transaction_details->product->product_name}} ({{$stoks->stok_name}})</h4>

                                    <!-- @php
                                        $value = $transaction_details->discount;
                                        $total = $transaction_details->selling_price*((100-$value)/100);
                                    @endphp -->

                                    <div class="form-inline">
                                        <h5 class="card-subtitle mb-2 mt-2 text-muted">Rp. {{$transaction_details->selling_price}},00</h5>
                                    </div>

                                    @if($transaction_details->discount != 0)
                                    <h5 class="card-subtitle mb-2 text-muted">
                                        Diskon&nbsp;&nbsp;:
                                        <span>{{$transaction_details->discount}}% OFF</span>
                                    </h5>
                                    @endif

                                    <div class="text-start">
                                        <div class="form-inline">
                                            <h5 class="card-subtitle mb-2 mt-2 text-muted">Rp. {{$transaction_details->selling_price}},00 X {{$transaction_details->qty}} = Rp, {{$transaction_details->selling_price * $transaction_details->qty}},00</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    </a>
                </div>

                <div class="col-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Transaksi</h4>
                            <div class="row">
                                <div class="col-5">
                                    <h5 class="card-subtitle mb-3 text-muted">Subtotal</h5>
                                    <h5 class="card-subtitle text-muted">Ongkir</h5>
                                </div>
                                <div class="col-7">
                                    <div class="form-inline mb-3">
                                        <h5 class="card-subtitle text-muted">Rp. {{$transaction->subtotal}},00</h5>
                                    </div>
                                    <div class="form-inline">
                                        <h5 class="card-subtitle text-muted">Rp. {{$transaction->shipping_cost}},00</h5>
                                    </div>
                                </div>
                                <div class="progress-container mt-4 mb-4">
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <h5 class="card-subtitle mb-2 text-muted">Total</h5>
                                </div>
                                <div class="col-7">
                                    <div class="form-inline">
                                        <h5 class="card-subtitle mb-2 text-muted">Rp. {{$transaction->total}},00</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <h3 class="text-center m-b-40">{{$transaction->status}}</h3>
                </div>

                 @if($transaction->status == "menunggu bukti pembayaran")
                <div class="row">
                    <div class="progress-container mb-4">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 100%;">
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <h4 class="card-subtitle mb-2 text-muted text-center">Countdown&nbsp;:</h4>
                        <h4 class="mb-2 text-center text-danger" id="demo"></h4>
                    </div>
                </div>

                <form method="post" action="{{route('transaksi-bukti', $transaction->id)}}" enctype="multipart/form-data">
                    @csrf
                    <div class="d-grid">
                        <div class="mb-3">
                            <h4 class="cl8 hov-cl1 m-t-30 text-center">Upload Bukti Pembayaran</h4>
                            <input class="form-control @error('proof_of_payment') is-invalid @enderror" type="file" name="proof_of_payment" required>
                            @error('proof_of_payment')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <row>
                        <button type="submit" class="m-l-15 m-t-40 flex-c-m p-lr-15 m-tb-10 size-119 stext-101 cl2 bg8 bor13 hov-btn3" style="width:200px;">	Upload </button>			
                        </row>
                    </div>
                </form>

                <form method="post" action="{{route('transaksi-batal', $transaction->id)}}" enctype="multipart/form-data">
                    @csrf
                    <row>
                    <button type="submit" class="m-l-15 m-t-20 m-b-40 flex-c-m p-lr-15 m-tb-10 size-119 stext-101 cl2 bor13 hov-btn3" style="width:200px;">	Batal </button>			
                    </row>
                </form>

                @elseif($transaction->status == "barang dalam pengiriman")
                <form method="post" action="{{route('transaksi-konfirmasi', $transaction->id)}}" enctype="multipart/form-data">
                    @csrf
                    <h4 class="cl8 hov-cl1 m-t-30 text-center">Konfirmasi Barang Sampai</h4>
                    <row>
                    <button type="submit" onclick="return confirm('Apa yakin mengkonfirmasi product yg dikirim?')" class="m-l-15 m-t-20 m-b-40 flex-c-m p-lr-15 m-tb-10 size-119 stext-101 cl2 bor13 hov-btn3" style="width:200px;">	Konfirmasi </button>			
                    </row>
                </form>
                @endif
                        
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input id="jam" type="text" value="{{$transaction->timeout}}" hidden>

@php
$jam = $transaction->timeout;
@endphp

<script>
// Set the date we're counting down to
var jam = document.getElementById("jam");
var countDownDate = new Date(jam.value).getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("demo").innerHTML = days + " Days " + hours + " Hours "
  + minutes + " Minutes " + seconds + " Second ";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
</script>
@endsection