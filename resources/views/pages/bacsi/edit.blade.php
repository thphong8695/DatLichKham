@extends('pages.layouts.default')
@section('content') 

<!--Page header-->
<div class="page-header mt-3">
    <div class="page-leftheader">
        <h4 class="page-title">Dữ liệu bác sĩ</h4>
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('bac-si.index') }}">Danh sách bệnh bác sĩ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sửa chuyên khoa</li>
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
                <legend>Sửa: {{ $bacSi->name }}</legend>
                <div class="card-options ">
                    <a type="button" href="{{ route('bac-si.index') }}" class="btn btn-success">Back</a>
                </div>
            </div>
          
            <div class="card-body">
            
                {!! Form::model($bacSi, ['method' => 'PATCH','route' => ['bac-si.update', $bacSi->id]]) !!}
                    
                    <div class="row">

                        <div class="col-md-8">
                            <div class="form-group">
                                <strong>Tên bác sĩ: <span style="color: red">*</span></strong>
                                {!! Form::text('name', null, array('placeholder' => 'Tên bác sĩ','class' => 'form-control')) !!}
                                @error('name')
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
                                <strong>Chuyên khoa:</strong>
                                {!! Form::select('chuyenkhoa_id',$chuyenkhoa,app('request')->input('chuyenkhoa_id'),['class'=>'form-control','id'=>'chuyenkhoa_id','placeholder'=>'Chọn chuyên khoa']) !!}
                                
                                @error('chuyenkhoa_id')
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
