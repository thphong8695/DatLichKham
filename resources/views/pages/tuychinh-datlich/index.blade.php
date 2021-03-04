@extends('pages.layouts.default')
@section('content') 

<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title"><a href="{{ route('tuychinh-datlich.index') }}">Dữ liệu tùy chỉnh form đặt lịch</a></h4>
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Tables</li>
        </ol>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        {{-- <div class="btn-group mb-0">
                <a type="button" href="{{ route('tuychinh-datlich.create') }}" class="btn btn-success"><i class="fa fa-plus mr-2"></i>Tạo mới</a>
        </div> --}}
    </div>
</div>
<!--End Page header-->

<div class="row">
    <div class="col-md-12">  
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Bệnh viện</th>
                            @can('DlBv106x-delete')<th width="150px">ACTION</th>@endcan
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($tuychinhdatlich as $value)
                        <tr>
                            <td>{{ $value->BenhVienPK->name }}</td>
                            @can('DlBv106x-delete')
                            <td>
                                <a class="btn btn-primary" href="{{ route('tuychinh-datlich.edit',$value->id) }}">Edit</a>
                            </td>
                            @endcan
                        </tr>
                       @endforeach
                    </tbody>
                </table>
                
                </div>
            </div>
            
        </div>
    <!-- section-wrapper -->

    </div>
</div>
<!-- Modal -->

@endsection
@section('script')


@endsection
