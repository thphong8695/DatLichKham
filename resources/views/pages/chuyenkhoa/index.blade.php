@extends('pages.layouts.default')
@section('content') 

<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title"><a href="{{ route('chuyen-khoa.index') }}">Dữ liệu chuyên khoa</a></h4>
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Tables</li>
        </ol>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <div class="btn-group mb-0">
                <a type="button" href="{{ route('chuyen-khoa.create') }}" class="btn btn-success"><i class="fa fa-plus mr-2"></i>Tạo mới</a>
              
        </div>
       
    </div>
</div>
<!--End Page header-->

<div class="row">
    <div class="col-md-12">  
        <div class="card">
            {!! Form::open(array('route' => 'chuyen-khoa.index','method'=>'get')) !!}
            <div class="card-header">
                <div class="row">
                    <div class="col-md-12 d-flex">
                        <div class="form-group d-flex">
                            <strong>Bệnh viện:</span></strong>
                            {!! Form::select('bv',$benhvien,app('request')->input('bv'),['class'=>'form-control ','id'=>'bv','placeholder'=>'Chọn bệnh viện','required']) !!}
                            {{-- <select name="bv" class="form-control" required="">
                                <option value="">Chọn bệnh viện</option>
                                @foreach($benhvien as $value)
                                    <option value="{{ $value->slug }}" {{app('request')->input('bv') == $value->slug ? 'selected' : '' }}>{{ $value->name }}</option>
                                @endforeach
                            </select> --}}
                            @error('bv')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group ">
                            <button type="submit" class="btn btn-success ml-2">Search</button>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
            <div class="card-body">
                <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th> TÊN CHUYÊN KHOA </th>
                            <th> SLUG </th>
                            <th>Bệnh viện</th>
                            @can('DlBv106x-delete')<th width="150px">ACTION</th>@endcan
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($chuyenkhoa as $value)
                        <tr>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->slug }}</td>
                            <td>{{ $value->BenhVienPK->name }}</td>
                            @can('DlBv106x-delete')
                            <td>
                                <a class="btn btn-primary" href="{{ route('chuyen-khoa.edit',$value->id) }}">Edit</a>
                                {!! Form::open(['method' => 'DELETE','route' => ['chuyen-khoa.destroy', $value->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-circle show_confirm']) !!}
                                {!! Form::close() !!}

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
