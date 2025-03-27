<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function updateMultiple(Request $request)
    {
    // dd($request->all());
    $user = Auth::user();
    
    // バリデーション
    $request->validate([
        // 'name' => 'required|string|max:255',
        // 'email' => 'required|email|unique:users,email,' . $user->id,
        // 'nickname' => 'nullable|string|max:50',
        // 'age' => 'required|integer|min:1|max:80',
        // 'gender' => 'required|in:1,2',
        'hobbies' => 'array|max:2', // 最大2つまで
    ]);

    // その他のデータ更新
    // $user->name = $request->name;
    // $user->email = $request->email;
    // $user->nickname = $request->nickname;
    // $user->age = $request->age;
    // $user->gender = $request->gender;
    $user->target_day = $request->target_day;
    $user->hobbies1 = $request->hobbies1;
    $user->hobbies2 = $request->hobbies2;

    $user->save();

    return redirect()->route('home');
    }

    public function incrementAchievedDay()
    {
        $user = Auth::user();
        $user->achieved_day += 1;
        $user->save();

        return redirect()->back()->with('success', '達成日数が増えました！');
    }

    public function updateMission(Request $request)
    {
        $user = Auth::user();
        $user->mission = $request->mission;
        $user->save();

        return redirect()->back()->with('success', 'ミッションを更新しました！');
    }

}