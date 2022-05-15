@extends('layouts.admin')
@section('title', 'Transactions')
@section('page1', 'Transactions')
@section('page2', 'Transactions List')

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
                                    <h2 class="mb-0">Transactions List</h2>
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive">  
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-lg font-weight-bolder ps-2">No.</th>
                                            <th class="text-uppercase text-secondary text-lg font-weight-bolder ps-2">Nama User</th>
                                            <th class="text-uppercase text-secondary text-lg font-weight-bolder ps-2">Status</th>
                                            <th class="text-uppercase text-secondary text-lg font-weight-bolder ps-2">Tanggal</th>
                                            <th class="text-uppercase text-secondary text-lg font-weight-bolder ps-2">Total</th>
                                            <th colspan="3" class="text-uppercase text-secondary text-lg font-weight-bolder ps-2">Action</th>            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transaction as $transactions)
                                        <tr>
                                            <td><p class="text-md font-weight-normal mb-0"> {{$loop->index+1+($transaction->currentPage()-1)*10}}</p></th>                
                                            <td><p class="text-md font-weight-normal mb-0">{{$transactions->user->name}}</p></td>
                                            <td><p class="text-md font-weight-normal mb-0">{{$transactions->status}}</p></td>
                                            <td><p class="text-md font-weight-normal mb-0">{{$transactions->created_at}}</p></td>
                                            <td><p class="text-md font-weight-normal mb-0">Rp. {{$transactions->total}},00</p></td>                                                                                                                                                                       
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="d-flex align-items-center">
                                                    <a href="{{route('admin.adm-transaksi-detail', $transactions->id)}}" class="m-1 btn bg-gradient-info"><i class="material-icons text-sm me-2">visibility</i>Detail</a>
                                                </div>
                                            </td>                
                                        </tr>
                                        @endforeach      
                                    </tbody>
                                </table>
                            </div>
                            {{ $transaction->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection                            