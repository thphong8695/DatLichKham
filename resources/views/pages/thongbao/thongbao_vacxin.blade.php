@extends('pages.layouts.default')
@section('content') 

<!--Page header-->
<div class="page-header mt-3">
    <div class="page-leftheader">
        <h4 class="page-title">Thông báo vắc-xin</h4>
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa thông báo vắc-xin</li>
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
            <div class="card-body">
                {!! Form::open(array('route' => 'thongbao.update','method'=>'POST')) !!}
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="form-group">
                                <strong>Thông báo vắc-xin: </strong>
                                {!! Form::textarea('thongbao_vacxin', $thongbao->thongbao_vacxin, ['rows' => 2, 'cols' => 55, 'style' => 'resize:none', 'class' => 'form-control ','placeholder' => 'Thông báo đặt lịch khám','id'=>'basic-example']) !!}
                                @error('thongbao_vacxin')
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
    tinymce.init({
      selector: 'textarea#basic-example',
      height: 300,
      
    });

</script>
@endsection
