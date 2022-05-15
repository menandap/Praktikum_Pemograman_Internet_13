@extends('layouts.admin')
@section('title', 'Products')
@section('page1', 'Products')
@section('page2', 'Add Stok')

@section('content')   
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="form-signin" action="/admin/{{ $products->id }}/addStok" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-6 align-items-center">
                                        <h2 class="mb-0">Add Stock</h2>
                                    </div>
                                    <div class="col-6 text-end align-items-center">
                                        <a class="btn bg-gradient-warning mb-0" href="{{ route('admin.productdetail', $products->id) }}"><i class="material-icons text-sm">arrow_back</i>&nbsp;&nbsp;Back</a>
                                    </div>
                                </div>
                                @php
                                    $value_stok = array();
                                    foreach ($data as $datas) {
                                        if(!empty($datas)){
                                            array_push($value_stok, $datas->stok_name);
                                        }
                                    }

                                    $cek = array();
                                    foreach($stoks as $stok){
                                        array_push($cek, $stok->stok_name);
                                    }
                                    
                                    $result=array_diff($cek,$value_stok);
                                @endphp
                                    
                                @if (count($result) > 0)  
                                <label for="" class="ms-0">Choose Stok Name</label>
                                <select class="form-control" name="stok_id">
                                    @foreach($result as $nilai)
                                        <option value="{{$nilai}}">{{$nilai}}</option>   
                                    @endforeach
                                </select>

                                <div class="col">
                                    <div class="input-group input-group-static @error('stok') is-invalid @enderror my-3">                                    
                                        <label>Stock :</label>
                                        <input type="text" class="form-control" placeholder="Banyak Stok" name="stok" value="{{ old('stok') }}">
                                    </div>
                                </div>    
                                @else
                                <label for="" class="ms-0 mt-4">All Stok Added</label>
                                @endif 

                                <!-- <div class="input-group input-group-static mb-4 pt-5">
                                    <label for="" class="ms-0">Choose Stock :</label>
                                    <select class="form-control" name="stok_id[]">
                                        @foreach($stoks as $stok)
                                            <option value="{{$stok->id}}">{{$stok->stok_name}}</option>
                                        @endforeach
                                    </select>  
                                </div> -->
                                                                       
                                @if (count($errors) > 0)                                    
                                    @foreach ($errors->all() as $error)     
                                        <p class="text-danger">{{$error}}</p>
                                    @endforeach                                   
                                @endif 
                                <br>          
                                <br>
                                @if (count($result) > 0)  
                                <div>
                                    <button class="btn btn-primary" type="submit">
                                        Submit
                                    </button>                                                                   
                                </div> 
                                @endif                               
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 