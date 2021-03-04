@extends('pages.layouts.default')
@section('content') 

<!--Page header-->
<div class="page-header mt-3">
    <div class="page-leftheader">
        <h4 class="page-title">Dữ liệu chuyên khoa</h4>
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('chuyen-khoa.index') }}">Danh sách chuyên khoa</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sửa chuyên khoa</li>
        </ol>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <div class="btn-group mb-0">
           
                {{-- <a class="btn btn-success" href="logout"><i class="fa fa-plus mr-2"></i>Logout</a> --}}
              
        </div>
       
    </div>
</div>
<!--End Page header-->
<div class="row">
    <div class="col-md-12 col-lg-12">  
        
        <div class="card">
            
            <div class="card-header">
                <legend>Sửa: {{ $chuyenKhoa->name }}</legend>
                <div class="card-options ">
                    <a type="button" href="{{ route('chuyen-khoa.index') }}" class="btn btn-success">Back</a>
                </div>
            </div>
          
            <div class="card-body">
            
                {!! Form::model($chuyenKhoa, ['method' => 'PATCH','route' => ['chuyen-khoa.update', $chuyenKhoa->id]]) !!}
                    
                    <div class="row">

                        <div class="col-md-8">
                            <div class="form-group">
                                <strong>Tên chuyên khoa: <span style="color: red">*</span></strong>
                                {!! Form::text('name', null, array('placeholder' => 'Tên chuyên khoa','class' => 'form-control')) !!}
                                @error('name')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <strong>Bệnh viện: <span style="color: red">*</span></strong>
                                {!! Form::select('benhvien_id',$benhvien,null,['class'=>'form-control','id'=>'benhvien_id','placeholder'=>'Chọn bệnh viện','required']) !!}
                                @error('benhvien_id')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <button type="submit" id="saveBtn" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
            <!-- table-wrapper -->
        </div>
    <!-- section-wrapper -->

    </div>
</div>
<!-- Modal -->

@endsection

