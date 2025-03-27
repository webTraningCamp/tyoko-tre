<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    // 全履歴を取得
    public function index()
    {
        $history = History::with('user')->latest()->get();
        return response()->json($history);
    }

    public function store(Request $request)
    {
        // dd($request->all(),$request->mission);
        $history = History::create([
            'user_id' => Auth::id(),
            'mission' => $request->mission,
            'rotate' => mt_rand(0, 360),
        ]);

        $user = Auth::user();
        $user->achieved_day += 1;
        $user->save();


         // 今追加したデータの日付（日）を取得
        $createdDay = $history->created_at->format('d');

        // ダイアログを表示するためのフラッシュメッセージを追加
        return redirect()->route('home')->with([
            'show_dialog2' => true,
            'stamped_day' => $createdDay
        ]);
    }

    public function show()
    {
        $history = History::with('user')->latest()->get();
        return view('history.index', compact('history'));
    }

    public function update(Request $request)
    {
        $history = History::find($request->created_at);

        dd($history);
        $history->update([
            'mission' => $request->mission,
        ]);

        return redirect()->route('home');
    }
}