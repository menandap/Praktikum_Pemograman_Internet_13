@extends ('layout')
@section('title', 'Cart')
@section ('body')

<div class="container">
    <div class="bread-crumb flex-w ">
        <a class="stext-109 cl8 hov-cl1 trans-04">
            Cart
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <span class="stext-109 cl4">
            Fill Address
        </span>
    </div>
</div>
<div class="bg0">
    <div class="container">
        <div class="row">
            <div class="col-lg">

            <form class="bg0" method="post" action="{{route('keranjang-checkout')}}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
            <h3 class="card-title m-b-50 flex-c-m">Before Buying Please Fill this Information :</h3>
            <h4 class="card-title">User</h4>
            <div class="size-204 respon6-next">
                <div class="bor8 bg0">              
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan Alamat" required spellcheck="false" style ="height: 45px;display: -moz-box;display: -ms-flexbox;display: flex;align-items: center;border: none;outline: none;background-color: transparent;border-radius: 0px;position: relative; width:100%;box-sizing: border-box;cursor: pointer;display: block;height: 47px;user-select: none;-webkit-user-select: none; padding-left:10px;" value="{{auth()->user()->name}}" readonly>
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                </div>
            </div>
            <h4 class="card-title m-t-25">Provinsi</h4>
            <div class="size-204">
                <div class="rs1-select2 bor8 bg0">
                    <select class="@error('province') is-invalid @enderror" style ="height: 45px;display: -moz-box;display: -ms-flexbox;display: flex;align-items: center;border: none;outline: none;background-color: transparent;border-radius: 0px;position: relative; width:100%;box-sizing: border-box;cursor: pointer;display: block;height: 47px;user-select: none;-webkit-user-select: none; padding-left:10px;" id="provinsi" name="province" required>
                        @foreach($province["rajaongkir"]["results"] as $provinces)
                        <option id="{{$provinces['province_id']}}" value="{{$provinces['province_id']}}|{{$provinces['province']}}">{{$provinces["province"]}}</option>
                        @endforeach
                    </select>
                    <div class="dropDownSelect2"></div>
                    @error('province')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <h4 class="card-title m-t-25">Kabupaten/Kota</h4>
            <div class="size-204 respon6-next">
                <div class="rs1-select2 bor8 bg0">
                    <select class="@error('regency') is-invalid @enderror" style ="height: 45px;display: -moz-box;display: -ms-flexbox;display: flex;align-items: center;border: none;outline: none;background-color: transparent;border-radius: 0px;position: relative; width:100%;box-sizing: border-box;cursor: pointer;display: block;height: 47px;user-select: none;-webkit-user-select: none; padding-left:10px;" id="kota" name="regency" required>
                    <option selected value="">Pilih Kabupaten</option>
                    @foreach($city["rajaongkir"]["results"] as $citys)
                    <option id="{{$citys['province_id']}}" value="{{$citys['city_id']}}|{{$citys['city_name']}}">{{$citys["city_name"]}}</option>
                    @endforeach
                    </select>
                    <div class="dropDownSelect2"></div>
                    @error('regency')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <h4 class="card-title m-t-25">Alamat</h4>
            <div class="size-204 respon6-next">
                <div class="bor8 bg0">              
                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Masukkan Alamat" required spellcheck="false" style ="height: 45px;display: -moz-box;display: -ms-flexbox;display: flex;align-items: center;border: none;outline: none;background-color: transparent;border-radius: 0px;position: relative; width:100%;box-sizing: border-box;cursor: pointer;display: block;height: 47px;user-select: none;-webkit-user-select: none; padding-left:10px;">
                @error('address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                </div>
            </div>

            <h4 class="card-title m-t-25">Kurir</h4>
            <div class="size-204 respon6-next">
                <div class="rs1-select2 bor8 bg0">
                    <select class="@error('courier_id') is-invalid @enderror" style ="height: 45px;display: -moz-box;display: -ms-flexbox;display: flex;align-items: center;border: none;outline: none;background-color: transparent;border-radius: 0px;position: relative; width:100%;box-sizing: border-box;cursor: pointer;display: block;height: 47px;user-select: none;-webkit-user-select: none; padding-left:10px;" id="kurir" name="courier_id" required>
                    <option selected value="">Pilih Kurir</option>
                    @foreach($kurir as $kurirs)
                    <option id="{{$kurirs->courier}}" value="{{$kurirs->id}}">{{$kurirs->courier}}</option>
                    @endforeach
                    </select>
                    <div class="dropDownSelect2"></div>
                    @error('courier_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <row>
            <button type="submit" class="m-t-40 m-b-60 flex-c-m p-lr-15 m-tb-10 size-119 stext-101 cl2 bg8 bor13 hov-btn3" style="width:1010px;">	Next </button>			
            </row>
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

    $('#provinsi').on('click', function() {
        $("#kota option").each(function() {
            if ($(this).attr("id") == $('#provinsi').children(":selected").attr("id")) {
                $(this).show();
                $(this).prop('selected', true);
            } else {
                $(this).hide();
            }
        });
    });
</script>
@endsection