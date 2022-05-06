@extends('layouts.admin')
@section('title', 'Couriers')
@section('page1', 'Couriers')
@section('page2', 'Add Courier')

@section('content')   
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="form-signin" action="/admin/couriers/store" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <h2>Add Courier</h2>
                                <br>
                                <div class="col-mb-4">
                                    <div class="input-group input-group-static @error('category_name') is-invalid @enderror mb-4">
                                        <label>Courier Name :</label>
                                        <input type="text" class="form-control" name="courier" autofocus value="{{ old('courier') }}">
                                        @if (count($errors) > 0)                                    
                                            @foreach ($errors->all() as $error)     
                                                <p class="text-danger">{{$error}}</p>
                                            @endforeach                                   
                                        @endif      
                                    </div>                                                      
                                </div>                  
                                <div>
                                    <button class="btn btn-primary" type="submit">
                                        Add Courier
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