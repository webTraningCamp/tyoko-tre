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
        // リクエストデータをすべて取得
        $data = $request->all();

        // ログインユーザーの最新の履歴を取得
        $history = History::where('user_id', Auth::id())
            ->where('date', $request->input('date')) // 日付で絞り込み
            ->latest()
            ->first();

        if ($history) {
            $history->update([
                'text' => $request->input('text')
            ]);

            return redirect()->route('home')->with('success', 'おもいでを保存しました');
        }

        // 履歴が見つからない場合の処理
        return redirect()->route('home')->with('error', '保存できませんでした');
    }
}