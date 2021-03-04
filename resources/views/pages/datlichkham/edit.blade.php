@extends('pages.layouts.default')
@section('content') 

<!--Page header-->
<div class="page-header mt-3">
    <div class="page-leftheader">
        <h4 class="page-title">Sửa lịch khám</h4>
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dat-lich-kham.index') }}">Danh sách đặt lịch khám</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sửa lịch khám</li>
        </ol>
    </div>
    
</div>
<!--End Page header-->
<div class="row">
    <div class="col-md-12 col-lg-12">  
        
        <div class="card">
            
            <div class="card-header">
                <legend>Sửa lịch khám</legend>
                <div class="card-options ">
                    <a type="button" href="{{ route('dat-lich-kham.index') }}" class="btn btn-success">Back</a>
                </div>
            </div>
           
            <div class="card-body">
                <i style="color: red">*lưu ý khi sửa khung giờ: chọn bệnh viện -> ngày khám -> khung giờ.</i>

                {{-- @include('pages.layouts.partials.alert') --}}
                {!! Form::model($datLichKham, ['method' => 'PATCH','route' => ['dat-lich-kham.update', $datLichKham->id]]) !!}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Bệnh viện hiện tại: {{ $datLichKham->BenhVienPK->name }} <span style="color: red">*</span></strong>
                                {!! Form::select('benhvien_id',$benhvien,0,['class'=>'form-control'. ($errors->has('benhvien_id') ? ' is-invalid' : null),'id'=>'benhvien_id','placeholder'=>'Chọn bệnh viện']) !!}
                                @error('benhvien_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Ngày Khám: <span style="color: red">*</span></strong>
                                {!! Form::text('ngaykham', $datLichKham->ngaykham->format('d-m-Y'), array('placeholder' => 'Ngày khám','class' => 'form-control'. ($errors->has('ngaykham') ? ' is-invalid' : null),'data-toggle' => 'datepickerNgayKham','autocomplete'=>'off','id' =>'ngaykham')) !!}
                                @error('ngaykham')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Khung giờ hiện tại: {{ $datLichKham->KhungGio->name }} <span style="color: red">*</span></strong>
                                <select class="form-control @error('khunggio_id') is-invalid @enderror" name="khunggio_id" id="khunggio_id" >
                                    <option value="">Chọn khung giờ</option>
                                    @foreach($khunggio as $value)
                                        @if($datLichKham->benhvien_id == $value->benhvien_id)
                                                @if($value->TuyChinhKhungGio->count() > 0)
                                                <option {{ $datLichKham->khunggio_id == $value->id ? 'selected' : '' }} value="{{ $value->id }}" {{ ($value->TuyChinhKhungGio->first()->soluong - $value->DatLichKham->count()) <= 0 && $datLichKham->khunggio_id != $value->id ? 'disabled' : '' }}>
                                                Khung giờ: {{ $value->name }} 
                                                | Số lượng: {{ $value->TuyChinhKhungGio->first()->soluong }} 
                                                | đã đặt: {{ $value->DatLichKham->count() }}
                                                | còn lại: {{ $value->TuyChinhKhungGio->first()->soluong - $value->DatLichKham->count() }} 
                                                 {{ ($value->soluong - $value->DatLichKham->count()) <= 0? ' | đã hết' : '' }}
                                                </option>
                                            @else
                                                <option {{ $datLichKham->khunggio_id == $value->id ? 'selected' : '' }} value="{{ $value->id }}" {{ ($value->soluong - $value->DatLichKham->count()) <= 0 && $datLichKham->khunggio_id != $value->id ? 'disabled' : '' }}>
                                                Khung giờ: {{ $value->name }} 
                                                | Số lượng: {{ $value->soluong }} 
                                                | đã đặt: {{ $value->DatLichKham->count() }}
                                                | còn lại: {{ $value->soluong - $value->DatLichKham->count() }} 
                                                 {{ ($value->soluong - $value->DatLichKham->count()) <= 0 ? ' | đã hết' : '' }}
                                                </option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                                
                                @error('khunggio_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Chuyên khoa hiện tại: {{ $datLichKham->ChuyenKhoa ? $datLichKham->ChuyenKhoa->name : '' }} <span style="color: red">*</span></strong>
                                <select class="form-control @error('chuyenkhoa_id') is-invalid @enderror" name="chuyenkhoa_id" id="chuyenkhoa_id">
                                    <option value="">Chọn chuyên khoa</option>
                                    @foreach($chuyenkhoa as $value)
                                        @if($datLichKham->benhvien_id == $value->benhvien_id)
                                        <option {{ $datLichKham->chuyenkhoa_id == $value->id ? 'selected' : '' }} value="{{ $value->id }}" >{{ $value->name }} </option>
                                        @endif
                                    @endforeach
                                </select>
                                
                                @error('chuyenkhoa_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Họ & Tên: <span style="color: red">*</span></strong>
                                {!! Form::text('name', null, array('placeholder' => 'Họ & Tên','class' => 'form-control'. ($errors->has('name') ? ' is-invalid' : null))) !!}
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Số điện thoại: <span style="color: red">*</span></strong>
                                {!! Form::number('phone', null, array('placeholder' => 'Số điện thoại','class' => 'form-control'. ($errors->has('phone') ? ' is-invalid' : null))) !!}
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Bác sĩ hiện tại: {{ $datLichKham->BacSi ? $datLichKham->BacSi->name : '' }}</strong>
                                {!! Form::select('bacsi_id',$bacsi,app('request')->input('bacsi_id'),['class'=>'form-control','id'=>'bacsi_id','placeholder'=>'Chọn bác sĩ']) !!}
                                
                                @error('bacsi_id')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Năm Sinh: <span style="color: red">*</span></strong>
                                {!! Form::text('namsinh', null, array('placeholder' => 'Năm Sinh','class' => 'form-control'. ($errors->has('namsinh') ? ' is-invalid' : null) )) !!}
                                @error('namsinh')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Số nhà: </strong>
                                {!! Form::text('sonha', null, array('placeholder' => 'Số nhà','class' => 'form-control'. ($errors->has('sonha') ? ' is-invalid' : null))) !!}
                                @error('sonha')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Địa chỉ: </strong>
                                {!! Form::text('diachi', null, array('placeholder' => 'Địa chỉ','class' => 'form-control'. ($errors->has('diachi') ? ' is-invalid' : null))) !!}
                                @error('diachi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Tỉnh thành: </strong>
                                {!! Form::select('province_id',$province,null,['class'=>'form-control'. ($errors->has('province_id') ? ' is-invalid' : null),'id'=>'province_id','placeholder'=>'Chọn bệnh viện','required']) !!}
                                @error('province_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Giới tính: <span style="color: red">*</span></strong>
                                {!! Form::select('gioitinh',$gioitinh,null,['class'=>'form-control'. ($errors->has('gioitinh') ? ' is-invalid' : null),'id'=>'gioitinh','placeholder'=>'Chọn giới tính']) !!}
                                @error('gioitinh')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Mã y tế: </strong>
                                {!! Form::text('mayte', null, array('placeholder' => 'Mã y tế','class' => 'form-control'. ($errors->has('mayte') ? ' is-invalid' : null))) !!}
                                @error('mayte')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Số bảo hiểm: </strong>
                                {!! Form::text('sobaohiem', null, array('placeholder' => 'Số bảo hiểm','class' => 'form-control'. ($errors->has('sobaohiem') ? ' is-invalid' : null))) !!}
                                @error('sobaohiem')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Vắc-xin <span style="color: red">*</span></label>
                               
                                {!! Form::select('vacxin_id[]', $vacxin,$datlichkham_vacxin, array('class' => 'form-control tagging','multiple','style' => 'width: 100%','id' => 'loaivacxin')) !!}
                                @error('vacxin_id')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>Ghi chú: </strong>
                                {!! Form::textarea('ghichu', null, ['class'=>'form-control'. ($errors->has('ghichu') ? ' is-invalid' : null), 'rows' => 3,'placeholder'=>'ghi chú']) !!}
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <button type="submit" id="saveBtn" class="btn btn-info">Submit</button>
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
    var url1 = "{{ url('/showKhungGioInBenhVienDatLichKham') }}";
    $("select[id='benhvien_id']").change(function(){
        var benhvien_id = $("#benhvien_id").val();
        var token = $("input[name='_token']").val();
        $("select[id='khunggio_id'").html('');
        $("#ngaykham").change(function(){
            var ngaykham = $("#ngaykham").val();
            $.ajax({
                url: url1,
                method: 'POST',
                data: {
                    benhvien_id: benhvien_id,
                    ngaykham: ngaykham,
                    _token: token
                },
                success: function(data) {
                    $("select[id='khunggio_id'").html('');
                    $("select[id='khunggio_id'").prepend("<option value=''>Chọn khung giờ</option>");
                    $.each(data, function(key, value){
                        var sum = parseInt(value.dat_lich_kham.length)
                        var khunggiodatlich_id = {{ $datLichKham->khunggio_id }};
                        var tuychinh = parseInt(value.tuy_chinh_khung_gio.length)
                        if(tuychinh > 0)
                        {
                            if(sum >= value.tuy_chinh_khung_gio[0].soluong && khunggiodatlich_id != value.id)
                            {
                                $("select[id='khunggio_id']").append(
                                "<option disabled value='"+value.id+"'>Khung giờ:" + value.name+ " | Số lượng "+value.tuy_chinh_khung_gio[0].soluong+" | đã đặt: "+sum+" |còn lại: "+(value.tuy_chinh_khung_gio[0].soluong - sum)+" | hết lượt đặt</option>"
                                );
                            }
                            else
                            {
                                $("select[id='khunggio_id']").append(
                                "<option value='"+value.id+"'>Khung giờ:" + value.name + " | Số lượng "+value.tuy_chinh_khung_gio[0].soluong+" | đã đặt: "+sum+" |còn lại: "+(value.tuy_chinh_khung_gio[0].soluong - sum)+"</option>"
                                );
                            }
                        }
                        else
                        {
                            if(sum >= value.soluong && khunggiodatlich_id != value.id)
                            {
                                $("select[id='khunggio_id']").append(
                                "<option disabled value='"+value.id+"'>Khung giờ:" + value.name + " | Số lượng "+value.soluong+" | đã đặt: "+sum+" |còn lại: "+(value.soluong - sum)+" | hết lượt đặt</option>"
                                );
                            }
                            else
                            {
                                $("select[id='khunggio_id']").append(
                                "<option value='"+value.id+"'>Khung giờ:" + value.name + " | Số lượng "+value.soluong+" | đã đặt: "+sum+" |còn lại: "+(value.soluong - sum)+"</option>"
                                );
                            }
                        }
                    });
                }
            });
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
<script type="text/javascript">
   var datesForDisable = {!! $ngayoff !!};
    $(function() {
        $('[data-toggle="datepickerNgayKham"]').datepicker({
            format: 'dd-mm-yyyy',
            todayBtn: "linked",
            //daysOfWeekDisabled: "0,6",
            language: "vi",
            todayHighlight : true,
            //autoHide: true,
            autoclose: true,
            zIndex: 2048,
            startDate: new Date(),
            beforeShowDay: function (currentDate) {
                if (datesForDisable.length > 0) {
                        for (var i = 0; i < datesForDisable.length; i++) {                        
                            if (moment(currentDate).unix()==moment(datesForDisable[i],'YYYY-MM-DD').unix()){
                                return false;
                           }
                        }
                    }
                    return true;
                }
        });
    });
</script>
<script type="text/javascript">
    var url3 = "{{ url('/showBacSiInChuyenKhoa') }}";
    $("select[id='chuyenkhoa_id']").change(function(){
        var chuyenkhoa_id = $("#chuyenkhoa_id").val();
        var token = $("input[name='_token']").val();
        $.ajax({
            url: url3,
            method: 'POST',
            data: {
                chuyenkhoa_id: chuyenkhoa_id,
                _token: token
            },
            success: function(data) {
                $("select[id='bacsi_id'").html('');
                $("select[id='bacsi_id'").prepend("<option value=''>Chọn bác sĩ</option>");
                $.each(data, function(key, value){

                    $("select[id='bacsi_id']").append(

                        "<option value='"+value.id+"'>"+value.name+"</option>"
                    );
                });
            }
        });
    });
</script>
@endsection

