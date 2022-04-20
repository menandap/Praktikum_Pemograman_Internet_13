@extends('admin.layouts.app')

@section('title', 'Dummy')

@section('content')

<div class="card-header">
    <div class="row align-items-center">
        <div class="col-8">
            <h3 class="mb-0">Dummy</h3>
        </div>
        <div class="col-4 text-right">
            <a type="button" href="" class="btn btn-sm btn-success text-white">Tambah</a>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="table-responsive">
        <div>
            <table class="table align-items-center">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="sort" data-sort="id">No</th>
                        <th scope="col" class="sort" data-sort="daftar">Tes 1</th>
                        <th scope="col" class="sort" data-sort="daftar">Tes 2</th>
                        <th scope="col" class="sort" data-sort="daftar">Tes 3</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="list">


                    <tr>
                     
                        <td class="text-start">
                           dummy
                        </td>

                        <td class="text-start">
                            dummy
                        </td>

                        <td class="text-start">
                           dummy
                        </td>

                        <td class="text-start">
                           dummy
                        </td>


                        <td class="text-right">
                            <div class="dropdown">
                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a type="button" class="dropdown-item" href="">Detail</a>
                                    <a type="button" class="dropdown-item" href="">Ubah</a>
                                    <form action="" method="post">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>

        </div>

    </div>
    @if ($message = Session::get('danger'))
        <hr class="my-4" />
        <div class="alert alert-danger mt-3" role="alert">
            <strong>{{$message}}</strong>
        </div>
    @endif
    @if ($message = Session::get('success'))
    <hr class="my-4" />
    <div class="alert alert-success mt-3" role="alert">
        <strong>{{$message}}</strong>
    </div>
    @endif
</div>

@endsection