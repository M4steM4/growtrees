@extends('layouts.master')

@push('style')
	<link rel="stylesheet" href="/css/index.css">
@endpush

@section('content')
	<div class="container">
		<form class="form-horizontal" action="{{ url('login') }}" method="POST">
			{{ csrf_field() }}
			<div class="row form-group">
				<label for="user_id" class="col-md-offset-2 col-md-2 control-label">
					<span class="glyphicon glyphicon-user"></span> 아이디
				</label>
				<div class="col-md-5 col-xs-12">
					<input type="text" class="form-control" id="user_id" name="user_id">
				</div>
			</div>	
			<div class="row form-group">
                                <label for="password" class="col-md-offset-2 col-md-2 control-label">
					<span class="glyphicon glyphicon-eye-open"></span> 비밀번호
				</label>
                                <div class="col-md-5 col-xs-12">
                                        <input type="password" class="form-control" id="password" name="passowrd">
                                </div>
                        </div>
			<div class="form-group">
				<div class="col-md-offset-4 col-md-8">
					<div class="checkbox">
						<label>
							<input type="checkbox"> 자동 로그인
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-4 col-md-8">
					<button type="submit" class="btn btn-default">로그인</button>&nbsp;
					<button type="button" class="btn btn-default" data-toggle="modal" data-target="#register">회원가입</button>
    				</div>
			</div>
				
			<a href="" id="find_pw" class="col-md-offset-4 col-md-2" data-toggle="modal" data-target="#forgot_pw">비밀번호 찾기</a>
		</form>
	</div>
	
	<div id="register" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Register</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal">
						<div class="form-group">
							<label for="name" class="col-sm-offset-1 col-sm-3 control-label">이름</label>
	    						<div class="col-sm-7">
		      						<input type="text" class="form-control" id="name" name="name">
    							</div>
						</div>
						<div class="form-group">
							<label for="email" class="col-sm-offset-1 col-sm-3 control-label">이메일</label>
                                                	<div class="col-sm-7">
                                                        	<input type="email" class="form-control" id="email" name="email">
                                                	</div>
						</div>
						<div class="form-group">
                                                        <label for="phone" class="col-sm-offset-1 col-sm-3 control-label">휴대전화 [연락처]</label>
                                                        <div class="col-sm-7">
                                                        	<input type="text" class="form-control" id="phone" name="phone">
                                                        </div>
                                                </div>
						<div class="form-group">
                                                        <label for="user_id" class="col-sm-offset-1 col-sm-3 control-label">아이디</label>
                                                        <div class="col-sm-7">
                                                        	<input type="text" class="form-control" id="user_id" name="user_id">
                                                        </div>
                                                </div>
						<div class="form-group">
                                                        <label for="password" class="col-sm-offset-1 col-sm-3 control-label">비밀번호</label>
                                                        <div class="col-sm-7">                                                   
                                                                <input type="password" class="form-control" id="password" name="password">
                                                        </div>
                                                </div>
						<div class="form-group">
                                                        <label for="pw_check" class="col-sm-offset-1 col-sm-3 control-label">비밀번호 확인</label>
                                                        <div class="col-sm-7">
                                                        	<input type="password" class="form-control" id="pw_check" name="pw_check">
                                                        </div>
                                                </div>
						
						<div class="panel panel-info col-sm-offset-1 col-sm-10">
							<div class="panel-heading">* 정보 이용 안내</div>
							<div class="panel-body">
							   이메일은 비밀번호 분실 시 필요합니다. 이메일과 휴대전화 번호는 팀원들 사이에서만 공유되며 다른 목적으로는 이용되지 않습니다.
							</div>
						</div>					
	
						<div class="form-group">
							<div class="col-sm-offset-9 col-sm-2">
								<button id="register_btn" type="button" class="btn btn-default">Sign in</button>
							</div>
						</div>
					</form>
				</div>
				<!--<div class="modal-footer">

				</div>-->
			</div>
		</div>
	</div>

	<div id="forgot_pw" class="modal fade" role="dialog">
                <div class="modal-dialog">
                        <div class="modal-content">
                                <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Find Password</h4>
                                </div>
                                <div class="modal-body">
                                        <form class="form-horizontal">
                                                <div class="form-group">
                                                        <label for="user_id" class="col-sm-offset-1 col-sm-3 control-label">아이디</label>
                                                        <div class="col-sm-7">
                                                                <input type="text" class="form-control" id="user_id" name="user_id">
                                                        </div>
                                                </div>
						<div class="form-group">
							<label for="email" class="col-sm-offset-1 col-sm-3 control-label">이메일</label>
							<div class="col-sm-7">
								<input type="email" class="form-control" id="email" name="email">
							</div>
						</div>
						<div class="form-group">
                                                        <div class="col-sm-offset-9 col-sm-2">
                                                                <button id="register_btn" type="button" class="btn btn-default">Send</button>
                                                        </div>
                                                </div>
					</form>
				</div>
			</div>
		</div>
	</div>
@stop
