@extends('pages.layouts.default')
@section('content') 

<!--Page header-->
<div class="page-header mt-3">
    <div class="page-leftheader">
        <h4 class="page-title">Dữ liệu khung giờ</h4>
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('khung-gio.index') }}">Danh sách khung giờ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tạo mới khung giờ</li>
        </ol>
    </div>
    
</div>
<!--End Page header-->
<div class="row">
    <div class="col-md-12 col-lg-12">  
        
        <div class="card">
            
            <div class="card-header">
                <legend>Tạo mới</legend>
                <div class="card-options ">
                    <a type="button" href="{{ route('khung-gio.index') }}" class="btn btn-success">Back</a>
                </div>
            </div>
         
            <div class="card-body">
            
                {!! Form::open(array('route' => 'khung-gio.store','method'=>'POST')) !!}
                    
                    <div class="row">

                        <div class="col-md-8">
                            <div class="form-group">
                                <strong>Tên khung giờ: <span style="color: red">*</span></strong>
                                {!! Form::text('name', null, array('placeholder' => 'Tên khung giờ','class' => 'form-control')) !!}
                                @error('name')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <strong>Số lượng: <span style="color: red">*</span></strong>
                                {!! Form::number('soluong', null, array('placeholder' => 'Số lượng','class' => 'form-control')) !!}
                                @error('soluong')
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

