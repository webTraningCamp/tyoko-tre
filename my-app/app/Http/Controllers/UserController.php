<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function updateMultiple(Request $request)
    {
        $user = Auth::user();

        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nickname' => 'nullable|string|max:50',
        ]);

        // ユーザーデータを更新
        $user->name = $request->name;
        $user->email = $request->email;
        $user->nickname = $request->nickname;
        $user->age = $request->age;
        $user->gender = $request->gender;
        $user->save();

        return redirect()->back()->with('success', 'プロフィールを更新しました！');
    }
}