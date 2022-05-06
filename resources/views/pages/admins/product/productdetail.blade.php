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
                                    @foreach($categories as $category)
                                        @if(!empty($category))
                                            <a class="btn bg-gradient-primary mb-0">Category : {{$category->category_name}}</a> 
                                            <a onclick="return confirm('Apa yakin ingin menghapus category ini?')" href="/admin/{{$category->id}}/deleteCategory"> <i class="material-icons text-sm">clear</i>&nbsp;&nbsp;</li> </a>                     
                                        @else
                                            <a class="btn bg-gradient-secondary mb-0">No Category</a>
                                        @endif
                                    @endforeach
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
                                        <a class="btn bg-gradient-info mb-0">create</i>&nbsp;&nbsp;Size {{$stok->stok_name}} : {{$stok->stok}}</a>
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
                                        <a class="btn bg-gradient-danger mb-0">Product Discount : {{ $discounts->percentage }}% on {{ $discounts->start }} until {{ $discounts->end }}</a>
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
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-lg font-weight-bolder ps-2">No.</th>
                                            <th class="text-uppercase text-secondary text-lg font-weight-bolder ps-2">Rating</th>
                                            <th class="text-uppercase text-secondary text-lg font-weight-bolder ps-2">Review</th>
                                            <th class="text-uppercase text-secondary text-lg font-weight-bolder ps-2">Response</th>
                                            <th class="text-uppercase text-secondary text-lg font-weight-bolder ps-2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>*****</td>
                                            <td>Mantap</td>
                                            <td>Terima Kasih</td>
                                            <td>                                                                                    
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-sm btn-success lihat-review" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                    Balas
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Response</h5>
                                                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                        <div class="modal-body">                                                        
                                                            <div class="input-group input-group-dynamic">
                                                                <textarea class="form-control" rows="5" placeholder="Say a few words about who you are or what you're working on." spellcheck="false"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn bg-gradient-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>                                            
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

