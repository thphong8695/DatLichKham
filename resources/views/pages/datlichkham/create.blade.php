@extends('pages.layouts.default')
@section('content') 

<!--Page header-->
<div class="page-header mt-3">
    <div class="page-leftheader">
        <h4 class="page-title">Tạo mới đặt lịch khám</h4>
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dat-lich-kham.index') }}">Danh sách đặt lịch khám</a></li>
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
                    <a type="button" href="{{ route('dat-lich-kham.index') }}" class="btn btn-success">Back</a>
                </div>
            </div>
           
            <div class="card-body">
                <i style="color: red">*lưu ý: chọn bệnh viện -> ngày khám -> sau đó nhập các thông tin còn lại.</i>

                @include('pages.layouts.partials.alert')
                {!! Form::open(array('route' => 'dat-lich-kham.store','method'=>'POST','class' =>'mt-3')) !!}
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Bệnh viện: <span style="color: red">*</span></strong>
                                {!! Form::select('benhvien_id',$benhvien,null,['class'=>'form-control','id'=>'benhvien_id','placeholder'=>'Chọn bệnh viện','required']) !!}
                                @error('benhvien_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Ngày Khám: <span style="color: red">*</span></strong>
                                {!! Form::text('ngaykham', null, array('placeholder' => 'Ngày khám','class' => 'form-control','data-toggle' => 'datepickerNgayKham','autocomplete'=>'off')) !!}
                                @error('ngaykham')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Khung giờ: <span style="color: red">*</span></strong>
                                <select class="form-control" name="khunggio_id" id="khunggio_id" required="">
                                    @if(old('benhvien_id'))
                                        <option value="">Chọn khung giờ</option>
                                        @foreach($khunggio as $value)
                                            @if(old('benhvien_id') == $value->benhvien_id)
                                            <option {{ old('khunggio_id') == $value->id ? 'selected' : '' }} value="{{ $value->id }}" >Khung giờ: {{ $value->name }} | Số lượng: {{ $value->soluong }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                                
                                @error('khunggio_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Chuyên khoa: <span style="color: red">*</span></strong>
                                <select class="form-control" name="chuyenkhoa_id" id="chuyenkhoa_id" required="">
                                    @if(old('benhvien_id'))
                                        <option value="">Chọn chuyên khoa</option>
                                        @foreach($chuyenkhoa as $value)
                                            @if(old('benhvien_id') == $value->benhvien_id)
                                            <option {{ old('chuyenkhoa_id') == $value->id ? 'selected' : '' }} value="{{ $value->id }}" >{{ $value->name }} </option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                                
                                @error('chuyenkhoa_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Họ & Tên: <span style="color: red">*</span></strong>
                                {{-- {!! Form::text('name', null, array('placeholder' => 'Họ & Tên','class' => 'form-control')) !!} --}}
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror " value="{{ old('name') }}" placeholder="Họ & Tên">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Số điện thoại: <span style="color: red">*</span></strong>
                                {!! Form::number('phone', null, array('placeholder' => 'Số điện thoại','class' => 'form-control')) !!}
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Năm Sinh: <span style="color: red">*</span></strong>
                                {!! Form::text('namsinh', null, array('placeholder' => 'Năm Sinh','class' => 'form-control')) !!}
                                @error('namsinh')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Số nhà: </strong>
                                {!! Form::text('sonha', null, array('placeholder' => 'Số nhà','class' => 'form-control')) !!}
                                @error('sonha')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Địa chỉ: </strong>
                                {!! Form::text('diachi', null, array('placeholder' => 'Địa chỉ','class' => 'form-control')) !!}
                                @error('diachi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Giới tính: <span style="color: red">*</span></strong>
                                {!! Form::select('gioitinh',$gioitinh,null,['class'=>'form-control','id'=>'gioitinh','placeholder'=>'Chọn giới tính']) !!}
                                @error('gioitinh')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Mã y tế: </strong>
                                {!! Form::text('mayte', null, array('placeholder' => 'Mã y tế','class' => 'form-control')) !!}
                                @error('mayte')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Số bảo hiểm: </strong>
                                {!! Form::text('sobaohiem', null, array('placeholder' => 'Số bảo hiểm','class' => 'form-control')) !!}
                                @error('sobaohiem')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>Ghi chú: </strong>
                                {!! Form::textarea('ghichu', null, ['class'=>'form-control', 'rows' => 3,'placeholder'=>'ghi chú']) !!}
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
@endsection

