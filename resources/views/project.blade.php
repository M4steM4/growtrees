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
		<div id="logo">
			<a href="{{ route('home') }}" id="logo">
				<img src="{{ asset('images/title.png') }}" alt="자라나라나무나무" width="150">
			</a>
		</div>
	</header>
@stop

@section('content')
	<div id="content_wrapper" class="row">
		<div>
			<nav class="navbar">
				<div>
					<h4 class="green">{{ $project->name }}</h4>
				</div>
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
						<li><a href="javascript:void(0);" onclick="hideSideMenu(); showflex('calender');">캘린더</a></li>
						<li><a href="javascript:void(0)" onclick="hideSideMenu(); rollon();">역할분담표</a></li>
						<li><a href="javascript:void(0)" onclick="hideSideMenu(); todoliston();">To do list</a></li>
						<li><a href="javascript:void(0);" onclick="hideSideMenu(); show('office');">연락처</a></li>
					</ul>
				</div>

				<div id="user_menubar">
					<ul class="nav navbar-nav">
						<li><a href="#" class="green" data-toggle="modal" data-target="#help">도움말</a></li>
						<li><a href="#" class="green" data-toggle="modal" data-target="#setting">설정</a></li>
						<li><a href="{{ route('session.destroy') }}" class="green">로그아웃</a></li>
					</ul>
				</div>
			</nav>
		</div>

		<!-- calender -->
		<div id="calender" class="sidemenu">
			<div id="scadule">
				<div class="daytitle">03</div>
				<div class="daysub">목요일</div>
				<div class="deadlinetime">마감 24시간 전</div>
				<div class="daycheck">쳌 쳌</div>
				<div id="minichattingform">
					<div class="minichat">
						<img src="assets/img/sun.png" alt="">
						<div><strong>user01</strong>text text text text</div>
					</div>
					<div class="minichat">
						<img src="assets/img/sun.png" alt="">
						<div><strong>user01</strong>text text text text</div>
					</div>
					<div class="minichat">
						<img src="assets/img/sun.png" alt="">
						<div><strong>user01</strong>text text text text</div>
					</div>
					<div class="minichat">
						<img src="assets/img/sun.png" alt="">
						<div><strong>user01</strong>text text text text</div>
					</div>
				</div>
				<div class="miniform">
					<input type="text" class="miniinput" placeholder="댓글 입력" />
					<button>작성</button>
				</div>
			</div>
			<div class="calendermonth">
				<div class="monthlist">
					<div class="month">10월</div>
					<div class="month month-active">11월</div>
					<div class="month">12월</div>
					<a href="javascript:void(0);" id="y" onclick="closeflex();">x</a>
				</div>
				<div class="day">
					
				</div>
			</div>
		</div>
		<!--roll divide -->
		<div id="roll" class="sidemenu">
			<div id="divisiontable">
				<div class="divisiontitle">역할 분담표</div>
				<div class="divisionuser">
					<img src="{{ file_exists(public_path('storage/profile_imgs/'.$user->id)) ? asset('storage/profile_imgs/'.$user->id) : asset('storage/profile_imgs/default') }}" alt="프로필사진" class="userimg">
					<p><strong>{{ $user->name }}</strong><br />{{ $user->nickname }}</p>
				</div>
				<div id="rolldivider"></div>
				<ul>
					@for ($i=0; $i<count($user['roll']); $i++)
						<li class="rolldata" data-idx="{{ $i }}">{{ $user['roll'][$i] }}</li>
					@endfor
				</ul>
				<div class="divisioninputform">
					<input type="text" name="roll" class="divisioninput" placeholder="추가할 사항을 입력하세요.">
					<button class="divisionbutton" onclick="addRoll();">추가</button>
				</div>
			</div>
			<div id="userroll">
				<a href="javascript:void(0);" id="z" onclick="rollout();">x</a>
				
				@foreach ($members as $member)
					<div class="usersection">
						<div class="rollname">
							<img src="{{ file_exists(public_path('storage/profile_imgs/'.$member->id)) ? asset('storage/profile_imgs/'.$member->id) : asset('storage/profile_imgs/default') }}" alt="프로필 사진">
							<p><strong>{{ $member->name }}</strong><br />{{ $member->nickname }}</p>
						</div>
						<div class="rollprofile">
							<ul class="padding" @if ($member->id == $user->id) id="user_roll" @endif>
								@foreach ($member['roll'] as $roll)
									<li class="rollprofilelist">{{ $roll }}</li>
								@endforeach
							</ul>
						</div>
					</div>
				@endforeach
			</div>
		</div>
		<!-- to do list -->
		<div id="todolist" class="sidemenu">
			<div id="green" class="todolistsection">
				<div class="todolisttitle todolistmargin">To do list</div>
				<div class="todolisttitle greentitle">완료 목록</div>
				<div class="todolistcheck">
					<div class="todolistdata">
						<img src="assets/img/check.png" alt="">
						<p><strong>메인페이지 구현 및 기능</strong><br />2016 11 03</p>
					</div>
					<div class="todolistdata">
						<img src="assets/img/check.png" alt="">
						<p><strong>test</strong><br />text text text</p>
					</div>
					<div class="todolistdata">
						<img src="assets/img/check.png" alt="">
						<p><strong>test</strong><br />text text text</p>
					</div>
					<div class="todolistdata">
						<img src="assets/img/check.png" alt="">
						<p><strong>test</strong><br />text text text</p>
					</div>
				</div>
			</div>
			<div id="white" class="todolistsection">
				<a href="javascript:void(0);" id="i" onclick="todolistout();">x</a>
				<div class="todolisttitle">To do list</div>
				<div class="todolisttitle whitetitle">완료 목록</div>
				<div class="todolistcheck">
					<div class="todolistdata">
						<img src="" alt="">
						<p><strong>test</strong><br />text text text text text text text</p>
					</div>
					<div class="todolistdata">
						<img src="" alt="">
						<p><strong>test</strong><br />text text text text text text text</p>
					</div>
					<div class="todolistdata">
						<img src="" alt="">
						<p><strong>test</strong><br />text text text text text text text</p>
					</div>
					<div class="todolistdata">
						<img src="" alt="">
						<p><strong>test</strong><br />text text text</p>
					</div>
				</div>
				<div class="todolistinput">
					<input type="text" class="" placeholder="댓글 입력" />
					<button>작성</button>
				</div>
			</div>
		</div>
		<!-- office -->
		<div id="office" class="sidemenu">
			<div id="office-header">
				연락처
				<a href="javascript:void(0);" id="x" onclick="closetel();">x</a>
			</div>
			<div id="office-body">
				<div class="office-list">내 연락처</div>
				<div class="offile-profile">
					<div class="office-profile-info">
						<img src="{{ file_exists(public_path('storage/profile_imgs/'.$user->id)) ? asset('storage/profile_imgs/'.$user->id) : asset('storage/profile_imgs/default') }}" alt="프로필사진" class="profileimg">
					</div>
					<div class="office-profile-text">
						<strong class="col-md-4 green">이메일</strong>
						<p class="col-md-8">{{ $user->email }}</p>
					</div>
					<div class="office-profile-text">
						<strong class="col-md-4 green">휴대전화</strong>
						<p class="col-md-8">{{ $user->phone }}</p>
					</div>
				</div>
				<div id="divider"></div>

				@for ($i=0, $cnt=0; $i<count($members); $i++)
				{{--
					@if ($members[$i]->id == $user->id)
						@continue;
					@endif
				--}}
					<?php $cnt++; ?>
	
					@if ($cnt == 1)
						<div class="office-list">그룹원 연락처</div>
					@endif
					
					<div class="office-profile">
						<div class="office-profile-info">
							<img src="{{ file_exists(public_path('storage/profile_imgs/'.$members[$i]->id)) ? asset('storage/profile_imgs/'.$members[$i]->id) : asset('storage/profile_imgs/default') }}" alt="프로필사진" class="profileimg">
							<p><strong>{{ $members[$i]->name }}</strong>
							{{ $members[$i]->nickname }}</p>
						</div>
						<div class="office-profile-text">
							<strong class="col-md-4 green">이메일</strong>
							<p class="col-md-8">{{ $members[$i]->email }}</p>
						</div>
						<div class="office-profile-text">
							<strong class="col-md-4 green">휴대전화</strong>
							<p class="col-md-8">{{ $members[$i]->phone }}</p>
						</div>	
					</div>
				@endfor
			</div>
