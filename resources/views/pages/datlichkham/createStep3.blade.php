@extends('pages.layouts.default')
@section('content') 

<!--Page header-->
<div class="page-header mt-3">
    <div class="page-leftheader">
        <h4 class="page-title">Tạo mới đặt lịch khám</h4>
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dat-lich-kham.index') }}">Danh sách đặt lịch khám</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tạo mới lịch khám: bước 3</li>
        </ol>
    </div>
    
</div>
<!--End Page header-->
<div class="row">
    <div class="col-md-12 col-lg-12">  
        
        <div class="card">
            
            <div class="card-header">
                <legend>Step 3: {{ $tenbenhvien->name }} - ngày {{ $register->ngaykham->format('d/m/Y') }}</legend>
                <div class="card-options ">
                    <a type="button" href="{{ route('dat-lich-kham.createStep2') }}" class="btn btn-success">Back to step 2</a>
                </div>
            </div>
           
            <div class="card-body">
                <span style="color: red">(*) Không được bỏ trống!</span>
                {{-- @include('pages.layouts.partials.alert') --}}
                {!! Form::open(array('route' => 'dat-lich-kham.PostcreateStep3','method'=>'POST','class' =>'mt-3')) !!}
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Họ & Tên: <span style="color: red">*</span></strong>
                                {!! Form::text('name', null, array('placeholder' => 'Họ & Tên','class' => 'form-control'. ($errors->has('name') ? ' is-invalid' : null))) !!}
                                {{-- <input type="text" name="name" class="form-control @error('name') is-invalid @enderror " value="{{ old('name') }}" placeholder="Họ & Tên"> --}}
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Số điện thoại (84xxxxxxx): <span style="color: red">*</span></strong>
                                {!! Form::number('phone', 84, array('placeholder' => 'Số điện thoại','class' => 'form-control'. ($errors->has('phone') ? ' is-invalid' : null) )) !!}
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @if($tuychinhFormDL->chuyenkhoa_id != 1)
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Năm Sinh: </strong>
                                {!! Form::text('namsinh', null, array('placeholder' => 'Năm Sinh','class' => 'form-control'. ($errors->has('namsinh') ? ' is-invalid' : null) )) !!}
                                @error('namsinh')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endif
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Khung giờ: <span style="color: red">*</span></strong>
                                <select class="form-control @error('khunggio_id') is-invalid @enderror" name="khunggio_id" id="khunggio_id" >
                                    <option value="">Chọn khung giờ</option>
                                    @foreach($khunggio as $value)
                                        @if($value->TuyChinhKhungGio->count() > 0)
                                            <option {{ old('khunggio_id') == $value->id ? 'selected' : '' }} value="{{ $value->id }}" {{ ($value->TuyChinhKhungGio->first()->soluong - $value->DatLichKham->count()) <= 0 ? 'disabled' : '' }}>
                                            Khung giờ: {{ $value->name }} 
                                            | Số lượng: {{ $value->TuyChinhKhungGio->first()->soluong }} 
                                            | đã đặt: {{ $value->DatLichKham->count() }}
                                            | còn lại: {{ $value->TuyChinhKhungGio->first()->soluong - $value->DatLichKham->count() }} 
                                             {{ ($value->soluong - $value->DatLichKham->count()) <= 0 ? ' | đã hết' : '' }}
                                            </option>
                                        @else
                                            <option {{ old('khunggio_id') == $value->id ? 'selected' : '' }} value="{{ $value->id }}" {{ ($value->soluong - $value->DatLichKham->count()) <= 0 ? 'disabled' : '' }}>
                                            Khung giờ: {{ $value->name }} 
                                            | Số lượng: {{ $value->soluong }} 
                                            | đã đặt: {{ $value->DatLichKham->count() }}
                                            | còn lại: {{ $value->soluong - $value->DatLichKham->count() }} 
                                             {{ ($value->soluong - $value->DatLichKham->count()) <= 0 ? ' | đã hết' : '' }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                
                                @error('khunggio_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- check --}}
                        @if($tuychinhFormDL->chuyenkhoa_id != 1)
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Chuyên khoa: </strong>
                                <select class="form-control @error('chuyenkhoa_id') is-invalid @enderror" name="chuyenkhoa_id" id="chuyenkhoa_id" >
                                    <option value="">Chọn chuyên khoa</option>
                                    @foreach($chuyenkhoa as $value)
                                        <option {{ old('chuyenkhoa_id') == $value->id ? 'selected' : '' }} value="{{ $value->id }}" >{{ $value->name }} </option>
                                    @endforeach
                                </select>
                                
                                @error('chuyenkhoa_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endif
                        @if($tuychinhFormDL->bacsi_id != 1)
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Bác sĩ: (chọn chuyên khoa -> chọn bác sĩ)</strong>
                                <select class="form-control @error('bacsi_id') is-invalid @enderror" name="bacsi_id" id="bacsi_id">
                                @if(old('chuyenkhoa_id'))
                                    <option value="">--Chọn bác sĩ--</option>
                                    @foreach($bacsi as $value)
                                        <option value="{{ $value->id }}" {{ $value->id == old('bacsi_id') ? 'selected' : '' }}>{{ $value->name }}</option>
                                    @endforeach
                                @endif
                                </select>
                                
                                @error('bacsi_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endif
                        @if($tuychinhFormDL->gioitinh != 1)
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Giới tính: </strong>
                                {!! Form::select('gioitinh',$gioitinh,null,['class'=>'form-control'. ($errors->has('gioitinh') ? ' is-invalid' : null),'id'=>'gioitinh','placeholder'=>'Chọn giới tính']) !!}
                                @error('gioitinh')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endif
                        @if($tuychinhFormDL->sonha != 1)
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Số nhà: </strong>
                                {!! Form::text('sonha', null, array('placeholder' => 'Số nhà','class' => 'form-control'. ($errors->has('sonha') ? ' is-invalid' : null))) !!}
                                @error('sonha')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endif
                        @if($tuychinhFormDL->diachi != 1)
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Địa chỉ: </strong>
                                {!! Form::text('diachi', null, array('placeholder' => 'Địa chỉ','class' => 'form-control'. ($errors->has('diachi') ? ' is-invalid' : null))) !!}
                                @error('diachi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endif
                        @if($tuychinhFormDL->province_id != 1)
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Tỉnh thành: <span style="color: red"></span></strong>
                                <select class="form-control @error('province_id') is-invalid @enderror" name="province_id" id="province_id">
                                    <option value="">Chọn tỉnh thành</option>
                                    @foreach($province as $value)
                                        <option {{ old('province_id') == $value->id || 50 == $value->id ? 'selected' : '' }} value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                
                                @error('province_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endif
                        @if($tuychinhFormDL->mayte != 1)
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Mã y tế: </strong>
                                {!! Form::text('mayte', null, array('placeholder' => 'Mã y tế','class' => 'form-control'. ($errors->has('mayte') ? ' is-invalid' : null))) !!}
                                @error('mayte')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endif
                        @if($tuychinhFormDL->sobaohiem != 1)
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Số bảo hiểm: </strong>
                                {!! Form::text('sobaohiem', null, array('placeholder' => 'Số bảo hiểm','class' => 'form-control'. ($errors->has('sobaohiem') ? ' is-invalid' : null))) !!}
                                @error('sobaohiem')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endif
                        @if($tuychinhFormDL->vacxin_id != 1)
                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>Vắc-xin(thuốc):</strong>
                                {{-- <select class="form-control tagging" name="vacxin_id[]" id="vacxin_id" multiple="multiple" style="width: 100%">
                                    @foreach($vacxin as $value)
                                        <option value="{{ $value->id }}" {{ ($value->id == old('vacxin_id')) ? 'selected' : '' }}>{{ $value->name }}</option>
                                    @endforeach
                                </select> --}}
                                {!! Form::select('vacxin_id[]', $vacxin,null, array('class' => 'form-control tagging','multiple','style' => 'width: 100%','id' => 'vacxin_id')) !!}
                                @if ($message = Session::get('error_vacxin'))
                                    <span style="color: red">{{ $message }}</span>
                                @endif
                            </div>
                        </div>
                        @endif
                        @if($tuychinhFormDL->ghichu != 1)
                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>Ghi chú: </strong>
                                {!! Form::textarea('ghichu', null, ['class'=>'form-control'. ($errors->has('ghichu') ? ' is-invalid' : null), 'rows' => 3,'placeholder'=>'ghi chú']) !!}
                                @error('ghichu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endif
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
<script type="text/javascript">
    var url2 = "{{ url('/showBacSiInChuyenKhoa') }}";
    $("select[id='chuyenkhoa_id']").change(function(){
        var chuyenkhoa_id = $("#chuyenkhoa_id").val();
        var token = $("input[name='_token']").val();
        $.ajax({
            url: url2,
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

