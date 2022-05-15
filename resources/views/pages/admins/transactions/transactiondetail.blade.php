@extends('layouts.admin')
@section('title', 'Products')
@section('page1', 'Products')
@section('page2', 'Transactions Detail')

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible text-white" role="alert">
            <span class="text-sm">{{ $message }}</span>
            <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible text-white" role="alert">
            <span class="text-sm">{{ $message }}</span>
            <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-9">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Transaksi Detail</h4>
                            <h7 class="card-title">User : {{$transaction->user->name}} (Tgl Transaksi : {{$transaction->created_at}})</h4>
                            <div class="input-group input-group-static my-3">
                                <label>Provinsi</label>
                                <input type="text" class="form-control" readonly value="{{$transaction->province}}" name="province">
                            </div>
                            <div class="input-group input-group-static my-3">
                                <label>Kota</label>
                                <input type="text" class="form-control" readonly value="{{$transaction->regency}}" name="regency">
                            </div>
                            <div class="input-group input-group-static my-3">
                                <label>Alamat</label>
                                <input type="text" class="form-control" readonly value="{{$transaction->address}}" name="address">
                            </div>
                            <div class="input-group input-group-static my-3">
                                <label>Kurir</label>
                                <input type="text" class="form-control" readonly value="{{$transaction->courier->courier}}" name="courier">
                            </div>
                        </div>
                    </div>


                    @foreach($transaction_detail as $transaction_details)
                    <div class="card mt-3">
                        @php
                        $gambar = App\Models\Product_images::where('product_id', '=', $transaction_details->product_id)->first();
                        @endphp
                        <div class="row g-0">
                            <div class="col-md-3">
                                <img img class="img-fluid rounded-start" src="{{ asset($gambar->image_name) }}"style="height:200px;">
                            </div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <h4 class="card-title">{{$transaction_details->product->product_name}}</h4>

                                    <!-- @php
                                        $value = $transaction_details->discount;
                                        $total = $transaction_details->selling_price*((100-$value)/100);
                                    @endphp -->

                                    <div class="form-inline">
                                        <h5 class="card-subtitle mb-2 mt-2 text-muted">Rp. {{$transaction_details->selling_price}},00</h5>
                                    </div>

                                    @if($transaction_details->discount != 0)
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        Diskon&nbsp;&nbsp;:
                                        <span>{{$transaction_details->discount}}% OFF</span>
                                    </h6>
                                    @endif

                                    <div class="text-start">
                                        <div class="form-inline">
                                            <h6 class="card-subtitle mb-2 mt-2 text-muted">Rp. {{$transaction_details->selling_price}},00 X {{$transaction_details->qty}} = Rp, {{$transaction_details->selling_price * $transaction_details->qty}},00</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="col-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Transaksi</h4>
                            <div class="row">
                                <div class="col-5">
                                    <h6 class="card-subtitle mb-3 text-muted">Subtotal</h6>
                                    <h6 class="card-subtitle text-muted">Ongkir</h6>
                                </div>
                                <div class="col-7">
                                    <div class="form-inline mb-3">
                                        <h6 class="card-subtitle text-muted">Rp. {{$transaction->subtotal}},00</h6>
                                    </div>
                                    <div class="form-inline">
                                        <h6 class="card-subtitle text-muted">Rp. {{$transaction->shipping_cost}},00</h6>
                                    </div>
                                </div>
                                <div class="progress-container mt-4 mb-4">
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <h6 class="card-subtitle mb-2 text-muted">Total</h6>
                                </div>
                                <div class="col-7">
                                    <div class="form-inline">
                                        <h6 class="card-subtitle mb-2 text-muted">Rp. {{$transaction->total}},00</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <h4 class="text-center">{{$transaction->status}}</h4>
                            </div>

                            @if($transaction->status == "menunggu bukti pembayaran")
                            <div class="row">
                                <div class="progress-container mb-4">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 100%;">
                                        </div>
                                    </div>
                                </div>
                                <h6 class="card-subtitle mb-2 text-muted text-center">Countdown&nbsp;:</h6>
                                <!-- <h7 class="mb-2 text-center">{{$interval}}</h7> -->
                                <h6 class="mb-2 text-center text-danger" id="demo"></h6>
                            </div>
                            @elseif($transaction->status == "sudah terverifikasi" || $transaction->status == "menunggu verifikasi" || $transaction->status == "barang dalam pengiriman")
                            <div class="progress-container mb-4">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 100%;">
                                    </div>
                                </div>
                            </div>
                            <form class="d-grid" method="post" action="{{route('admin.adm-transaksi-status', $transaction->id)}}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Ubah Status</label>
                                    <select class="form-control" name="status" required>
                                        <option selected value="">Pilih Status</option>
                                        <option value="sudah terverifikasi">Sudah Terverifikasi</option>
                                        <option value="transaksi dibatalkan">Transaksi Dibatalkan</option>
                                        <option value="barang dalam pengiriman">Barang Dalam Pengiriman</option>
                                        <option value="barang telah sampai di tujuan">Barang Telah Sampai Di Tujuan</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                            <div class="progress-container mb-4">
                                <div class="progress">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;">
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid">
                                <a type="button" class="btn btn-info text-white" href="{{route('admin.adm-transaksi-bukti', $transaction->id)}}">Lihat Bukti Pembayaran</a>
                                <a href="{{url('proof_of_payment/'. $transaction->proof_of_payment)}}" type="button" class="btn btn-outline-primary" download>Unduh Bukti Pembayaran</a>
                            </div>
                            @endif
                        
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