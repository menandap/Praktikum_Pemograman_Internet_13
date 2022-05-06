@extends('layouts.admin')
@section('title', 'Discounts')
@section('page1', 'Discounts')
@section('page2', 'Discount List')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="table">
                            <h2>List Discounts</h2>
                            <br>
                            <button type="button" class="btn bg-gradient-success">
                                <a href="products/create">Discount List</a>
                            </button>                            
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Percentage</th>
                                        <th>Start</th>
                                        <th>End</th>
                                        <th colspan="2">Action</th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($discounts as $discount)   
                                    @foreach($valid as $val)                                                                    
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $val->percentage }}%</td>
                                        <td>{{ date('Y-m-d', strtotime($val->start)) }}</td>
                                        <td>{{ date('Y-m-d', strtotime($val->end)) }}</td>
                                        <td style="align: center;">                                            
                                            <a href="discounts/edit/{{$val->id}}" class="btn bg-gradient-warning">Edit</a>
                                            <a href="/admin/discounts/delete/{{$val->id}}" class="btn bg-gradient-danger" onclick="return confirm('Apa yakin ingin menghapus data ini?')">Delete</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <td colspan="5">Tidak Ada Diskon!</td>
                                    @endforelse
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection