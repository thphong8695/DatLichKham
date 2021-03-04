@extends('pages.layouts.default')
@section('content') 

<!--Page header-->
<div class="page-header mt-3">
    <div class="page-leftheader">
        <h4 class="page-title">Dữ liệu mẫu tin nhắn</h4>
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('mau-tin-nhan.index') }}">Danh sách mẫu tin nhắn</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tạo mới mẫu tin nhắn</li>
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
                <legend>Tạo mới</legend>
                <div class="card-options ">
                    <a type="button" href="{{ route('mau-tin-nhan.index') }}" class="btn btn-success">Back</a>
                </div>
            </div>
         
            <div class="card-body">
                <i>Ghi chú: $khunggio: khung giờ, $ngaykham: ngày khám, $phone: số điện thoại, $benhvien: bệnh viện, $stt: STT.</i>
                {!! Form::open(array('route' => 'mau-tin-nhan.store','method'=>'POST')) !!}
                    
                    <div class="row">

                        <div class="col-md-8">
                            <div class="form-group">
                                <strong>Nội dung: <span style="color: red">*</span></strong>
                                {!! Form::textarea('content', null, ['rows' => 4, 'cols' => 55, 'style' => 'resize:none', 'class' => 'form-control ','placeholder' => 'Nội dung tin nhắn']) !!}
                                @error('content')
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

