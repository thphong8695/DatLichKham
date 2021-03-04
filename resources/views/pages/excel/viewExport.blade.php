<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <style type="text/css">
      .table > tbody > tr > td {
      vertical-align: middle;
      text-align: center;
    }
    .table > thead > tr > th {
        display: flex;
      vertical-align: middle;
      text-align: center;
    }
    </style>
</head>
<body>

<table style="font-family: 'Times New Roman', Times, serif; ">
    <thead>
        <tr>
            <th colspan="16">
                <h1>DANH SÁCH ĐẶT LỊCH {{ strtoupper($tenbenhvien) }}</h1>
            </th>
        </tr>
    </thead>
</table>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>STT</th>
            <th> HỌ TÊN</th>
            <th> PHONE </th>
            @if($namsinh != 0)<th> NĂM SINH </th>@endif
            <th> NGÀY KHÁM </th>
            <th>BỆNH VIỆN</th>
            <th> KHUNG GIỜ </th>
            @if($chuyenkhoa != 0)<th> CHUYÊN KHOA </th>@endif
            @if($bacsi_id != 0)<th> BÁC SĨ </th>@endif
            @if($vacxin_id != 0)<th> VẮC-XIN </th>@endif
            @if($gioitinh != 0)<th> GIỚI TÍNH </th>@endif
            @if($sonha != 0)<th> SỐ NHÀ </th>@endif
            @if($diachi != 0)<th> ĐỊA CHỈ </th>@endif
            @if($province_id != 0)<th> TỈNH THÀNH </th>@endif
            @if($mayte != 0)<th> MÃ Y TẾ </th>@endif
            @if($sobaohiem != 0)<th> SỐ BẢO HIỂM </th>@endif
            @if($ghichu != 0)<th> GHI CHÚ </th>@endif
            @if($user_id != 0)<th> NGƯỜI TẠO </th>@endif
            <th> THỜI GIAN TẠO </th>
        </tr>
    </thead>
    <tbody>
       @foreach($datlichkham as $key=>$value)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $value->name }}</td>
            <td>{{ $value->phone }}</td>
            @if($namsinh != 0)
            <td>{{ $value->namsinh }}</td>
            @endif
            <td>{{ $value->ngaykham->format('d/m/Y') }}</td>
            <td>{{ $value->BenhVienPK ? $value->BenhVienPK->name : '' }}</td>
            <td>{{ $value->KhungGio ? $value->KhungGio->name : '' }}</td>
            @if($chuyenkhoa != 0)
            <td>{{ $value->ChuyenKhoa ? $value->ChuyenKhoa->name : '' }}</td>
            @endif
            @if($bacsi_id != 0)
            <td>{{ $value->BacSi ? $value->BacSi->name : '' }}</td>
            @endif
            @if($vacxin_id != 0)
            <td>
                @foreach($value->VacXin as $keyVX => $valueVX)
                    {!! $valueVX->name.', ' !!}
                @endforeach
            </td>
            @endif
            @if($gioitinh != 0)
            <td>{!! $value->gioitinh == 0 ? 'Nam' : 'Nữ' !!}</td>
            @endif
            @if($sonha != 0)
            <td>{{ $value->sonha }}</td>
            @endif
            @if($diachi != 0)
            <td>{{ $value->diachi }}</td>
            @endif
            @if($province_id != 0)
            <td>{{ $value->Province ? $value->Province->name : '' }}</td>
            @endif
            @if($mayte != 0)
            <td>{{ $value->mayte }}</td>
            @endif
            @if($sobaohiem != 0)
            <td>{{ $value->sobaohiem }}</td>
            @endif
            @if($ghichu != 0)
            <td>{!! $value->ghichu !!}</td>
            @endif
            @if($user_id != 0)
            <td>{{ $value->User ? $value->user->username : '' }}</td>
            @endif
            <td>{{ $value->created_at->format('d/m/Y H:i:s') }}</td>
        </tr>
       @endforeach
    </tbody>
</table>


 </body>
