<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Exception;

use Cache;

use App\Models\User;

use App\Notifications\EmailVerificationNotification;

class EmailVerificationController extends Controller
{
    public function verify(Request $request)
    {
    	$email = $request->input('email');
    	$token = $request->input('token');
    	$user  = $request->user();

    	if (!$email || !$token) {
    		return view('pages.notice', ['title' => '操作失败', 'msg' => '验证链接不正确']);
    	}

    	if ($token != Cache::get('email_verification_' . $email)) {
    		return view('pages.notice', ['title' => '操作失败', 'msg' => '验证过期']);

    	}

    	if (!$user = User::where('email', $email)->first()) {
    		view('pages.notice', ['title' => '操作失败', 'msg' => '用户不存在']);
    	}

    	Cache::forget('email_verification_' . $email);

    	$user->update(['email_verified' => true]);

    	return view('pages.notice', ['title' => '操作成功', 'msg' => '邮箱验证成功']);
    }

    // Manually call sent mail.
    public function send(Request $request)
    {
        $user = $request->user();

        if ($user->email_verified) {
        	return view('pages.notice', ['title' => '操作失败', 'msg' => '你已经验证过邮箱了']);
        }
        // 调用 notify() call toMail
        $user->notify(new EmailVerificationNotification());

        return view('pages.notice', ['title' => '操作成功', 'msg' => '邮件发送成功']);
    }
}
