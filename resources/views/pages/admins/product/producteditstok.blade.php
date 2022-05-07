@extends('layouts.admin')
@section('title', 'Products')
@section('page1', 'Products')
@section('page2', 'Add Product Images')

@section('content')   
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="form-signin" action="/admin/{{ $stoks->id }}/editStok" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-6 align-items-center">
                                        <h2 class="mb-0">Edit Stock</h2>
                                    </div>
                                    <div class="col-6 text-end align-items-center">
                                        <a class="btn bg-gradient-warning mb-0" href="{{ route('admin.productdetail', $stoks->product_id) }}"><i class="material-icons text-sm">arrow_back</i>&nbsp;&nbsp;Back</a>
                                    </div>
                                </div>
                               <div class="col-lg">
                                    <div class="input-group input-group-static my-3">
                                        <label class="form-control-label">Stok Name</label>
                                        <input type="text" id="" class="form-control" value="{{$stoks->stok_name}}" readonly>
                                    </div>
                                </div>

                             
                                <div class="col-lg">
                                    <div class="input-group input-group-static @error('stok') is-invalid @enderror my-3">                                    
                                        <label>Stok </label>
                                        <input type="text" class="form-control" placeholder="Banyak Satuan" name="stok" value="{{ $stoks->stok }}">
                                    </div>
                                </div>                                                                          
                                @if (count($errors) > 0)                                    
                                    @foreach ($errors->all() as $error)     
                                        <p class="text-danger">{{$error}}</p>
                                    @endforeach                                   
                                @endif 
                                <br>          
                                <div>
                                    <button class="btn btn-primary" type="submit">
                                        Submit
                                    </button>                                                                   
                                </div>                          
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 