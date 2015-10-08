<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller {
	
	public function __construct()
	{

	}
	
	/*加载视图文件*/
	public function login_view()
	{
		return view('admin.login');
	}
	public function login(Request $request)
	{
		print_r($request->only('user_login', 'user_pass'));
		if (Auth::attempt($request->only('user_login', 'user_pass'))) {
			return '认证成功';
			return redirect()->intended('dashboard');
		}else{
			return '认证失败';
		}
	}

    public function GetIndex()
    {
		return view('admin.index');
    }

	public function welcome()
	{
		return view('admin.welcome');
	}
	public function article_list()
	{
		return view('admin.article-list');
	}
	public function article_add()
	{
		return view('admin.article-add');
	}
	public function picture_list()
	{
		return view('admin.picture-list');
	}
	public function rticle_zhang()
	{
		return view('admin.rticle-zhang');
	}
	public function system_base()
	{
		return view('admin.system-base');
	}
}