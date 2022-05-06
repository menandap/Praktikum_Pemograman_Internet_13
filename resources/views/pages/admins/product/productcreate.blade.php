@extends('layouts.admin')
@section('title', 'Products')
@section('page1', 'Products')
@section('page2', 'Add Product')

@section('content')   
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="form-signin" action="/admin/products/store" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-6 align-items-center">
                                        <h2 class="mb-0">Add Product</h2>
                                    </div>
                                    <div class="col-6 text-end align-items-center">
                                        <a class="btn bg-gradient-warning mb-0" href="/admin/products"><i class="material-icons text-sm">arrow_back</i>&nbsp;&nbsp;Back</a>
                                    </div>
                                </div>
                                <br><br>
                                <div class="col-mb-4">
                                    <div class="input-group input-group-static @error('product_name') is-invalid @enderror mb-4">
                                        <label>Nama Produk :</label>
                                        <input type="text" class="form-control" placeholder="Nama Produk" name="product_name" autofocus value="{{ old('product_name') }}">    
                                    </div>                                                      
                                </div>                                                                                
                                <div class="col-mb-4">
                                    <div class="input-group input-group-static @error('price') is-invalid @enderror my-3">                                    
                                        <label>Harga Satuan :</label>
                                        <input type="text" class="form-control" placeholder="Harga Satuan" name="price" value="{{ old('price') }}">
                                    </div>
                                </div>                                                              
                                <div class="col-mb-4">
                                    <div class="input-group input-group-static @error('weight') is-invalid @enderror my-3">                                    
                                        <label>Berat Produk :</label>
                                        <input type="text" class="form-control" placeholder="Berat Produk" name="weight" value="{{ old('weight') }}">
                                    </div>
                                </div>                                 
                                <div class="input-group input-group-static mb-4">
                                    <label for="" class="ms-0">Kategori :</label>
                                    <select class="form-control" name="category_id[]">
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>
                                <label class="ms-0"for="">Deskripsi :</label>                                
                                <div class="input-group input-group-dynamic">                                    
                                    <textarea class="form-control" rows="5" placeholder="Deskripsi" name="description">{{ old('description') }}</textarea>
                                </div> 
                                <br>                                             
                                <div class="input-group mb-4">
                                    <label for="">Pilih Foto :</label>
                                    <div class="input-group input-group-outline @error('files[]') is-invalid @enderror my-3">                                    
                                        <input type="file" class="form-control" placeholder="" name="files[]" multiple>
                                    </div>
                                </div>
                                @if (count($errors) > 0)                                    
                                    @foreach ($errors->all() as $error)     
                                        <p class="text-danger">{{$error}}</p>
                                    @endforeach                                   
                                @endif                                
                                <div>
                                    <button class="btn btn-primary" type="submit">
                                        Add Product
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