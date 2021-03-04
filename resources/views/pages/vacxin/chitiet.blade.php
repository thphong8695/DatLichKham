@extends('pages.layouts.default')
@section('content') 

<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title"><a href="{{ route('vac-xin.chitiet') }}">Dữ liệu vắc-xin</a></h4>
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Tables</li>
        </ol>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <div class="btn-group mb-0">
            @can('DlBv106x-delete')
            <a type="button" href="{{ route('thongbao.thongbao_vacxin') }}" class="btn btn-info mr-2">Chỉnh sửa thông báo</a>
            @endcan
        </div>
    </div>
</div>
<!--End Page header-->

<div class="row">
    <div class="col-md-12">  
        <div class="card">
            <div class="card-body">
                @include('pages.layouts.partials.alert')
                {!! Form::open(array('route' => 'vac-xin.chitiet','method'=>'get')) !!}
                <div class="row">
                    <div class="col-md-4 ">
                        <div class="form-group">
                            {!! Form::select('bv',$benhvien,app('request')->input('bv'),['class'=>'form-control ','id'=>'bv','placeholder'=>'Chọn bệnh viện','required']) !!}
                            
                            @error('bv')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="form-group ">
                            <button type="submit" class="btn btn-success ml-2">Search</button>
                        </div>
                    </div>
                </div>
                 {!! Form::close() !!}
                 {!! $thongbao !!}
                <form action="{{ route('vac-xin.update_stt') }}" method="post">
                @csrf
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th> TÊN VẮC-XIN </th>
                            <th> NGỪA BỆNH </th>
                            <th>SỬ DỤNG</th>
                            <th> GIÁ TIỀN </th>
                            <th> MIỄN PHÍ </th>
                            <th>SỐ LƯỢNG</th>
                            <th>ĐÃ ĐẶT</th>
                            <th>CÒN LẠI</th>
                            <th>NGÀY ÁP DỤNG</th>
                            <th> GHI CHÚ </th>
                            @can('DlBv106x-edit')
                            <th width="70px" class="text-center"> STT</th>
                            @endcan
                        </tr>
                    </thead>
                    
                    <tbody>
                       @foreach($vacxin as $value)
                        <tr>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->nguabenh }}</td>
                            <td>{{ $value->SuDungVacXin ? $value->SuDungVacXin->name : '' }}</td>
                            <td class="center">{{($value->giatien)}}</td>
                            <td class="center">
                                @if($value->mienphi == 1)
                                <i class="fa fa-check-circle fa-2x"></i>
                                @endif
                            </td>
                            <td class="center">{{$value->soluong}}</td>
                            <td class="center">{{ $value->DatLichKham->count() }}</td>
                            <td class="center">
                                @if($value->soluong != null || $value->soluong != 0)
                                    {{ $value->soluong -  $value->DatLichKham->count()}}
                                @endif
                            </td>
                            <td class="center">{{ $value->ngayapdung->format('d-m-Y') }}</td>
                            <td class="center">{{$value->ghichu}}</td>
                            @can('DlBv106x-edit')
                            <td class="text-center">   
                                <input type="text" name="stt[]" class="form-control" value="{{ $value->stt }}">
                                <input type="hidden" name="id[]" value="{{ $value->id }}" class="form-control">
                            </td>
                            @endcan
                        </tr>
                       @endforeach
                    </tbody>
                </table>
                @can('DlBv106x-edit')
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                @endcan
                </form>
            </div>
            
        </div>
    <!-- section-wrapper -->

    </div>
</div>
<!-- Modal -->

@endsection
@section('script')


@endsection
