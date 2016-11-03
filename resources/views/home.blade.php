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
	<!-- Top menubar -->
	<nav class="navbar navbar-inverse menu">
                <div class="container-fluid">
                        <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand logo" href="{{ route('home') }}">자라나라 나무나무</a>
                        </div>
                        <div class="collapse navbar-collapse" id="myNavbar">
                                <ul class="nav navbar-nav navbar-right">
                                        <li><a href="" data-toggle="modal" data-target="#profile"><div class="glyphicon glyphicon-user"><div class="badge">5</div></div></a></li>
                                        <li><a href="#"><div class="glyphicon glyphicon-search"></div></a></li>
                                        <li><a href="#"><div class="glyphicon glyphicon-bell"><div class="badge">5</div></div></a></li>
                                        <li><a href="#"><div class="glyphicon glyphicon-th-list"></div></a></li>
                                </ul>
                        </div>
		</div>
	</nav>
@stop

@section('content')
	<!-- Main Section -->
	<div id="main" class="container-fluid">
		<div class="row">
			@foreach ($projects as $project)
				<div class="col-md-4 col-sm-4 col-xs-12 flowerpotcase">
				<a href="{{ route('projects.show', $project['token']) }}">
					<div class="flowerpot">
						<!-- Plant pot -->
						<div class="pot pot-bot">
							<div class="shadow"></div>
							<div class="pot pot-shadow"></div>
							<div class="pot pot-top">
								<p class="pottext">
									{{ $project['name'] }}
									@if (!strcmp($user->id, $project['author']))
										[admin]	
									@endif
								</p>
							</div>
							<div class="sign-top">1</div>
							<div class="sign-bottom"></div>
							<!-- Plant -->
							<div class="plant">
								<div class="leaf leaf-1"></div>
								<div class="leaf leaf-2"></div>
								<div class="leaf leaf-3"></div>
								<div class="leaf leaf-4"></div>
								<div class="head">
									<!--div class="face"></div-->
									<ul>
										<li></li>
										<li></li>
										<li></li>
										<li></li>
										<li></li>
										<li></li>
										<li></li>
										<li></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					</a>
				</div>
			@endforeach

			<div id="add" class="col-md-4 col-sm-4 col-xs-12 flowerpotcase">
				<a data-toggle="modal" data-target="#create_project">
					<div id="addpot" class="flowerpot">
						<div class="block block-col"></div>
						<div class="block block-row"></div>
					</div>
				</a>
			</div>
			
			@for ($i=0; $i < 2-(count($projects)%3); $i++)
				<div class="col-md-4 col-sm-4 col-xs-12 flowerpotcase">
				</div>
			@endfor
		</div>
	</div>
	<!-- Footer -->
	<div id="footer" class="col-md-12">
		<div class="bookshelf">
	        <div class="book book-green">
	            <h2>@copyright by junyongJJang!</h2>
	        </div>
	    </div>
	</div>
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
						<img id="profile_image" src="{{ file_exists(public_path('storage/profile_imgs/'.$user->id)) ? asset('storage/profile_imgs/'.$user->id) : asset('storage/profile_imgs/default') }}" alt="프로필 사진">
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
							<img id="preview" src="{{ file_exists(public_path('storage/profile_imgs/'.$user->id)) ? asset('storage/profile_imgs/'.$user->id) : asset('storage/profile_imgs/default') }}" alt="프로필 사진">
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

	<div id="create_project" class="modal fade" role="dialog">
                <div class="modal-dialog">
                        <div class="modal-content">
                                <div class="modal-header">
                                        <div class="col-sm-offset-1">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">프로젝트 생성</h4>
                                        </div>
                                </div>
                                <div class="modal-body">
                                	<form class="row">
						<div class="form-group col-sm-offset-1 col-sm-10 col-xs-12">
                                                        <label for="project_name" class="notice control-label"></label>
                                                        <input type="text" class="form-control" value="프로젝트 이름" name="project_name">
                                                </div>
						<div class="form-group col-sm-offset-1 col-sm-10 col-xs-12">
                                                        <label for="due_date" class="notice control-label"></label>
                                                        <input type="text" class="form-control" value="마감 날짜" name="due_date" min="{{ date('Y-m-d') }}">
                                                </div>
						<div class="form-group col-sm-offset-1 col-sm-10 col-xs-12">
							<label for="description" class="notice control-label"></label>
							<textarea class="form-control" name="description" rows="5" value="프로젝트 내용">프로젝트 내용</textarea>
						</div>

						<button type="button" class="btn btn-default col-xs-12">
                                                        생성
                                                </button>
					</form>
                                </div>
                        </div>
                </div>
        </div>
@stop