<!--
			<div class="officelist">그룹원 연락처</div>
			<div class="profile">
				<img src="assets/img/sun.png" alt="" class="profileimg">
				<p><strong>User</strong>text</p>
			</div>
			<div class="profiletext">
				<strong class="col-md-2">title</strong><p class="col-md-10">alnksnlsdlknasnklslknas</p>
				<strong class="col-md-2">title</strong><p class="col-md-10">alnksnlsdlknasnklslknas</p>
			</div>
			<div class="officelist"></div>
			<div class="profile">
				<img src="assets/img/sun.png" alt="" class="profileimg">
				<p><strong>User</strong>text</p>
			</div>
			<div class="profiletext">
				<strong class="col-md-2">title</strong><p class="col-md-10">alnksnlsdlknasnklslknas</p>
				<strong class="col-md-2">title</strong><p class="col-md-10">alnksnlsdlknasnklslknas</p>
			</div>
			<div class="officelist"></div>
			<div class="profile">
				<img src="assets/img/sun.png" alt="" class="profileimg">
				<p><strong>User</strong>text</p>
			</div>
			<div class="profiletext">
				<strong class="col-md-2">title</strong><p class="col-md-10">alnksnlsdlknasnklslknas</p>
				<strong class="col-md-2">title</strong><p class="col-md-10">alnksnlsdlknasnklslknas</p>
			</div>
