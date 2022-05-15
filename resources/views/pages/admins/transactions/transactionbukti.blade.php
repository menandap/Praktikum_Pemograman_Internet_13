@extends('layouts.admin')
@section('title', 'Transactions')
@section('page1', 'Transactions')
@section('page2', 'Proof of Transactions')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6 align-items-center">
                                <h2 class="mb-0">Bukti Transaksi</h2>
                            </div>
                            <div class="col-6 text-end align-items-center">
                                <a class="btn bg-gradient-warning mb-0" href="{{ route('admin.adm-transaksi-detail', $transaction->id) }}"><i class="material-icons text-sm">arrow_back</i>&nbsp;&nbsp;Back</a>
                            </div>
                        </div>
                        <div class="progress-container mb-4">
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;">
                                </div>
                            </div>
                        </div>
                        <img class="card-img-top" src="{{url('proof_of_payment/'. $transaction->proof_of_payment)}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection                            