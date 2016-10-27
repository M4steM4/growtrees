@extends('layouts/master')

@push('style')
	<link ref="stylesheet" href="#">
@endpush

@push('script')
	<script src=""></script>
@endpush

@section('header')
	<header class="container-fluid">
		<img src="{{ asset('storage/profile_imgs/' . $user->nickname . '.img') }}" alt="프로필 사진">

		<h1>안뇽하세요 {{ $user->name }}님</h1>
		<input type="button" value="로그아웃" onclick="location.href='logout';">
	</header>
@stop

@section('content')
	
@stop

@section('footer')
	
@stop
