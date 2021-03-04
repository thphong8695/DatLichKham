@extends('pages.layouts.default')
@section('content') 

<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title"><a href="{{ route('export.index') }}">Xuất file</a></h4>
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Form xuất file</li>
        </ol>
    </div>
</div>
<!--End Page header-->

<div class="row">
    <div class="col-md-12">  
        <div class="card">
            {!! Form::open(array('route' => 'export.export','method'=>'get')) !!}
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Thông Báo! </strong>{{ session('error') }}
                    </div>
                    @endif
                <div class="row">
                    <div class="col-md-12">
                        <b>Form lọc điều kiện:</b>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>Bệnh viện: <span style="color: red">*</span></strong>
                            {!! Form::select('benhvien_id',$benhvien,app('request')->input('benhvien_id'),['class'=>'form-control ','id'=>'benhvien_id','placeholder'=>'Chọn bệnh viện']) !!}
                            
                            @error('benhvien_id')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                        
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>Khung giờ:</strong>
                            <select class="form-control" name="khunggio_id" id="khunggio_id">
                                <option value="">Chọn khung giờ</option>
                                @if(old('benhvien_id'))
                                    @foreach($khunggio as $value)
                                        @if(old('benhvien_id') == $value->benhvien_id)
                                            <option {{ old('khunggio_id') == $value->id ? 'selected' : '' }} value="{{ $value->id }}" >Khung giờ: {{ $value->name }} | Số lượng: {{ $value->soluong }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            @error('khunggio_id')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>Chuyên khoa:</strong>
                            <select class="form-control" name="chuyenkhoa_id" id="chuyenkhoa_id">
                                <option value="">Chọn chuyên khoa</option>
                                @if(old('benhvien_id'))
                                    @foreach($chuyenkhoa as $value)
                                        @if(old('benhvien_id') == $value->benhvien_id)
                                            <option {{ old('chuyenkhoa_id') == $value->id ? 'selected' : '' }} value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            
                            @error('chuyenkhoa_id')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>Ngày bắt đầu:</strong>
                            {!! Form::text('from', app('request')->input('from'), array('placeholder' => 'Ngày khám','class' => 'form-control','data-toggle' => 'datepickerNgayHienTai','autocomplete'=>'off')) !!}
                            @error('from')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>Ngày kết thúc:</strong>
                            {!! Form::text('to', app('request')->input('to'), array('placeholder' => 'Ngày khám','class' => 'form-control','data-toggle' => 'datepickerNgayHienTai','autocomplete'=>'off')) !!}
                            @error('to')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                    <hr>
                        <b><i class="side-menu__icon fe fe-check"></i>: ẩn form.</b>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>Năm Sinh: </strong>
                            <br>
                            <label class="colorinput">
                                <input name="namsinh" value="1" type="checkbox" {{ old('namsinh') == 1 ? 'checked' :'' }}  class="colorinput-input"  />
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
                                <input name="chuyenkhoa" value="1" type="checkbox" {{ old('chuyenkhoa') == 1 ? 'checked' :'' }} class="colorinput-input"  />
                                <span class="colorinput-color bg-azure"></span>
                            </label>
                            @error('chuyenkhoa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            
                            <strong>Bác sĩ:</strong>
                            <br>
                            <label class="colorinput">
                                <input name="bacsi_id" value="1" type="checkbox" {{ old('bacsi_id') == 1 ? 'checked' :'' }} class="colorinput-input"  />
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
                                <input name="gioitinh" value="1" type="checkbox" {{ old('gioitinh') == 1 ? 'checked' :'' }} class="colorinput-input"  />
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
                                <input name="sonha" value="1" type="checkbox" {{ old('sonha') == 1 ? 'checked' :'' }} class="colorinput-input"  />
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
                                <input name="diachi" value="1" type="checkbox" {{ old('diachi') == 1 ? 'checked' :'' }} class="colorinput-input"  />
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
                                <input name="province_id" value="1" type="checkbox" {{ old('province_id') == 1 ? 'checked' :'' }} class="colorinput-input"  />
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
                                <input name="mayte" value="1" type="checkbox" {{ old('mayte') == 1 ? 'checked' :'' }} class="colorinput-input"  />
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
                                <input name="sobaohiem" value="1" type="checkbox" {{ old('sobaohiem') == 1 ? 'checked' :'' }} class="colorinput-input"  />
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
                                <input name="vacxin_id" value="1" type="checkbox" {{ old('vacxin_id') == 1 ? 'checked' :'' }} class="colorinput-input"  />
                                <span class="colorinput-color bg-azure"></span>
                            </label>
                            @if ($message = Session::get('vacxin_id'))
                                <span style="color: red">{{ $message }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            
                            <strong>User tạo: </strong>
                            <br>
                            <label class="colorinput">
                                <input name="user_id" value="1" type="checkbox" {{ old('user_id') == 1 ? 'checked' :'' }} class="colorinput-input"  />
                                <span class="colorinput-color bg-azure"></span>
                            </label>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            
                            <strong>Ghi chú: </strong>
                            <br>
                            <label class="colorinput">
                                <input name="ghichu" value="1" type="checkbox" {{ old('ghichu') == 1 ? 'checked' :'' }} class="colorinput-input"  />
                                <span class="colorinput-color bg-azure"></span>
                            </label>
                            @error('ghichu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary ml-2">Export file</button>
                    </div>
                </div>
                        
            </div>
            {!! Form::close() !!}
        
            
        </div>
    <!-- section-wrapper -->

    </div>
</div>
<!-- Modal -->

@endsection
@section('script')
<script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript">
    var url1 = "{{ url('/showKhungGioInBenhVien') }}";
    $("select[id='benhvien_id']").change(function(){
        var benhvien_id = $("#benhvien_id").val();
        var token = $("input[name='_token']").val();
        $.ajax({
            url: url1,
            method: 'POST',
            data: {
                benhvien_id: benhvien_id,
                _token: token
            },
            success: function(data) {
                $("select[id='khunggio_id'").html('');
                $("select[id='khunggio_id'").prepend("<option value=''>Chọn khung giờ</option>");
                $.each(data, function(key, value){

                    $("select[id='khunggio_id']").append(

                        "<option value='"+value.id+"'>Khung giờ: "+value.name+" | Số lượng: "+value.soluong+"</option>"
                    );
                });
            }
        });
    });
    var url2 = "{{ url('/showChuyenKhoaInBenhVien') }}";
    $("select[id='benhvien_id']").change(function(){
        var benhvien_id = $("#benhvien_id").val();
        var token = $("input[name='_token']").val();
        $.ajax({
            url: url2,
            method: 'POST',
            data: {
                benhvien_id: benhvien_id,
                _token: token
            },
            success: function(data) {
                $("select[id='chuyenkhoa_id'").html('');
                $("select[id='chuyenkhoa_id'").prepend("<option value=''>Chọn chuyên khoa</option>");
                $.each(data, function(key, value){

                    $("select[id='chuyenkhoa_id']").append(

                        "<option value='"+value.id+"'>"+value.name+"</option>"
                    );
                });
            }
        });
    });
</script>

@endsection