-->
		</div>

		<div id="tree">
			<img src="{{ asset('images/tree.png') }}" alt="나무" width="500" height="500">
		</div>

		<a href="javascript:void(0);" data-toggle="tooltip" title="Click Me!" id="sun">
			<div id="rays">
				<div class="set-one">
					<div class="triangle top"></div>
					<div class="triangle bottom"></div>
				</div>
				<div class="set-two">
					<div class="triangle top"></div>
					<div class="triangle bottom"></div>
				</div>
				<div class="set-three">
					<div class="triangle top"></div>
					<div class="triangle bottom"></div>
				</div>
				<div class="set-four">
					<div class="triangle top"></div>
					<div class="triangle bottom"></div>
				</div>
			</div>
			<div class="center"></div>
		</a>

		<a href="javascript:void(0);">
			<div id="waterspread">
				<img src="{{ asset('images/waterspread.png') }}" data-toggle="tooltip" title="Click Me!" width="100" height="60" onclick="chattingdown();">
			</div>
		</a>

		<div id="chat">
			<div id="chattitle">
				채팅
			</div>
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

	<div class="modal fade" id="help" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header modal-header-style">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">도움말</h4>
				</div>
				<div class="modal-body modal-body-style">
					<h4>자라나라 나무나무는 프로젝트 관리 사이트입니다.</h4>
					<img src="{{ asset('images/help_img.png') }}" alt="메인 사진" class="modal-image">
					<div class="modal-divider"></div>
					<h3>프로젝트 메뉴</h3>
					<h4>프로젝트 메뉴는 자신의 프로필 및 프로젝트 관리를 할 수 있는<br />4가지 기능을 가진 메뉴바 입니다.</h4>
					<div class="modal-divider"></div>
					<h3>자라나는 나무</h3>
					<h4>프로젝트가 진행상황에 따라 6가지 단계로 나무가 자라나<br />프로젝트의 진행상황을 한눈에 볼 수 있습니다.</h4>
					<div class="modal-divider"></div>
					<h3>메인기능</h3>
					<div class="modal-divider"></div>
					<h3>캘린더</h3>
					<img src="{{ asset('images/help_cal.png') }}" alt="캘린더" class="modal-image-sm">
					<h4>캘린더 기능으로 현재 남은 기간과, 일정 마감시간 등<br />프로젝트 마감시간을 체크할 수 있습니다.</h4>
					<div class="modal-divider"></div>
					<h3>역할분담표</h3>
					<img src="{{ asset('images/help_roll.png') }}" alt="역할분담표" class="modal-image-sm">
					<h4>역할분담표 기능으로 자신의 분야와 일정을 수정하고<br />팀원들의 역할과 해야할 일을 볼 수 있습니다.</h4>
					<div class="modal-divider"></div>
					<h3>To Do List</h3>
					<img src="{{ asset('images/help_todolist.png') }}" alt="투두리스트" class="modal-image-sm">
					<h4>To do list 기능으로 지금까지 완료된 프로젝트 스케줄을<br />확인하고 완료해야될 목록을 추가합니다.</h4>
					<div class="modal-divider"></div>
					<h3>연락처</h3>
					<img src="{{ asset('images/help_tel.png') }}" alt="연락처" class="modal-image-sm">
					<h4>연락처로 팀원들의 이메일과 전화번호, 깃허브(파일관리페이지)<br />정보를 공유하여 보다 수월한 프로젝트 진행을 도웁니다.</h4>
					<div class="modal-divider"></div>
				</div>
			</div>
		</div>
	</div>
	<div id="setting" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header modal-setting-style">
						<div class="col-sm-offset-1">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">설정</h4>
						</div>
					</div>
					<div class="modal-body row">
						<div class="form-group col-sm-offset-1 col-sm-10">
							<label for="usr">프로젝트 이름</label>
							<input type="text" class="form-control" id="usr">
							<label for="pwd">마감 날짜</label>
							<input type="date" class="form-control" id="pwd">
							<label for="comment">프로젝트 소개</label>
							<textarea class="form-control" rows="4" id="comment"></textarea>
							<label for="usr">관리자 변경</label>
							<div class="setting-admin">
								<input type="text" class="form-control" id="usr">
								<button>변경</button>
							</div>
							<label for="usr">프로젝트 삭제</label>
							<div class="setting-admin">
								<input type="text" class="form-control" id="usr">
								<button>삭제</button>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default">저장</button>
					</div>
				</div>
			</div>
		</div>
@stop
