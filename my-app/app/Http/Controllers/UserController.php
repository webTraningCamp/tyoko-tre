<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function updateMultiple(Request $request)
    {
        $user = Auth::user();

        if($request->mission !== null){ 
            $user->mission = $request->mission;
            $user->save();
            return redirect()->route('home');

        }else if($request->target_day !== null){
            $user->target_day = $request->target_day;
            $user->hobbies1 = $request->hobbies1;
            $user->hobbies2 = $request->hobbies2;
            $user->save();
            return redirect()->route('home');
        }else{
            $user->name = $request->name;
            $user->icon_url = $request->icon_url;
            $user->save();
            return redirect()->route('profile.index');
        }
        
    }

    public function incrementAchievedDay()
    {
        $user = Auth::user();
        $user->achieved_day += 1;
        $user->save();

        return redirect()->back()->with('success', '達成日数が増えました！');
    }
}