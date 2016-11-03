@extends('layouts.master')

@push('style')
	<link rel="stylesheet" href="/css/project.css">
@endpush

@push('script')
	<script src="/js/project.js"></script>
	<script src="/js/project_btn.js"></script>
@endpush

@section('meta')
	<meta name="_token" content="{{ csrf_token() }}">
	<meta name="key_u" content="{{ encrypt($user->id) }}">
	<meta name="key_p" content="{{ encrypt($project->id) }}">
@stop

@section('header')
	<header class="container-fluid">
		<a class="col-xs-offset-1" href="{{ route('home') }}" id="logo">
			<img src="{{ asset('images/title.png') }}" alt="자라나라나무나무" width="150">
		</a>
	</header>
@stop

@section('content')
	<div id="content_wrapper" class="row">
		<div>
			<nav class="navbar">
				<div id="profile">
					<img src="{{ file_exists(public_path('storage/profile_imgs/'.$user->id)) ? asset('storage/profile_imgs/'.$user->id) : asset('storage/profile_imgs/default') }}" alt="profile_image" width="60" height="60">
					<div>
						<span class="green">{{ $user->name }}</span> <br>
						{{ $user->nickname }}
					</div>
				</div>
				<div class="clearfix"></div>

				<div id="menubar">
					<ul class="nav navbar-nav">
						<li><a href="#">캘린더</a></li>
						<li><a href="#">역할분담표</a></li>
						<li><a href="#">To do list</a></li>
						<li><a href="#">연락처</a></li>
					</ul>
				</div>

				<div id="user_menubar">
					<ul class="nav navbar-nav">
						<li><a href="#" class="green">도움말</a></li>
						<li><a href="#" class="green">설정</a></li>
						<li><a href="{{ route('session.destroy') }}" class="green">로그아웃</a></li>
					</ul>
				</div>
			</nav>
		</div>

		<div id="tree">
			<img src="{{ asset('images/tree.png') }}" alt="나무" width="500" height="500">
		</div>

		<div id="sun">
			<img src="{{ asset('images/sun.png') }}" alt="D-Day" width="100" height="100">
		</div>

		<div id="waterspread">
			<img src="{{ asset('images/waterspread.png') }}" width="100" height="60">
		</div>

		<div id="chat">
			<div id="message_wrapper">
			
			</div>
			<form>
				<input type="text" name="message" class="form-control" autocomplete="off">
				<button type="button">
					 <span class="glyphicon glyphicon-send"></span>
				</button> 
			</form>
		</div>
	</div>
@stop
