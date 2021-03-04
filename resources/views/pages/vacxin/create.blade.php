@extends('pages.layouts.default')
@section('content') 

<!--Page header-->
<div class="page-header mt-3">
    <div class="page-leftheader">
        <h4 class="page-title">Dữ liệu vắc-xin</h4>
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('vac-xin.index') }}">Danh sách vắc-xin</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tạo mới vắc-xin</li>
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
                    <a type="button" href="{{ route('vac-xin.index') }}" class="btn btn-success">Back</a>
                </div>
            </div>
         
            <div class="card-body">
            
                {!! Form::open(array('route' => 'vac-xin.store','method'=>'POST')) !!}
                    
                    <div class="row">

                        <div class="col-md-8">
                            <div class="form-group">
                                <strong>Tên vắc-xin: <span style="color: red">*</span></strong>
                                {!! Form::text('name', null, array('placeholder' => 'Tên vắc-xin','class' => 'form-control')) !!}
                                @error('name')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <strong>Ngừa bệnh: <span style="color: red">*</span></strong>
                                {!! Form::textarea('nguabenh', null, ['rows' => 4, 'cols' => 55, 'style' => 'resize:none', 'class' => 'form-control','placeholder' => 'Ngừa bệnh']) !!}
                                @error('nguabenh')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <strong>Bệnh viện: <span style="color: red">*</span></strong>
                                {!! Form::select('benhvien_id',$benhvien,null,['class'=>'form-control','id'=>'benhvien_id','placeholder'=>'Chọn bệnh viện','required']) !!}
                                @error('benhvien_id')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <strong>Ghi chú: </strong>
                                {!! Form::textarea('ghichu', null, ['rows' => 2, 'cols' => 55, 'style' => 'resize:none', 'class' => 'form-control','placeholder' => 'Ghi chú']) !!}
                                @error('ghichu')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Giá tiền:</strong>
                                {!! Form::text('giatien', null, array('placeholder' => 'Giá tiền','class' => 'form-control')) !!}
                                @error('giatien')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <strong>Số lượng:</strong>
                                {!! Form::text('soluong', null, array('placeholder' => 'Số lượng','class' => 'form-control')) !!}
                                @error('soluong')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <strong>Ngày áp dụng:</strong>
                                {!! Form::text('ngayapdung', null, array('placeholder' => 'Ngày áp dụng','class' => 'form-control','data-toggle' => 'datepicker','autocomplete' => 'off')) !!}
                                @error('ngayapdung')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <strong>loại sử dụng vắc-xin: <span style="color: red">*</span></strong>
                                {!! Form::select('sdvacxin_id',$sdvacxin,null,['class'=>'form-control','id'=>'sdvacxin_id','placeholder'=>'Chọn loại sử dụng vắc-xin','required']) !!}
                                @error('sdvacxin_id')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <strong>Miễn phí:</strong>
                                <br>
                                <label class="colorinput">
                                    <input name="mienphi" value="1" type="checkbox"  class="colorinput-input"  />
                                    <span class="colorinput-color bg-azure"></span>
                                </label>
                                @error('mienphi')
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

