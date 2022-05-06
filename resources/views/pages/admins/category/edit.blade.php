@extends('layouts.admin')
@section('title', 'Categories')
@section('page1', 'Categories')
@section('page2', 'Edit Category')

@section('content')   
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="form-signin" action="/admin/categories/{{$category->id}}/update" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <h2>Edit Category</h2>
                                <br>
                                <div class="col-mb-4">
                                    <div class="input-group input-group-static @error('category_name') is-invalid @enderror mb-4">
                                        <label>Category Name :</label>
                                        <input type="text" class="form-control" name="category_name" autofocus value="{{ $category->category_name }}">
                                        @if (count($errors) > 0)                                    
                                            @foreach ($errors->all() as $error)     
                                                <p class="text-danger">{{$error}}</p>
                                            @endforeach                                   
                                        @endif      
                                    </div>                                                      
                                </div>            
                                <button class="btn btn-primary" type="submit">
                                    Edit Category
                                </button>                                                                   
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection