@extends('layouts.admin')
@section('title', 'Products')
@section('page1', 'Products')
@section('page2', 'Edit Product')

@section('content')   
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="form-signin" action="/admin/products/{{$products->id}}/update" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header"> 
                                <div class="row">
                                    <div class="col-6 align-items-center">
                                        <h2 class="mb-0">Edit Product</h2>
                                    </div>
                                    <div class="col-6 text-end align-items-center">
                                        <a class="btn bg-gradient-warning mb-0" href="/admin/products"><i class="material-icons text-sm">arrow_back</i>&nbsp;&nbsp;Back</a>
                                    </div>
                                </div>
                                <br><br>
                                <div class="col-mb-4">
                                    <div class="input-group input-group-static @error('product_name') is-invalid @enderror mb-4">
                                        <label>Nama Produk :</label>
                                        <input type="text" class="form-control" placeholder="Nama Produk" name="product_name" autofocus value="{{ $products->product_name }}">    
                                    </div>                                                      
                                </div>                                                                                
                                <div class="col-mb-4">
                                    <div class="input-group input-group-static @error('price') is-invalid @enderror my-3">                                    
                                        <label>Harga Satuan :</label>
                                        <input type="text" class="form-control" placeholder="Harga Satuan" name="price" value="{{ $products->price }}">
                                    </div>
                                </div>                                                             
                                <div class="col-mb-4">
                                    <div class="input-group input-group-static @error('weight') is-invalid @enderror my-3">                                    
                                        <label>Berat Produk :</label>
                                        <input type="text" class="form-control" placeholder="Berat Produk" name="weight" value="{{ $products->weight }}">
                                    </div>
                                </div>                                 
                                <label class="ms-0"for="">Deskripsi :</label>                                
                                <div class="input-group input-group-dynamic">                                    
                                    <textarea class="form-control" rows="5" placeholder="Deskripsi" name="description">{{$products->description}}</textarea>
                                </div> 
                                <br>
                                <div>
                                    <button class="btn btn-primary" type="submit">
                                        Edit Product
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