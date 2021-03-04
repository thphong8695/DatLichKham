@extends('pages.layouts.default')
@section('content') 

<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">Dữ liệu thời hạn sử dụng vắc xin</h4>
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Tables</li>
        </ol>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <div class="btn-group mb-0">
                <a type="button" href="{{ route('su-dung-vac-xin.create') }}" class="btn btn-success"><i class="fa fa-plus mr-2"></i>Tạo mới</a>
              
        </div>
       
    </div>
</div>
<!--End Page header-->

<div class="row">
    <div class="col-md-12 col-lg-12">  
        
        <div class="card">
            <div class="card-header">
                <div class="card-options ">
                    {{-- @extends('pages.layouts.partials.alert') --}}
                </div>
            </div>
          
            <div class="card-body">
                <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th> TÊN THỜI HẠN SỬ DỤNG VẮC-XIN </th>
                            <th> SLUG </th>
                            <th>TRẠNG THÁI</th>
                            @can('DlBv106x-delete')<th width="150px">ACTION</th>@endcan
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($sudungvacxin as $value)
                        <tr>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->slug }}</td>
                            <td>
                                <input data-id="{{$value->id}}" class="toggle-class show_confirm_status" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $value->status ? 'checked' : '' }}>
                             </td>
                            @can('DlBv106x-delete')
                            <td>
                                <a class="btn btn-primary" href="{{ route('su-dung-vac-xin.edit',$value->id) }}">Edit</a>
                                {!! Form::open(['method' => 'DELETE','route' => ['su-dung-vac-xin.destroy', $value->id],'style'=>'display:inline']) !!}
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
            url: '/changeStatusSuDungVacXin',
            data: {'status': status, 'id': id},
            success: function(data){
              toastr.success(data.success)
            }
        });
    })
  })
</script>

@endsection
