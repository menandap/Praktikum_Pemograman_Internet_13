@extends('layout')

@section('title', 'All Transaction')

@section('body')
 <!-- breadcrumb -->
 <div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-lr-0-lg">
			<a class="stext-109 cl8 hov-cl1 trans-04">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				Transaction
			</span>
		</div>
	</div>
<div class="container">
    <div class="row m-t-40">
        <div class="col-lg col-xl m-lr-auto m-b-50" style="width:600px;">
            <div class="m-l-25 m-r--38 m-lr-0-xl">
                @php

                $user_id = auth()->user()->id;
                $cek = App\Models\Transactions::where('user_id', '=', $user_id)->count();								

                @endphp
                @if($cek != 0)
                @foreach($transaction as $transactions)
                <a href="{{route('transaksi-detail', $transactions->id)}}">
                    <div class="card">
                        <div class="card-body">
                            @php
                            $jam = $transactions->timeout;
                            @endphp
                            <input id="jam" type="text" value="{{$transactions->timeout}}" hidden>
                            <h3 class="stext-400 cl3 text-center">Transaction Status :{{$transactions->status}}</h4>
                            @if($transactions->status == "menunggu bukti pembayaran")
                            <h4 class="text-center text-danger mt-4" id="demo"></h4>
                            @endif
                            <h3 class="stext-200 mb-5 mt-2 text-muted text-center m-t-30">Tanggal&nbsp;:&nbsp;{{$transactions->created_at->format('Y-m-d')}}</h6>
                            <h3 class="stext-200 mb-2 text-muted text-center">Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;Rp.{{$transactions->total}}</h6>
                        </div>
                    </div>
                </a>
                @endforeach
                @else
                    <h4 class="mtext-105 cl2 js-name-detail p-b-14 text-center m-t-100 m-b-100">You Have No Transaction</h4>								
                @endif
            </div>
        </div>				
    </div>
</div>

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
