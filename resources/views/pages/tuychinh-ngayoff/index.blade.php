@extends('pages.layouts.default')
@section('content') 

<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title"><a href="{{ route('tuychinh-ngayoff.index') }}">Dữ liệu tùy chỉnh ngày off</a></h4>
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Tables</li>
        </ol>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <div class="btn-group mb-0">
                <a type="button" href="{{ route('tuychinh-ngayoff.create') }}" class="btn btn-success"><i class="fa fa-plus mr-2"></i>Tạo mới</a>
              
        </div>
       
    </div>
</div>
<!--End Page header-->

<div class="row">
    <div class="col-md-12">  
        <div class="card">
            {!! Form::open(array('route' => 'tuychinh-ngayoff.index','method'=>'get')) !!}
            <div class="card-header">
                <div class="row">
                    <div class="col-md-12 d-flex">
                        <div class="form-group d-flex">
                            <strong>Bệnh viện:</span></strong>
                            {!! Form::select('bv',$benhvien,app('request')->input('bv'),['class'=>'form-control ','id'=>'bv','placeholder'=>'Chọn bệnh viện','required']) !!}
                            
                            @error('bv')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group ">
                            <button type="submit" class="btn btn-success ml-2">Search</button>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
            <div class="card-body">
                <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th> NGÀY </th>
                            <th>BỆNH VIỆN</th>
                            <th> TRẠNG THÁI </th>
                            @can('DlBv106x-delete')<th width="150px">ACTION</th>@endcan
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($tuychinh_off as $key=>$value)
                        <tr>
                            <td>{{ date('d/m/Y',strtotime($value->ngayoff)) }}</td>
                            <td>{{ $value->BenhVienPK->name }}</td>
                            <td>
                                <input data-id="{{$value->id}}" class="toggle-class show_confirm_status" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $value->status ? 'checked' : '' }}>
                             </td>
                            @can('DlBv106x-delete')
                            <td>
                                <a class="btn btn-primary" href="{{ route('tuychinh-ngayoff.edit',$value->id) }}">Edit</a>
                                {!! Form::open(['method' => 'DELETE','route' => ['tuychinh-ngayoff.destroy', $value->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-circle show_confirm']) !!}
                                {!! Form::close() !!}

                            </td>
                            @endcan
                        </tr>
                       @endforeach
                    </tbody>
                </table>
                
                </div>
            </div>
            
        </div>
    <!-- section-wrapper -->

    </div>
</div>
<!-- Modal -->

@endsection
@section('script')
<!-- status confirm -->
<script type="text/javascript">
    $('.show_confirm_status').click(function(e) {
        if(!confirm('Bạn có chắc muốn thay đổi trạng thái?')) {
            e.preventDefault();
        }
    });
</script>
<script>
  $(function() {
    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0; 
        var id = $(this).data('id'); 
         
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/changeStatusTuyChinhOff',
            data: {'status': status, 'id': id},
            success: function(data){
              toastr.success(data.success)
            }
        });
    })
  })
</script>

@endsection
