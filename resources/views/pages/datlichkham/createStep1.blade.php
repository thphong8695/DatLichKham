@extends('pages.layouts.default')
@section('content') 

<!--Page header-->
<div class="page-header mt-3">
    <div class="page-leftheader">
        <h4 class="page-title">Tạo mới đặt lịch khám</h4>
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dat-lich-kham.index') }}">Danh sách đặt lịch khám</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tạo mới lịch khám: bước 1</li>
        </ol>
    </div>
    
</div>
<!--End Page header-->
<div class="row">
    <div class="col-md-12 col-lg-12">  
        
        <div class="card">
            
            <div class="card-header">
                <legend>Step 1:</legend>
                <div class="card-options ">
                    <a type="button" href="{{ route('dat-lich-kham.index') }}" class="btn btn-success">Back</a>
                </div>
            </div>
           
            <div class="card-body">
                {{-- <i style="color: red">*lưu ý: chọn bệnh viện -> ngày khám -> sau đó nhập các thông tin còn lại.</i> --}}

                @include('pages.layouts.partials.alert')
                {!! Form::open(array('route' => 'dat-lich-kham.PostcreateStep1','method'=>'POST','class' =>'mt-3')) !!}
                    
                    <div class="row">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <strong>Bệnh viện: <span style="color: red">*</span></strong>
                                {!! Form::select('benhvien_id',$benhvien,null,['class'=>'form-control','id'=>'benhvien_id','placeholder'=>'Chọn bệnh viện','required']) !!}
                                @error('benhvien_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    
                       
                        
                        <div class="col-md-12 d-flex justify-content-center">
                            <button type="submit" id="saveBtn" class="btn btn-info">Continue</button>
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
@section('script')

@endsection

