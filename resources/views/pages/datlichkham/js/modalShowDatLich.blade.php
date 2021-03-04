<script type="text/javascript">  
  $(document).ready(function(){
    $('body').on('click', '#showChiTiet', function () {
      var datlichkham_id = $(this).data('id');
      $.get("{{ route('dat-lich-kham.index') }}" +'/' + datlichkham_id, function (data) {
            $('#modelShowChiTiet').modal('show');
            $('#datlichkham_id').val(data.id);
            $('#name_text').text(data['datlichkham'].name);
            if(data['datlichkham'].ngaykham != null)
            {
                $('#ngaykham_text').text($.datepicker.formatDate('dd/mm/yy', new Date(data['datlichkham'].ngaykham)));
            }
            $('#phone_text').text(data['datlichkham'].phone);
            $('#khunggio_id_text').text(data['khunggio'].name);
            $('#benhvien_id_text').text(data['tenbenhvien'].name);
            //check
            
            $('#namsinh_text').text(data['datlichkham'].namsinh);
            
            
            var gioitinh = data['datlichkham'].gioitinh == 1 ? 'Nam' : 'Nữ';
            $('#gioitinh_text').text(gioitinh);
            $('#sonha_text').text(data['datlichkham'].sonha);
            $('#diachi_text').text(data['datlichkham'].diachi);
            $('#mayte_text').text(data['datlichkham'].mayte);
            $('#sobaohiem_text').text(data['datlichkham'].sobaohiem);
            $('#ghichu_text').text(data['datlichkham'].ghichu);
            if(data['chuyenkhoa'] != null)
            {
                $('#chuyenkhoa_id_text').text(data['chuyenkhoa'].name);
            }
            if(data['bacsi'] != null)
            {
                $('#bacsi_id_text').text(data['bacsi'].name);
            }
            if(data['province'] != null)
            {
                $('#province_id_text').text(data['province'].name);
            }
            $('#user_id_text').text(data['user'].username);
            if(data['vacxin'] != null)
            {
                $('#vacxin_text').html("");
                $.each(data['vacxin'], function (key, val) {
                    $('#vacxin_text').append("<span class='badge badge-info'>"+val+"</span> ")
                });
            }
            // log
            $('#activity_log').html("<thead><th> Description </th><th> Username </th><th> Thời gian </th></thead>");
            $.each(data['activitylog'], function (key, val) {
                    
                    $('#activity_log').append("<tr>"+
                        "<td>"+val.description+"</td>"+
                        "<td>"+val.user.username+"</td>"+
                        "<td>"+new Date(val.created_at).toLocaleString()+"</td>"+
                    +"</tr>")
                });

      })
    });
   
  });
</script>
