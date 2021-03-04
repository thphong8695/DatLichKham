@extends('pages.layouts.default')
@section('content') 

<!--Page header-->
<div class="page-header mt-3">
    <div class="page-leftheader">
        <h4 class="page-title">Dữ liệu tùy chỉnh khung giờ</h4>
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tuychinh-khunggio.index') }}">Danh sách bệnh tùy chỉnh khung giờ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sửa tùy chỉnh khung giờ</li>
        </ol>
    </div>
</div>
<!--End Page header-->
<div class="row">
    <div class="col-md-12 col-lg-12">  
        
        <div class="card">
            
            <div class="card-header">
                <legend>Sửa đổi tùy chỉnh khung giờ</legend>
                <div class="card-options ">
                    <a type="button" href="{{ route('tuychinh-ngayoff.index') }}" class="btn btn-success">Back</a>
                </div>
            </div>
          
            <div class="card-body">
                {!! Form::model($tuychinhngayoff, ['method' => 'PATCH','route' => ['tuychinh-ngayoff.update', $tuychinhngayoff->id]]) !!}
                    <div class="row">

                        <div class="col-md-8">
                            <div class="form-group">
                                <strong>Ngày off: <span style="color: red">*</span></strong>
                                {!! Form::text('ngayoff', date('d-m-Y',strtotime($tuychinhngayoff->ngayoff)), array('placeholder' => 'Ngày off','class' => 'form-control','data-toggle' => 'datepickerNgayHienTai1','autocomplete'=>'off')) !!}
                                @error('ngayoff')
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
@section('script')
<script type="text/javascript">
    $(function() {
        $('[data-toggle="datepickerNgayHienTai1"]').datepicker({
            format: 'dd-mm-yyyy',
            todayBtn: "linked",
            //daysOfWeekDisabled: "0,6",
            language: "vi",
            todayHighlight : true,
            //autoHide: true,
            autoclose: true,
            zIndex: 2048,
            startDate: new Date()
        });
    });
</script>
@endsection
