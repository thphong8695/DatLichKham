@extends('pages.layouts.default')
@section('content') 

<!--Page header-->
<div class="page-header mt-3">
    <div class="page-leftheader">
        <h4 class="page-title">Tạo mới đặt lịch khám</h4>
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dat-lich-kham.index') }}">Danh sách đặt lịch khám</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tạo mới lịch khám: bước 4</li>
        </ol>
    </div>
    
</div>
<!--End Page header-->
<div class="row">
    <div class="col-md-12 col-lg-12">  
        
        <div class="card">
            
            <div class="card-header">
                <legend>Kiểm tra lại thông tin</legend>
                <div class="card-options ">
                    <a type="button" href="javascript:history.back()" class="btn btn-success">Back to step 3</a>
                </div>
            </div>
           
            <div class="card-body">
                {!! Form::open(array('route' => 'dat-lich-kham.PostcreateStep4','method'=>'POST','class' =>'mt-3')) !!}
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Bệnh viện: <span style="color: red">*</span></strong>
                                <p>{{ $tenbenhvien->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Ngày Khám: <span style="color: red">*</span></strong>
                                <p>{{ $register->ngaykham->format('d/m/Y') }}</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Họ & Tên: <span style="color: red">*</span></strong>
                                <p>{{ $register->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Số điện thoại: <span style="color: red">*</span></strong>
                                <p>{{ $register->phone }}</p>
                            </div>
                        </div>
                        @if($tuychinhFormDL->namsinh != 1)
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Năm Sinh:</strong>
                                <p>{{ $register->namsinh }}</p>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Khung giờ: <span style="color: red">*</span></strong>
                                <p>{{ $khunggio->name }}</p>
                            </div>
                        </div>
                        
                        @if($tuychinhFormDL->chuyenkhoa_id != 1)
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Chuyên khoa: </strong>
                                <p>{{ isset($chuyenkhoa) ? $chuyenkhoa->name : '' }}</p>
                            </div>
                        </div>
                        @endif
                        @if($tuychinhFormDL->bacsi_id != 1)
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Bác sĩ: </strong>
                                <p>{{ $bacsi ? $bacsi->name : '' }}</p>
                            </div>
                        </div>
                        
                        @endif
                        @if($tuychinhFormDL->sonha != 1)
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Số nhà: </strong>
                                <p>{{ $register->sonha }}</p>
                            </div>
                        </div>
                        @endif
                        @if($tuychinhFormDL->diachi != 1)
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Địa chỉ: </strong>
                                <p>{{ $register->diachi }}</p>
                            </div>
                        </div>
                        @endif
                        @if($tuychinhFormDL->province_id != 1)
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Tỉnh thành: </strong>
                                <p>{{ $province ? $province->name : '' }}</p>
                            </div>
                        </div>
                        @endif
                        @if($tuychinhFormDL->gioitinh != 1)
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Giới tính: </strong>
                                <p>{!!$register->gioitinh == 1 ? 'Nam' : 'Nữ'!!}</p>
                            </div>
                        </div>
                        @endif
                        @if($tuychinhFormDL->mayte != 1)
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Mã y tế: </strong>
                                <p>{{ $register->mayte }}</p>
                            </div>
                        </div>
                        @endif
                        @if($tuychinhFormDL->sobaohiem != 1)
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Số bảo hiểm: </strong>
                                <p>{{ $register->sobaohiem }}</p>
                            </div>
                        </div>
                        @endif
                        @if($tuychinhFormDL->vacxin_id != 1)
                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>Vắc-xin(thuốc): </strong>
                                @foreach($vacxin as $key => $value)
                                    <span class="badge badge-info">{!! $value->name !!}</span>
                                @endforeach
                                
                            </div>
                        </div>
                        @endif
                        @if($tuychinhFormDL->ghichu != 1)
                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>Ghi chú: </strong>
                                <p>{!! $register->ghichu !!}</p>
                            </div>
                        </div>
                        @endif
                        @if($tuychinhFormDL->sms_id != 1 && $mautinnhan)
                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>SMS: </strong>
                                {!! Form::textarea('sms_id', $noidung_sms, ['rows' => 4, 'cols' => 55, 'style' => 'resize:none', 'class' => 'form-control ','placeholder' => 'Nội dung tin nhắn','readonly']) !!}
                            </div>
                        </div>
                        @endif
                        <div class="col-md-12 d-flex justify-content-center">
                            <button type="submit" id="saveBtn" class="btn btn-primary">Đặt lịch</button>
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


