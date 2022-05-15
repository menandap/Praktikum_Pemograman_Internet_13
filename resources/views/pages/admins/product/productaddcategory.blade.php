@extends('layouts.admin')
@section('title', 'Products')
@section('page1', 'Products')
@section('page2', 'Add Product Category')

@section('content')   
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="form-signin" action="/admin/{{ $products->id }}/addCategory" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-6 align-items-center">
                                        <h2 class="mb-0">Add Category</h2>
                                    </div>
                                    <div class="col-6 text-end align-items-center">
                                        <a class="btn bg-gradient-warning mb-0" href="{{ route('admin.productdetail', $products->id) }}"><i class="material-icons text-sm">arrow_back</i>&nbsp;&nbsp;Back</a>
                                    </div>
                                </div>
                                <div class="input-group input-group-static mb-4 pt-5">
                                @php
                                    $value_category = array();
                                    foreach ($data as $datas) {
                                        if(!empty($datas)){
                                            array_push($value_category, $datas->category_name);
                                        }
                                    }

                                    $data = array();
                                    foreach($categories as $category){
                                        array_push($data, $category->category_name);
                                    }
                                    
                                    $result=array_diff($data,$value_category);
                                @endphp

                                
                                @if (count($result) > 0)  
                                <label for="" class="ms-0">Choose Category</label>
                                <select class="form-control" name="category_id">
                                    @foreach($result as $nilai)
                                        <option value="{{$nilai}}">{{$nilai}}</option>   
                                    @endforeach
                                </select>
                                @else
                                <label for="" class="ms-0">All Category Added</label>
                                @endif 

                                </div>                                                                             
                                @if (count($errors) > 0)                                    
                                    @foreach ($errors->all() as $error)     
                                        <p class="text-danger">{{$error}}</p>
                                    @endforeach                                   
                                @endif 
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