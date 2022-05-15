@extends('layouts.admin')
@section('title', 'Products')
@section('page1', 'Products')
@section('page2', 'Add Response')

@section('content')   
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="form-signin" action="/admin/{{$id}}/addResponse" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                            <div class="col-lg">
                                </div>
                                <div class="row">
                                    <div class="col-6 align-items-center">
                                        <h2 class="mb-0">Response</h2>
                                    </div>
                                    <div class="col-6 text-end align-items-center">
                                        <a class="btn bg-gradient-warning mb-0" href="{{ route('admin.productdetail', $reviews->product_id) }}"><i class="material-icons text-sm">arrow_back</i>&nbsp;&nbsp;Back</a>
                                    </div>
                                </div>
                                <div class="input-group input-group-static my-3">
                                    <label class="form-control-label">User Name</label>
                                    <input type="text" id="" class="form-control" value="{{$reviews->user->name}}" readonly>
                                </div>
                                <div class="input-group input-group-static my-3">
                                    <label class="form-control-label">Rating</label>
                                    <input type="text" id="" class="form-control" value="{{$reviews->rate}}/5" readonly>
                                </div>
                                <div class="col-lg">
                                    <div class="input-group input-group-static my-3">
                                        <label class="form-control-label">Review</label>
                                        <input type="text" id="" class="form-control" value="{{$reviews->content}}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <div class="input-group input-group-static my-3">
                                        <input type="text" id="" class="form-control"  name="admin_id" value="{{auth()->user()->id}}" hidden>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group input-group-static @error('content') is-invalid @enderror my-3">                                    
                                        <label>Response</label>
                                        <input type="text" class="form-control" placeholder="Write your Response" name="content" value="{{ old('content') }}">
                                    </div>
                                </div>                                                                    
                                @foreach ($errors->all() as $error)     
                                    <p class="text-danger">{{$error}}</p>
                                @endforeach                                   
                                <br>          
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