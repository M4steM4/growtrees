<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|regex:[^[가-힣]+$]|min:2|max:6',
	    'nickname' => 'required|unique:users|min:4|max:30',
            'email' => 'required|email|max:200',
	    'phone' => 'required|regex:[[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}]',
	    'user_id' => 'required|unique:users|min:4|max:30',
            'password' => 'required|min:6|max:30|confirmed',
	    'profile_image' => 'bail|image|dimensions:min_width=100,min_height=100|max:20480'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
	    'nickname' => $data['nickname'],
            'email' => $data['email'],
	    'phone' => $data['phone'],
	    'user_id' => $data['user_id'],
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function registered(Request $request, $user)
    {
	if(! $request->file('profile_image')->isValid()) {
	    return;
	}

	$id = $user->id;
	
	$request->file('profile_image')->storeAs(
            'public/profile_imgs/', $id.'.tmp'
        );

	$mimetype = $request->file('profile_image')->getMimeType();
	$PATH = public_path('storage/profile_imgs/');

	// origin to 250x250	
	list($orgWidth, $orgHeight) = getImageSize($PATH.$id.'.tmp');

	$newWidth = $newHeight = 250;
	$imageResized = imageCreateTrueColor($newWidth, $newHeight);
	$imageOrigin = null;

	switch($mimetype) {
    	    case 'image/bmp': 
		$imageOrigin = imageCreateFromwBmp($PATH.$id.'.tmp');
		break;
	    case 'image/gif': 
		$imageOrigin = imageCreateFromGif($PATH.$id.'.tmp'); 
		break;
 	    case 'image/jpeg': 
		$imageOrigin = imageCreateFromJpeg($PATH.$id.'.tmp'); 
		break;
    	    case 'image/png': 
		$imageOrigin = imageCreateFromPng($PATH.$id.'.tmp'); 
		break;
  	}

	imageCopyResampled($imageResized, $imageOrigin, 0, 0, 0, 0,
                        $newWidth, $newHeight, $orgWidth, $orgHeight);
	Storage::delete('public/profile_imgs/'.$id.'.tmp');	

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
                $imageOrigin = imagewBmp($imageCropped, $PATH.$id);
                break;
            case 'image/gif':
                $imageOrigin = imageGif($imageCropped, $PATH.$id);
                break;
            case 'image/jpeg':
                $imageOrigin = imageJpeg($imageCropped, $PATH.$id);
                break;
            case 'image/png':
                $imageOrigin = imagePng($imageCropped, $PATH.$id); 
                break;
        }
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        $this->guard()->login($user);
        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
}
