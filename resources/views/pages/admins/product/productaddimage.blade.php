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
                        <form class="form-signin" action="/admin/{{ $products->id }}/addImage" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-6 align-items-center">
                                        <h2 class="mb-0">Add Image</h2>
                                    </div>
                                    <div class="col-6 text-end align-items-center">
                                        <a class="btn bg-gradient-warning mb-0" href="{{ route('admin.productdetail', $products->id) }}"><i class="material-icons text-sm">arrow_back</i>&nbsp;&nbsp;Back</a>
                                    </div>
                                </div>
                                <br>
                                <label>Pilih Foto :</label>
                                <div class="col-mb-4">
                                    <div class="input-group input-group-outline my-3">                                    
                                        <input type="file" class="form-control" placeholder="" name="files[]" multiple>
                                    </div>                                                                                  
                                </div>        
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