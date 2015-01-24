@section('navbar')
	@include('users.navbar')
@stop

@section('content')
	<div align='center'>
	{{ Form::open(array('url' => 'users/login', 'role' => 'form', 'style' => 'width: 300px;')) }}
		<h2 style="margin-bomttom: 10px;" align="left">登陆</h2>
		<input type="text" class="form-control" name='username' placeholder='帐号' required autofocus>
		<input type="password" class="form-control" name='password' placeholder='密码' required>
		<button class="btn btn-large btn-primary btn-block" type="submit">登录</button>
	{{ Form::close() }}
	</div>
@stop

@section('footer')
	@include('books.footer')
@stop

@section('scripts')
@stop