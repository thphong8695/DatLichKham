@extends('pages.layouts.default')
@section('content') 

<!--Page header-->
<div class="page-header mt-3">
    <div class="page-leftheader">
        <h4 class="page-title">Tạo mới đặt lịch khám</h4>
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dat-lich-kham.index') }}">Danh sách đặt lịch khám</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tạo mới lịch khám: bước 2</li>
        </ol>
    </div>
    
</div>
<!--End Page header-->
<div class="row">
    <div class="col-md-12 col-lg-12">  
        
        <div class="card">
            
            <div class="card-header">
                <legend>Step 2: {{ $tenbenhvien->name }}</legend>
                <div class="card-options ">
                    <a type="button" href="{{ route('dat-lich-kham.createStep1') }}" class="btn btn-success">Back to step 1</a>
                </div>
            </div>
           
            <div class="card-body">
                {{-- <i style="color: red">*lưu ý: chọn bệnh viện -> ngày khám -> sau đó nhập các thông tin còn lại.</i> --}}

                {{-- @include('pages.layouts.partials.alert') --}}
                {!! Form::open(array('route' => 'dat-lich-kham.PostcreateStep2','method'=>'POST','class' =>'mt-3')) !!}
                    
                    <div class="row">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <strong>Ngày Khám: <span style="color: red">*</span></strong>
                                {!! Form::text('ngaykham', null, array('placeholder' => 'Ngày khám','class' => 'form-control'. ($errors->has('ngaykham') ? ' is-invalid' : null),'data-toggle' => 'datepickerNgayKham','autocomplete'=>'off','readonly')) !!}
                                @error('ngaykham')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                      
                        
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
   var datesForDisable = {!! $ngayoff !!};
    $(function() {
        $('[data-toggle="datepickerNgayKham"]').datepicker({
            format: 'dd-mm-yyyy',
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

