<script type="text/javascript">
    var url1 = "{{ url('/showKhungGioInBenhVien') }}";
    $("select[id='benhvien_id']").change(function(){
        var benhvien_id = $("#benhvien_id").val();
        var token = $("input[name='_token']").val();
        $.ajax({
            url: url1,
            method: 'POST',
            data: {
                benhvien_id: benhvien_id,
                _token: token
            },
            success: function(data) {
                $("select[id='khunggio_id'").html('');
                $("select[id='khunggio_id'").prepend("<option value=''>Chọn khung giờ</option>");
                $.each(data, function(key, value){

                    $("select[id='khunggio_id']").append(

                        "<option value='"+value.id+"'>Khung giờ: "+value.name+" | Số lượng: "+value.soluong+"</option>"
                    );
                });
            }
        });
    });
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