@extends('layouts.admin')
@section('title', 'Couriers')
@section('page1', 'Couriers')
@section('page2', 'Courier List')            

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible text-white" role="alert">
            <span class="text-sm">{{ $message }}</span>
            <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible text-white" role="alert">
            <span class="text-sm">{{ $message }}</span>
            <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif            
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="table">
                            <div class="row">
                                <div class="col-6 align-items-center">
                                    <h2 class="mb-0">Courier List</h2>
                                </div>
                                <div class="col-6 text-end align-items-center">
                                    <a class="btn bg-gradient-success mb-0" href="/admin/couriers/create"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add Courier</a>
                                </div>
                            </div>
                            <br>                    
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-lg font-weight-bolder ps-2">No.</th>
                                            <th class="text-uppercase text-secondary text-lg font-weight-bolder ps-2">Nama Kurir</th>
                                            <th colspan="2" class="text-uppercase text-secondary text-lg font-weight-bolder ps-2">Action</th>            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($couriers as $courier)
                                        <tr>
                                            <td><p class="text-md font-weight-normal mb-0">{{ $couriers->firstItem()+$loop->index }}</p></th>                
                                            <td><p class="text-md font-weight-normal mb-0">{{ $courier->courier }}</p></td>
                                            <td class="align-middle text-center">
                                                <div class="d-flex align-items-center">
                                                    <a href="/admin/couriers/{{$courier->id}}/edit" class="m-1 btn bg-gradient-warning"><i class="material-icons text-sm me-2">edit</i>Edit</a>
                                                    <a href="/admin/couriers/{{$courier->id}}/delete" class="m-1 btn bg-gradient-danger" onclick="return confirm('Apa yakin ingin menghapus data ini?')"><i class="material-icons text-sm me-2">delete</i>Delete</a>
                                                </div>
                                            </td>                
                                        </tr>
                                        @endforeach      
                                    </tbody>
                                </table>
                            </div>
                            {{ $couriers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection                            