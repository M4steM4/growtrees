<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use App\User;
use Validator;

class HomeController extends Controller
{
    public function index () {
	$user = Auth::user();
	return view('home', compact('user'));
    }

    private function rule (string $name) {
	switch($name) {
	    case 'nickname':
		return ['nickname' => 'required|unique:users|min:4|max:30'];
	    case 'email':
		return ['email' => 'required|email|max:200'];
            case 'phone':
		return ['phone' => 'required|regex:[[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}]'];
	    case 'profile_image':
		return ['profile_image' => 'bail|image|dimensions:min_width=100,min_height=100|max:20480'];
	}
    }

    private function validateUpdateData (Request $request, array $update) {
	foreach($update as $name => $value) {
	    if($value) {
		$this->validate($request, $this->rule($name));
	    }
	}
    }

    private function updateNickname (Request $request, User $user) {
	$oldNick = $user->nickname;
	$user->nickname = $request->input('nickname');
	
	$PATH = public_path('storage/profile_imgs/');
	rename($PATH . $oldNick.'.img', $PATH . $user->nickname.'.img');
    }
    private function updatePhone (Request $request, User $user) {
	$oldPhone = $user->phone;
	$user->phone = $request->input('phone');
    }
    private function updateEmail (Request $request, User $user) {
	$oldEmail = $user->email;
	$user->email = $request->input('email');
    }
    private function updateProfileImage (Request $request, User $user) {
        if(! $request->file('profile_image')->isValid()) {
	    return;
	}

	$nick = $user->nickname;
	
	$request->file('profile_image')->storeAs(
            'public/profile_imgs/', $nick.'.tmp'
        );

	$mimetype = $request->file('profile_image')->getMimeType();
	$PATH = public_path('storage/profile_imgs/');

	// origin to 250x250	
	list($orgWidth, $orgHeight) = getImageSize($PATH.$nick.'.tmp');

	$newWidth = $newHeight = 250;
	$imageResized = imageCreateTrueColor($newWidth, $newHeight);
	$imageOrigin = null;

	switch($mimetype) {
    	    case 'image/bmp': 
		$imageOrigin = imageCreateFromwBmp($PATH.$nick.'.tmp');
		break;
	    case 'image/gif': 
		$imageOrigin = imageCreateFromGif($PATH.$nick.'.tmp'); 
		break;
 	    case 'image/jpeg': 
		$imageOrigin = imageCreateFromJpeg($PATH.$nick.'.tmp'); 
		break;
    	    case 'image/png': 
		$imageOrigin = imageCreateFromPng($PATH.$nick.'.tmp'); 
		break;
  	}

	imageCopyResampled($imageResized, $imageOrigin, 0, 0, 0, 0,
                        $newWidth, $newHeight, $orgWidth, $orgHeight);
	Storage::delete('public/profile_imgs/'.$nick.'.tmp');

	// crop the image with coordinates
	$x1 = $request->input('x1');
	$y1 = $request->input('y1');

	$orgWidth = $orgHeight = $request->input('size');
	$newWidth = $newHeight = 150;
	$imageCropped = imageCreateTrueColor($newWidth, $newHeight);

	imageCopyResampled($imageCropped, $imageResized, 0, 0, $x1, $y1,
			$newWidth, $newHeight, $orgWidth, $orgHeight);
	switch($mimetype) {
            case 'image/bmp':
                $imageOrigin = imagewBmp($imageCropped, $PATH.$nick.'.img');
                break;
            case 'image/gif':
                $imageOrigin = imageGif($imageCropped, $PATH.$nick.'.img');
                break;
            case 'image/jpeg':
                $imageOrigin = imageJpeg($imageCropped, $PATH.$nick.'.img');
                break;
            case 'image/png':
                $imageOrigin = imagePng($imageCropped, $PATH.$nick.'.img'); 
                break;
        }
    }

    public function updateUserInfo (Request $request) {
	// password confirmation
	$user = Auth::user();	
	if (!Hash::check($request->input('password'), Auth::user()->password)) { 
	    return response()->json([
		'password' => array('비밀번호가 일치하지 않음')
	    ], 422);
	}

	// filtering update list
	$update = array(
	    'nickname' => true,
	    'phone' => true,
	    'email' => true,
	);

	if(strpos($request->input('nickname'), '기존 닉네임 : ') !== false) {
	    $update['nickname'] = false;
	}
	if(strpos($request->input('phone'), '기존 연락처 : ') !== false) {
	    $update['phone'] = false;
	}
	if(strpos($request->input('email'), '기존 이메일 : ') !== false ) {
	    $update['email'] = false;
	}
	$update['profile_image'] = $request->hasFile('profile_image');

	// validate input
	$this->validateUpdateData($request, $update);

	// update user info
	if($update['nickname']) { $this->updateNickname($request, $user); }
	if($update['phone']) { $this->updatePhone($request, $user); }
	if($update['email']) { $this->updateEmail($request, $user); }
	if($update['profile_image']) { $this->updateProfileImage($request, $user); }

	$user->save();
	
	return response()->json([
		'nickname' => $user->nickname,
		'phone' => $user->phone,
		'email' => $user->email
	], 200);
    }
}
