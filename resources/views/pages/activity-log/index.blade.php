@extends('pages.layouts.default')
@section('content') 

<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title"><a href="{{ route('activity-log.index') }}">Activity log</a></h4>
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Tables</li>
        </ol>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <div class="btn-group mb-0">
            @can('DlBv106x-delete')
            <a type="button" href="clear-cache" class="btn btn-info mr-2">Clear cache</a>
            @endcan
           
              
        </div>
       
    </div>
</div>
<!--End Page header-->

<div class="row">
    <div class="col-md-12">  
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th> Name</th>
                            <th> Description </th>
                            <th> subject_id </th>
                            <th> causer_id </th>
                            <th> properties </th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($logs as $key=>$value)
                        <tr>
                            <td>{{ $value->log_name }}</td>
                            <td>{{ $value->description }}</td>
                            <td>{{ $value->subject_id }}</td>
                            <td>{{ $value->causer->username }}</td>
                            <td>
                                @if($value->description == 'updated')
                                    @foreach($value->changes()['attributes'] as $key2 => $diff)
                                        {{ '  '.$key2 .': '. $diff }}
                                    @endforeach
                                    <br>
                                    (@foreach($value->changes()['old'] as $key3 => $diff3)
                                        {{ '  '.$key3 .': '. $diff3 }} 
                                    @endforeach)
                                @else
                                    @foreach($value->changes()['attributes'] as $key4 => $diff4)
                                        {{ '  '.$key4 .': '. $diff4 }}
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                       @endforeach
                    </tbody>
                </table>
                {!! $logs->links() !!}
                </div>
            </div>
            
        </div>
    <!-- section-wrapper -->

    </div>
</div>
<!-- Modal -->

@endsection

