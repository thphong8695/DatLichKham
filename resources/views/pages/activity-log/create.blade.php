@extends('pages.layouts.default')
@section('content') 

<!--Page header-->
<div class="page-header mt-3">
    <div class="page-leftheader">
        <h4 class="page-title">Dữ liệu tùy chỉnh khung giờ</h4>
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tuychinh-khunggio.index') }}">Danh sách tùy chỉnh khung giờ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tạo mới tùy chỉnh khung giờ</li>
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
                    <a type="button" href="{{ route('tuychinh-khunggio.index') }}" class="btn btn-success">Back</a>
                </div>
            </div>
         
            <div class="card-body">
            
                {!! Form::open(array('route' => 'tuychinh-khunggio.store','method'=>'POST')) !!}
                    
                    <div class="row">

                        <div class="col-md-8">
                            <div class="form-group">
                                <strong>Ngày: <span style="color: red">*</span></strong>
                                {!! Form::text('ngaydat', null, array('placeholder' => 'Ngày','class' => 'form-control','data-toggle' => 'datepickerNgayHienTai','autocomplete'=>'off')) !!}
                                @error('ngaydat')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <strong>Số lượng: <span style="color: red">*</span></strong>
                                {!! Form::number('soluong', null, array('placeholder' => 'Số lượng','class' => 'form-control')) !!}
                                @error('soluong')
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
                        <div class="col-md-8">
                            <div class="form-group">
                                <strong>Khung giờ: <span style="color: red">*</span></strong>
                                @if(old('benhvien_id'))
                                <select class="form-control" name="khunggio_id" id="khunggio_id">
                                    <option value="">--chọn khung giờ--</option>
                                    @foreach($khunggio as $value)
                                        @if($value->benhvien_id == old('benhvien_id'))
                                        <option {{ old('khunggio_id') == $value->id ? 'selected' : '' }} value="{{ $value->id }}" >Khung giờ: {{ $value->name }} | Số lượng: {{ $value->soluong }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @else
                                <select class="form-control" name="khunggio_id" id="khunggio_id">
                                  
                                </select>
                                @endif
                                @error('khunggio_id')
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
    var url = "{{ url('/showKhungGioInBenhVien') }}";
    $("select[id='benhvien_id']").change(function(){
        var benhvien_id = $("#benhvien_id").val();
        var token = $("input[name='_token']").val();
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                benhvien_id: benhvien_id,
                _token: token
            },
            success: function(data) {
                $("select[id='khunggio_id'").html('');
                $("select[id='khunggio_id'").prepend("<option value=''>--chọn khung giờ--</option>");
                $.each(data, function(key, value){

                    $("select[id='khunggio_id']").append(

                        "<option value='"+value.id+"'>Khung giờ: "+value.name+" | Số lượng: "+value.soluong+"</option>"
                    );
                });
            }
        });
    });
</script>
@endsection