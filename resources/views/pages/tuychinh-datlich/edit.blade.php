@extends('pages.layouts.default')
@section('content') 

<!--Page header-->
<div class="page-header mt-3">
    <div class="page-leftheader">
        <h4 class="page-title">Dữ liệu tùy chỉnh form đặt lịch</h4>
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tuychinh-datlich.index') }}">Danh sách bệnh tùy chỉnh form đặt lịch</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sửa tùy chỉnh form đặt lịch</li>
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
                <legend>Tùy chỉnh form: {{ $tuychinh_datlich->BenhVienPK->name }}</legend>
                <div class="card-options ">
                    <a type="button" href="{{ route('tuychinh-datlich.index') }}" class="btn btn-success">Back</a>
                </div>
            </div>
            <div class="card-body">
                {!! Form::model($tuychinh_datlich, ['method' => 'PATCH','route' => ['tuychinh-datlich.update', $tuychinh_datlich->id]]) !!}
                    <div class="row">
                        <div class="col-md-12">
                            <b><i class="side-menu__icon fe fe-check"></i>: ẩn form.</b>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Năm Sinh: </strong>
                                <br>
                                <label class="colorinput">
                                    <input name="namsinh" value="1" type="checkbox" {{ $tuychinh_datlich->namsinh == 1 ? 'checked' :'' }}  class="colorinput-input"  />
                                    <span class="colorinput-color bg-azure"></span>
                                </label>
                                @error('namsinh')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Chuyên khoa: </strong>
                                <br>
                                <label class="colorinput">
                                    <input name="chuyenkhoa_id" value="1" type="checkbox" {{ $tuychinh_datlich->chuyenkhoa_id == 1 ? 'checked' :'' }} class="colorinput-input"  />
                                    <span class="colorinput-color bg-azure"></span>
                                </label>
                                @error('chuyenkhoa_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                
                                <strong>Bác sĩ:</strong>
                                <br>
                                <label class="colorinput">
                                    <input name="bacsi_id" value="1" type="checkbox" {{ $tuychinh_datlich->bacsi_id == 1 ? 'checked' :'' }} class="colorinput-input"  />
                                    <span class="colorinput-color bg-azure"></span>
                                </label>
                                
                                @error('bacsi_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                
                                <strong>Giới tính: </strong>
                                <br>
                                <label class="colorinput">
                                    <input name="gioitinh" value="1" type="checkbox" {{ $tuychinh_datlich->gioitinh == 1 ? 'checked' :'' }} class="colorinput-input"  />
                                    <span class="colorinput-color bg-azure"></span>
                                </label>
                                @error('gioitinh')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                
                                <strong>Số nhà: </strong>
                                <br>
                                <label class="colorinput">
                                    <input name="sonha" value="1" type="checkbox" {{ $tuychinh_datlich->sonha == 1 ? 'checked' :'' }} class="colorinput-input"  />
                                    <span class="colorinput-color bg-azure"></span>
                                </label>
                                @error('sonha')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                
                                <strong>Địa chỉ: </strong>
                                <br>
                                <label class="colorinput">
                                    <input name="diachi" value="1" type="checkbox" {{ $tuychinh_datlich->diachi == 1 ? 'checked' :'' }} class="colorinput-input"  />
                                    <span class="colorinput-color bg-azure"></span>
                                </label>
                                @error('diachi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Tỉnh thành: <span style="color: red">
                                </span></strong>
                                <br>
                                <label class="colorinput">
                                    <input name="province_id" value="1" type="checkbox" {{ $tuychinh_datlich->province_id == 1 ? 'checked' :'' }} class="colorinput-input"  />
                                    <span class="colorinput-color bg-azure"></span>
                                </label>
                                
                                @error('province_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                
                                <strong>Mã y tế: </strong>
                                <br>
                                <label class="colorinput">
                                    <input name="mayte" value="1" type="checkbox" {{ $tuychinh_datlich->mayte == 1 ? 'checked' :'' }} class="colorinput-input"  />
                                    <span class="colorinput-color bg-azure"></span>
                                </label>
                                @error('mayte')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                
                                <strong>Số bảo hiểm: </strong>
                                <br>
                                <label class="colorinput">
                                    <input name="sobaohiem" value="1" type="checkbox" {{ $tuychinh_datlich->sobaohiem == 1 ? 'checked' :'' }} class="colorinput-input"  />
                                    <span class="colorinput-color bg-azure"></span>
                                </label>
                                @error('sobaohiem')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                
                                <strong>Vắc-xin(thuốc):</strong>
                                <br>
                                <label class="colorinput">
                                    <input name="vacxin_id" value="1" type="checkbox" {{ $tuychinh_datlich->vacxin_id == 1 ? 'checked' :'' }} class="colorinput-input"  />
                                    <span class="colorinput-color bg-azure"></span>
                                </label>
                                @if ($message = Session::get('vacxin_id'))
                                    <span style="color: red">{{ $message }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                
                                <strong>SMS: </strong>
                                <br>
                                <label class="colorinput">
                                    <input name="sms_id" value="1" type="checkbox" {{ $tuychinh_datlich->sms_id == 1 ? 'checked' :'' }} class="colorinput-input"  />
                                    <span class="colorinput-color bg-azure"></span>
                                </label>
                                @error('sms_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                
                                <strong>Ghi chú: </strong>
                                <br>
                                <label class="colorinput">
                                    <input name="ghichu" value="1" type="checkbox" {{ $tuychinh_datlich->ghichu == 1 ? 'checked' :'' }} class="colorinput-input"  />
                                    <span class="colorinput-color bg-azure"></span>
                                </label>
                                @error('ghichu')
                                    <div class="invalid-feedback">{{ $message }}</div>
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

