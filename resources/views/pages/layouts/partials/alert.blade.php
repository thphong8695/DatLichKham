@if(count($errors)>0)
<div class="alert alert-danger" role="alert">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    @foreach($errors->all() as $err)
    {{ $err }}<br>
    @endforeach

</div>
@endif
@if(session('error'))
<div class="alert alert-danger" role="alert">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Thông Báo! </strong>{{ session('error') }}
</div>
@endif
@if(session('success'))
<div class="alert alert-success" role="alert">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Thông Báo! </strong>{{ session('success') }}
</div>
@endif