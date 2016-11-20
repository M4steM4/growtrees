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
					<span class="green">{{ $project->name }}</span>
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
						<li><a href="javascript:void(0);" onclick="showflex('calender');">캘린더</a></li>
						<li><a href="javascript:void(0)" onclick="rollon();">역할분담표</a></li>
						<li><a href="javascript:void(0)" onclick="todoliston();">To do list</a></li>
						<li><a href="javascript:void(0);" onclick="show('office');">연락처</a></li>
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

		<!-- calender -->
		<div id="calender">
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
		<div id="roll">
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
		<div id="todolist">
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
		<div id="office">
			<div id="officeheader">연락처<a href="javascript:void(0);" id="x" onclick="closetel();">x</a></div>
			<div class="officelist">내 연락처</div>
			<div class="profile">
				<img src="{{ file_exists(public_path('storage/profile_imgs/'.$user->id)) ? asset('storage/profile_imgs/'.$user->id) : asset('storage/profile_imgs/default') }}" alt="프로필사진" class="profileimg">
			</div>
			<div class="profiletext">
				<strong class="col-md-4">이메일</strong><p class="col-md-8">{{ $user->email }}</p>
				<strong class="col-md-4">휴대전화</strong><p class="col-md-8">{{ $user->phone }}</p>
			</div>
			<div id="divider"></div>

			@for ($i=0, $cnt=0; $i<count($members); $i++)
				@if ($members[$i]->id == $user->id)
					@continue;
				@endif

				<?php $cnt++; ?>

				<div class="officelist">
				@if ($cnt == 1)
					그룹원 연락처
				@endif
				</div>
				<div class="profile">
					<img src="{{ file_exists(public_path('storage/profile_imgs/'.$members[$i]->id)) ? asset('storage/profile_imgs/'.$members[$i]->id) : asset('storage/profile_imgs/default') }}" alt="프로필사진" class="profileimg">
					<p><strong>{{ $members[$i]->name }}</strong>{{ $members[$i]->nickname }}</p>
				</div>
				<div class="profiletext">
					<strong class="col-md-4">이메일</strong><p class="col-md-8">{{ $members[$i]->email }}</p>
					<strong class="col-md-4">휴대전화</strong><p class="col-md-8">{{ $members[$i]->phone }}</p>
				</div>
			@endfor
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

		<div id="sun">
			<img src="{{ asset('images/sun.png') }}" alt="D-Day" width="100" height="100">
		</div>

		<a href="javascript:void(0);">
			<div id="waterspread">
				<img src="{{ asset('images/waterspread.png') }}" width="100" height="60" onclick="chattingdown();">
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
@stop
