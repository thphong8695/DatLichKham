@extends('pages.layouts.default')
@section('content') 

<!--Page header-->
<div class="page-header mt-3">
    <div class="page-leftheader">
        <h4 class="page-title">Dữ liệu tin nhắn</h4>
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dat-lich-kham.index') }}">Danh sách đặt lịch khám</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sửa mẫu tin nhắn</li>
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
                <legend>Gửi lại SMS: </legend>
                <div class="card-options ">
                    <a type="button" href="{{ route('dat-lich-kham.index') }}" class="btn btn-success">Back</a>
                </div>
            </div>
          
            <div class="card-body">
                {!! Form::model($tinNhan, ['method' => 'PATCH','route' => ['dat-lich-kham.updateSms', $tinNhan->id]]) !!}
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <strong>SĐT: <span style="color: red">*</span></strong>
                                {!! Form::text('phone', null, array('placeholder' => 'SĐT','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <strong>Nội dung: <span style="color: red">*</span></strong>
                                {!! Form::textarea('content', null, ['rows' => 4, 'cols' => 55, 'style' => 'resize:none', 'class' => 'form-control ','placeholder' => 'Nội dung tin nhắn']) !!}
                                @error('content')
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

