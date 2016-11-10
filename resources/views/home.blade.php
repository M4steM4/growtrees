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
	<div id="header" class="container-fluid">
		<div id="logo">자라나라 나무나무</div>
		<ul id="menuList">
			<div id="search" class="dropdown">
				<li class="menu" onclick="search();">
					<a href="javascript:void(0)"><img src="{{ asset('images/search.png') }}" alt="프로젝트 검색" /></a>
				</li>
			</div>
			<div id="searchlist">
				
			</div>
			<div id="profile" class="dropdown">
				<li class="menu dropdown-toggle" data-toggle="dropdown">
					<a href=""><img src="{{ asset('images/profile.png') }}" alt="" /></a>
				</li>
				<ul class="dropdown-menu dropdown-menu-right">
					<li><a href="#" data-toggle="modal" data-target="#profile_info">프로필 정보</a></li>
					<li><a href="#" data-toggle="modal" data-target="#profile_update">프로필 수정</a></li>
				</ul>
			</div>
			<div id="menu" class="dropdown">
				<li class="menu dropdown-toggle" data-toggle="dropdown">
					<a href=""><img src="{{ asset('images/menu.png') }}" alt="" /></a>
				</li>
				<ul class="dropdown-menu dropdown-menu-right">
					<li><a href="#" data-toggle="modal" data-target="#show_requests">요청 확인</a></li>
					<li><a href="{{ route('session.destroy') }}">로그아웃</a></li>
				<!--
					<li><a href="#">ㅁㄴㅁㄴㅇㅁㄴ</a></li>
					<li><a href="#">ㅁㄴㅇㅁㄴㅇㅁㄴㅇ</a></li>
				-->
				</ul>
			</div>
		</ul>
	</div>
@stop

@section('content')
	<div id="main" class="container-fluid">
		<?php
			$cnt = count($projects);
		?>
		@for ($i=0; $i<=$cnt; $i+=3)
			@if($cnt-$i <= 3)
				<div class="row @if ($i == 0) {{ 'margin' }} @endif">
					<div class="col-md-10 section">
						@for ($j=0; $j<$cnt-$i; $j++)
							<div class="col-md-4 flowerpot">
								<a href="{{ route('projects.show', $projects[$i+$j]['token']) }}">
									<img src="{{ asset('images/pot.png') }}" class="pot" alt="">
									<div class="potname">{{ $projects[$i+$j]['name'] }}</div>
								</a>
							</div>
						@endfor

						@if($cnt-$i < 3)
							<div class="col-md-4 flowerpot">
								<a href="#" data-toggle="modal" data-target="#create_project">
									<img src="{{ asset('images/addpot.png') }}" class="pot" alt="">
									<div class="potname">Add Pot!</div>
								</a>
							</div>
						@endif
					</div>
				</div>
			@else
				<div class="row @if ($i == 0) {{ 'margin' }} @endif">
					<div class="col-md-10 section">
						@for ($j=0; $j<3; $j++)
							<div class="col-md-4 flowerpot">
								<a href="{{ route('projects.show', $projects[$i+$j]['token']) }}">
									<img src="{{ asset('images/pot.png') }}" class="pot" alt="">
									<div class="potname">{{ $projects[$i+$j]['name'] }}</div>
								</a>
							</div>
						@endfor
					</div>
				</div>
			@endif
		@endfor
	</div>
@stop

@section('footer')
	<div id="profile_info" class="modal fade" role="dialog">
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
					<div>
						<span class="green col-sm-offset-1 col-sm-2">이름</span> 
						<span class="col-sm-5">{{ $user->name }}</span>
					</div>
					<div>
						<span class="green col-sm-offset-1 col-sm-2">닉네임</span>
                        <span class="col-sm-5">{{ $user->nickname }}</span>
					</div>
					<div>
						<span class="green col-sm-offset-1 col-sm-2">이메일</span> 
						<span class="col-sm-5">{{ $user->email }}</span>
					</div>
					<div>
						<span class="green col-sm-offset-1 col-sm-2">휴대전화</span> 
						<span class="col-sm-5">{{ $user->phone }}</span>
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
                        
					<button class="btn btn-default col-xs-12">
                    	완료
                    </button>
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
	
	<div id="project_info" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<div class="col-sm-offset-1">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">프로젝트 정보</h4>
                    </div>
				</div>
				<div class="modal-body">
					
				</div>
			</div>	
		</div>
	</div>

	<div id="show_requests" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-sm-offset-1">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">요청 확인</h4>
                    </div>
                </div>
		        <div class="modal-body">
					@foreach ($projects as $project)
						@if (isset($project['requests']))
							프로젝트명 {{ $project['name'] }} <br>
							=== 요청 ========== <br>
							@for ($i=0; $i<count($project['requests']); $i++)
								<img src="{{ file_exists(public_path('storage/profile_imgs/'.$project['requests'][$i]['id'])) ? asset('storage/profile_imgs/'.$project['requests'][$i]['id']) : asset('storage/profile_imgs/default') }}"> <br>
								{{ $project['requests'][$i]['name'] }} 
								{{ $project['requests'][$i]['nickname'] }}
								<br>
								<button type="button" onclick="allowResponse('{{ $project['name'] }}', {{ $project['requests'][$i]['id'] }});">
									승인
								</button>
								<button type="button" onclick="denyResponse('{{ $project['name'] }}', {{ $project['requests'][$i]['id'] }});">
									거절
								</button>
								<br>
							@endfor
							=================== <br>
						@endif
					@endforeach
                </div>
            </div>
        </div>
	</div>
@stop
