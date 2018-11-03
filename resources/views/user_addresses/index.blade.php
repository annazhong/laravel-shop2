@extends('layouts.app')
@section('title', '收货地址列表')

@section('content')
<div class="row">
	<div class="col-lg-10 col-lg-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">收货地址列表
			<a href="{{ route('user_addresses.create') }}" class="pull-right">新增收货地址</a>
			</div>

			<div class="panel-body">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>收货人</th>
							<th>地址</th>
							<th>邮编</th>
							<th>电话</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						@foreach($addresses as $address)
						<tr>
							<td>{{ $address->contact_name }}</td>
							<td>{{ $address->full_address }}</td>
							<td>{{ $address->zip }}</td>
							<td>{{ $address->contact_phone }}</td>
							<td>
          					<a class="btn btn-primary" href="{{ route('user_addresses.edit', ['user_address' => $address->id]) }}">修改</a>
<!-- 							<form action="{{ route('user_addresses.delete', ['user_address' => $address->id]) }}" method="post" style="display: inline-block"> -->
<!-- 							{{ csrf_field() }}
							{{ method_field('DELETE') }} -->
							<button class="btn btn-danger btn-del-address" data-id="{{ $address->id}}" type="button">删除</button>
							<!-- </form> -->
        					</td>
 
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection


<!-- update delete form as delete by ajax -->
@section('scriptsAfterJs')
<script>
$(document).ready(function() {

  $('.btn-del-address').click(function() {

    // 获取按钮上 data-id 属性的值，也就是地址 ID
    var id = $(this).data('id');
    // 调用 sweetalert
    swal({
        title: "确认要删除该地址？",
        icon: "warning",
        buttons: ['取消', '确定'],
        dangerMode: true,
      })
    .then(function(willDelete) {

      if (!willDelete) {
        return;
      }

      //ajax call for delete
      axios.delete('/user_addresses/' + id)
        .then(function () {
          location.reload();
        })
    });
  });
});
</script>
@endsection