@extends('layouts/master')

@push('style')
	<link rel="stylesheet" href="css/home.css">
	<link rel="stylesheet" href="/css/imagecrop/imgareaselect-animated.css">
@endpush

@push('script')
	<script src="/js/imagecrop/jquery.imgareaselect.pack.js"></script>
	<script src="js/home.js"></script>
	<script src="js/home_btn.js"></script>
@endpush

@section('meta')
	<meta name="_token" content="{{ csrf_token() }}">
@endsection

@section('header')
	<header class="container-fluid">
		<ul class="nav navbar-nav">
			<li> <a data-toggle="modal" data-target="#profile"><span class="glyphicon glyphicon-user"></span></a> </li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li> <a href="#"><span class="glyphicon glyphicon-search"></span></a> </li>
			<li> <a href="#"><span class="glyphicon glyphicon-bell"></span></a> </li>
		</ul>
		<div class="clearfix"></div>
		<div class="text-right">
                        <a href="logout">로그아웃</a>
                </div>
	</header>
@stop

@section('content')
	
@stop

@section('footer')
	<div id="profile" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<div class="col-sm-offset-1">
	                                	<button type="button" class="close" data-dismiss="modal">&times;</button>
        	                        	<h4 class="modal-title">내 프로필</h4>
                	                </div>
				</div>
				<div class="modal-body row">
					<div class="col-sm-offset-1 col-sm-3 col-xs-12">
						<img id="profile_image" src="{{ asset('storage/profile_imgs/' . $user->nickname . '.img') }}" alt="프로필 사진">
					</div>
					<div class="col-sm-offset-1 col-sm-7 col-xs-12 profile_info">
						이름 : {{ $user->name }}
					</div>
					<div name="nickname" class="col-sm-offset-1 col-sm-7 col-xs-12 profile_info">
						닉네임 : {{ $user->nickname }}
					</div>
					<div name="email" class="col-sm-offset-1 col-sm-7 col-xs-12 profile_info">
						이메일 : {{ $user->email }}	
					</div>
					<div name="phone" class="col-sm-offset-1 col-sm-7 col-xs-12 profile_info">
						휴대전화[연락처] : {{ $user->phone }}
					</div>
					<div class="col-xs-12">
						<button class="btn btn-default col-xs-12">
        	        	                       	수정              
	        	        	        </button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="profile_update" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<div class="col-sm-offset-1">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">내 프로필(수정)</h4>
 	                                </div>
				</div>
				<div class="modal-body">
					<form class="row">
						<label for="profile_image" class="col-sm-offset-1 col-xs-12 notice control-label"></label>
						<div id="preview_wrapper" class="col-sm-offset-1 col-sm-10 col-xs-12">
							<input type="file" name="profile_image" accept="image/*">
							<img id="preview" src="{{ asset('storage/profile_imgs/'.$user->nickname.'.img') }}" alt="프로필 사진">
							<div id="tooltip">
								<span class="glyphicon glyphicon-camera"></span>
								&nbsp;클릭
							</div>
						</div>
						<div class="form-group col-sm-offset-1 col-sm-10 col-xs-12">
							<input type="text" class="form-control" value="이름 : {{ $user->name }}" disabled>
						</div>
						<div class="form-group col-sm-offset-1 col-sm-10 col-xs-12">
							<label for="nickname" class="col-xs-12 notice control-label"></label>
							<input type="text" class="form-control" value="기존 닉네임 : {{ $user->nickname }}" name="nickname">
						</div>
						<div class="form-group col-sm-offset-1 col-sm-10 col-xs-12">
							<label for="email" class="notice control-label"></label>
							<input type="text" class="form-control" value="기존 이메일 : {{ $user->email }}" name="email">
						</div>
						<div class="form-group col-sm-offset-1 col-sm-10 col-xs-12">
							<label for="phone" class="notice control-label"></label>
							<input type="text" class="form-control" value="기존 연락처 : {{ $user->phone }}" name="phone">
						</div>
						<div class="form-group col-sm-offset-1 col-sm-10 col-xs-12">
							<label for="password" class="notice control-label"></label>
							<input type="text" class="form-control" value="비밀번호 입력" name="password">
						</div>
	
						<input type="hidden" name="x1" value="0">
						<input type="hidden" name="y1" value="0">
						<input type="hidden" name="size" value="250">

                                              	<button type="button" class="btn btn-default col-xs-12">
                                                       	완료
                                               	</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div id="image_edit" class="modal fade" role="dialog">
                <div class="modal-dialog">
                        <div class="modal-content">
                                <div class="modal-header">
                                        <div class="col-sm-offset-1">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">이미지 편집</h4>
                                                * 모바일 환경에서는 편집이 불가능합니다.
                                        </div>
                                </div>
                                <div class="modal-body row">
                                	<div class="col-sm-offset-1 col-sm-10 col-xs-12 text-center">
                                		<img id="selected_image" src="" alt="profile_image" width="250" height="250">
                                	</div>
                                
                                	<div class="col-xs-12">
						<button class="btn btn-default col-xs-12">
                                                        완료
	                                        </button>
					</div>
                                </div>
                        </div>
                </div>
	</div>
@stop
