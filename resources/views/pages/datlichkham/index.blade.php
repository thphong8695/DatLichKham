@extends('pages.layouts.default')
@section('content') 

<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title"><a href="{{ route('dat-lich-kham.index') }}">Dữ liệu Đặt lịch</a></h4>
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Tables</li>
        </ol>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <div class="btn-group mb-0">
            @can('DlBv106x-delete')
            <a type="button" href="{{ route('thongbao.thongbao_datlich') }}" class="btn btn-info mr-2">Chỉnh sửa thông báo</a>
            @endcan
            <a type="button" href="{{ route('dat-lich-kham.createStep1') }}" class="btn btn-success"><i class="fa fa-plus mr-2"></i>Tạo mới</a>
              
        </div>
       
    </div>
</div>
<!--End Page header-->
<div class="row">
    <div class="col-md-12">  
        <div class="card">
            <div class="card-body">
                    {!! $thongbao !!}
            </div>
            <div class="card-body">
                {!! Form::open(array('route' => 'dat-lich-kham.index','method'=>'get')) !!}
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::text('name', app('request')->input('name'), array('placeholder' => 'Họ Tên','class' => 'form-control')) !!}
                            @error('name')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::number('phone', app('request')->input('phone'), array('placeholder' => 'Số điện thoại','class' => 'form-control')) !!}
                            @error('phone')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::text('ngaykham', app('request')->input('ngaykham'), array('placeholder' => 'Ngày khám','class' => 'form-control','data-toggle' => 'datepickerNgayHienTai','autocomplete'=>'off')) !!}
                            @error('ngaykham')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::select('bv',$benhvien,app('request')->input('bv'),['class'=>'form-control','id'=>'benhvien_id','placeholder'=>'Chọn bệnh viện']) !!}
                            
                            @error('bv')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control" name="kg" id="khunggio_id">
                                <option value="">Chọn khung giờ</option>
                                @if(app('request')->input('bv'))
                                    
                                    @foreach($khunggio as $value)
                                        <option {{ app('request')->input('kg') == $value->id ? 'selected' : '' }} value="{{ $value->id }}" >Khung giờ: {{ $value->name }} | Số lượng: {{ $value->soluong }}</option>
                                    @endforeach
                                @endif
                                </select>
                            
                            @error('kg')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::select('ck',$chuyenkhoa,app('request')->input('ck'),['class'=>'form-control','id'=>'chuyenkhoa_id','placeholder'=>'Chọn chuyên khoa']) !!}
                            
                            @error('ck')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 d-flex justify-content-center">
                        <div class="form-group ">
                            <button type="submit" class="btn btn-info ml-2">Search</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
                
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th> HỌ TÊN</th>
                            <th> PHONE </th>
                            <th> NGÀY KHÁM </th>
                            <th> KHUNG GIỜ </th>
                            {{-- <th> CHUYÊN KHOA </th> --}}
                            <th>BỆNH VIỆN</th>
                            <th @can('DlBv106x-delete') width="300px" @endcan >ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                       @forelse($datlichkham as $value)
                        <tr>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->phone }}</td>
                            <td>{{ $value->ngaykham->format('d/m/Y') }}</td>
                            
                            <td>{{ $value->KhungGio ? $value->KhungGio->name : '' }}</td>
                            {{-- <td>{{ $value->ChuyenKhoa ? $value->ChuyenKhoa->name : '' }}</td> --}}
                            <td>{{ $value->BenhVienPK ? $value->BenhVienPK->name : '' }}</td>
                            
                            <td>
                                <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $value->id }}" data-original-title="Edit" id="showChiTiet" class="btn btn-info"><i class="fa fa-eye mr-2"></i>Chi tiết</a>
                                @canany(['DlBv106x-delete','DlBv106x-edit'])
                                <a class="btn btn-primary" href="{{ route('dat-lich-kham.edit',$value->id) }}">Edit</a>
                                <a class="btn btn-secondary {{ $value->TinNhan == null ? 'disabled' : '' }}" href="{{ $value->TinNhan != null ? route('dat-lich-kham.editSms',$value->TinNhan->id) : '' }}">SMS</a>
                                {!! Form::open(['method' => 'DELETE','route' => ['dat-lich-kham.destroy', $value->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-circle show_confirm']) !!}
                                {!! Form::close() !!}
                                @endcan
                            </td>
                            
                        </tr>
                       @empty
                            <tr>
                                <td colspan="7"><i>Không có dữ liệu được tìm thấy!</i></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {!! $datlichkham->links() !!}
            </div>
            
        </div>
    <!-- section-wrapper -->

    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modelShowChiTiet" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <input type="hidden" name="id" id="datlichkham_id">
          <div class="modal-header">
                <h2 class="modal-title">Chi tiết </h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
          </div> 
          <div class="modal-body row">
            <div class="col-md-12">
                <legend class="d-flex justify-content-center">Thông tin đặt lịch khám</legend>
                <table width="100%" class="table table-striped table-bordered">
                    <tr>
                        <td>
                            <strong>Bệnh viện:</strong>
                            <p><span id="benhvien_id_text"></span></p>
                        </td>
                        <td>
                            <strong>Ngày Khám:</strong>
                            <p><span id="ngaykham_text"></span></p>
                        </td>
                        <td>
                            <strong>Khung giờ:</strong>
                            <p><span id="khunggio_id_text"></span></p>
                        </td>
                        
                    </tr>
                    <tr>
                        <td>
                            <strong>Họ tên: </strong>
                            <p><span id="name_text"></span></p>
                        </td>
                        <td>
                            <strong>Số điện thoại: </strong>
                            <p><span id="phone_text"></span></p>
                        </td>
                        
                        <td>
                            <strong>Năm Sinh: </strong>
                            <p><span id="namsinh_text"></span></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Số nhà:</strong>
                            <p><span id="sonha_text"></span></p>
                        </td>
                        <td>
                            <strong>Địa chỉ: </strong>
                            <p><span id="diachi_text"></span></p>
                        </td>
                        <td>
                            <strong>Tỉnh thành: </strong>
                            <p><span id="province_id_text"></span></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Chuyên khoa:</strong>
                            <p><span id="chuyenkhoa_id_text"></span></p>
                        </td>
                        <td >
                            <strong>vắc-xin:</strong>
                            <p><span id="vacxin_text"></span></p>
                        </td>
                        <td >
                            <strong>Bác sĩ:</strong>
                            <p><span id="bacsi_id_text"></span></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Giới tính: </strong>
                            <p><span id="gioitinh_text"></span></p>
                        </td>
                        <td id="mayte_td">
                            <strong>Mã y tế:</strong>
                            <p><span id="mayte_text"></span></p>
                        </td>
                        <td>
                            <strong>Số bảo hiểm: </strong>
                            <p><span id="sobaohiem_text"></span></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <strong>Ghi chú:</strong>
                            <p><span id="ghichu_text"></span></p>
                        </td>
                        <td >
                            <strong>User tạo:</strong>
                            <p><span id="user_id_text"></span></p>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-12">
                <legend class="d-flex justify-content-center">History Log</legend>
                <table id="activity_log" width="100%" class="table table-striped table-bordered">
                    <thead>
                        <th> Description </th>
                        <th> Username </th>
                        <th> Created_at </th>
                    </thead>
                </table>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
          
          </div>
      </div>
  </div>
</div>
@endsection
@section('script')

<script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
@include('pages.datlichkham.js.modalShowDatLich')
@include('pages.datlichkham.js.showChuyenKhoaKhungGio')

@endsection
