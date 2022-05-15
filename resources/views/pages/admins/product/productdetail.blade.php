@extends('layouts.admin')
@section('title', 'Products')
@section('page1', 'Products')
@section('page2', 'Detail Product')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="table">
                            <div class="row">
                                @foreach($products as $product)
                                <div class="col-6 align-items-center">
                                    <h2 class="mb-0">Detail Product</h2>
                                </div>
                                <div class="col-6 text-end align-items-center">
                                    <a class="btn bg-gradient-warning mb-0" href="/admin/products"><i class="material-icons text-sm">arrow_back</i>&nbsp;&nbsp;Back</a>
                                </div>
                            </div>
                            <br>  

                            <div class="row">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Nama Produk</label>
                                            <input type="text" id="" class="form-control" value="{{ $product->product_name }}" disabled readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Berat</label>
                                            <input type="text" id="" class="form-control" value="{{ $product->weight }} kg" disabled readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Harga</label>
                                            @php
                                            $value = 0;

                                            foreach ($discount as $discounts) {
                                                if($product->id == $discounts->product_id){
                                                    $value = $discounts->percentage;
                                                    break;
                                                }
                                            }

                                            $total = $product->price*((100-$value)/100);
                                            @endphp
                                            <input type="text" id="" class="form-control" value="Rp. {{ $total }},00" disabled readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Rating Produk</label>
                                            <input type="text" id="" class="form-control" value="{{ $product->product_rate }}" disabled readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label class="form-control-label">Deskripsi</label>
                                            <input type="text" id="" class="form-control" value="{{ $product->description }}" disabled readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach                                                            
                        </div><br><br>

                        <div class="table">
                            <div class="row">
                                <div class="col-6 align-items-center">
                                        <h2 class="mb-0">Product Category</h2>
                                </div>
                                <div class="col-6 text-end align-items-center">
                                    <a class="btn bg-gradient-success mb-0" href="/admin/{{$product->id}}/addCategory"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add Category</a>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="pt-3">
                                    <div class="col">
                                    @php

                                    $data = array();
                                    foreach($categories as $category){
                                        array_push($data, $category->category_name);
                                    }

                                    @endphp
                                    @if(count($data) < 2)
                                    <a class="btn bg-gradient-primary mb-0">Category : {{$category->category_name}}</a> 
                                    @else
                                    @foreach($categories as $category)
                                        @if(!empty($category))
                                            <a class="btn bg-gradient-primary mb-0">Category : {{$category->category_name}}</a> 
                                            <a onclick="return confirm('Apa yakin ingin menghapus category ini?')" href="/admin/{{$category->id}}/deleteCategory"> <i class="material-icons text-sm">clear</i>&nbsp;&nbsp;</li> </a>                     
                                        @else
                                            <a class="btn bg-gradient-secondary mb-0">No Category</a>
                                        @endif
                                    @endforeach
                                    @endif
                                    </div>
                                </div>                            
                            </div>
                        </div><br><br>

                        <div class="table">
                            <div class="row">
                                <div class="col-6 align-items-center">
                                        <h2 class="mb-0">Product Stock</h2>
                                </div>

                                <div class="col-6 text-end align-items-center">
                                    <a class="btn bg-gradient-success mb-0" href="/admin/{{$product->id}}/addStok"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add Stock</a>
                                </div>    
                            </div>
                            <br>
                            <div class="row">
                                <div class="pt-3">
                                    <div class="col">
                                    @forelse($stoks as $stok)
                                        <a class="btn bg-gradient-info mb-0" href="/admin/{{$stok->id}}/editStok"><i class="material-icons text-sm">create</i>&nbsp;&nbsp;Size {{$stok->stok_name}} : {{$stok->stok}}</a>
                                        <a onclick="return confirm('Apa yakin ingin menghapus stok ini?')" href="/admin/{{$stok->id}}/deleteStok"> <i class="material-icons text-sm">clear</i>&nbsp;&nbsp;</li> </a>                  
                                    @empty
                                            <a class="btn bg-gradient-secondary mb-0">No Stock</a>
                                    @endforelse  
                                    </div>
                                </div>                            
                            </div>
                        </div><br><br>

                        <div class="table">
                            <div class="row">
                                <div class="col-6 align-items-center">
                                        <h2 class="mb-0">Product Discount</h2>
                                </div>

                                @php
                                    $notif = 0;

                                    foreach ($discount as $discounts) {
                                        if($product->id == $discounts->product_id){
                                            $notif = 1;
                                        }
                                    }
                                @endphp

                                @if($notif==0)
                                <div class="col-6 text-end align-items-center">
                                    <a class="btn bg-gradient-success mb-0" href="/admin/{{$product->id}}/addDiscount"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add Discount</a>
                                </div>    
                                @else
                                <div class="col-6 text-end align-items-center">
                                    <a class="btn bg-gradient-success mb-0" onclick="return confirm('Hapus Diskon Terlebih Dahulu!!!')"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add Discount</a>
                                </div>
                                @endif

                            </div>
                            <br>
                            <div class="row">
                            <div class="pt-3">
                                 @foreach($discount as $discounts)                            
                                    @if($product->id == $discounts->product_id)
                                    <div class="col">
                                        <a class="btn bg-gradient-danger mb-0" href="/admin/{{$product->id}}/editDiscount"><i class="material-icons text-sm">create</i>&nbsp;&nbsp;Product Discount : {{ $discounts->percentage }}% on {{ $discounts->start }} until {{ $discounts->end }}</a>
                                    <a onclick="return confirm('Apa yakin ingin menghapus diskon ini?')" href="/admin/{{$discounts->id}}/deleteDiscount"> <i class="material-icons text-sm">clear</i>&nbsp;&nbsp;</li> </a>                  
                                    </div>
                                    @php
                                        $value = 1;
                                    @endphp
                                    @endif
                                @endforeach                          
                                @if($value != 1)
                                <div class="col-6">
                                    <a class="btn bg-gradient-secondary mb-0">No Discount in Product</a>
                                </div>
                                @endif
                            </div>                            
                            </div>
                        </div><br><br>
                    
                        <div class="table">
                            <div class="row">
                                <div class="col-6 align-items-center">
                                        <h2 class="mb-0">Product Images</h2>
                                </div>
                                <div class="col-6 text-end align-items-center">
                                    <a class="btn bg-gradient-success mb-0" href="/admin/{{$product->id}}/addImage"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add Image</a>
                                </div>
                            </div>
                            <br>
                            <div class="row pt-2">                                
                                @forelse($image as $images)         
                                    <div class="col-md-2">                                        
                                        <div class="thumbnail">
                                            <img class="img-fluid-left img-thumbnail" src="{{ asset($images->image_name) }}" alt="light" style="width:200px; height:200px;">                                                                
                                        </div>
                                        <div class="pl-2">
                                            <a href="/admin/{{$images->id}}/deleteImage" class="btn bg-gradient-danger" onclick="return confirm('Apa yakin ingin menghapus gambar ini?')">Hapus</a>
                                        </div>
                                    </div>		                                                                                     
                                @empty
                                <div class="col-6 align-items-center">
                                    <h3 class="mb-0">Tidak Ada Foto</h3>
                                </div>
                                @endforelse                                
                            </div>
                        </div><br><br>
                                            
                        <div class="table">
                        <div class="row">
                                <div class="col-6 align-items-center">
                                        <h2 class="mb-0">Product Reviews</h2>
                                </div>                                
                            </div>
                            <br>
                            <div class="table-responsive"> 
                                @php 
                                $check=0;

                                foreach($reviews as $review){
                                    $check=1;
                                }

                                @endphp


                                @if($check != 1)
                                <div class="col-6 mt-4 mb-3">
                                    <a class="btn bg-gradient-secondary mb-0">No Review Added in Product</a>
                                </div>
                                @else    
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-lg font-weight-bolder ps-2">No.</th>
                                            <th class="text-uppercase text-secondary text-lg font-weight-bolder ps-2">User</th>
                                            <th class="text-uppercase text-secondary text-lg font-weight-bolder ps-2">Rating</th>
                                            <th class="text-uppercase text-secondary text-lg font-weight-bolder ps-2">Review</th>
                                            <th class="text-uppercase text-secondary text-lg font-weight-bolder ps-2">Response</th>
                                            <th class="text-uppercase text-secondary text-lg font-weight-bolder ps-2">By Admin</th>
                                            <th class="text-uppercase text-secondary text-lg font-weight-bolder ps-2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reviews as $review)  
                                        <tr>
                                            <td><p class="text-md font-weight-normal mb-0">{{ $reviews->firstItem()+$loop->index }}</p></th>
                                            <td>{{$review->user->name}}</td>
                                            <td>{{$review->rate}}/5</td>
                                            <td>{{$review->content}}</td>
                                            @php
                                            $respon = App\Models\Responses::where('review_id', '=', $review->id)->first();
                                            @endphp
                                            @if(!empty($respon))
                                            <td>{{$respon->content}}</td>
                                            <td>{{$respon->admin->name}}</td>
                                            @else
                                            <td></td>
                                            <td></td>
                                            @endif
                                            <td>      

                                            @if(!empty($respon))
                                            <a class="btn bg-gradient-secondary mb-0">Response Added</a>
                                            @else
                                            <a class="btn bg-gradient-success mb-0" href="/admin/{{$review->id}}/addResponse"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add Response</a>
                                            @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

