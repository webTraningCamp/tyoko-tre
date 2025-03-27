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
            'mission' => $request->mission
        ]);

        return response()->json($history, 201);
    }

    public function show()
    {
        $history = History::with('user')->latest()->get();
        return view('history.index', compact('history'));
    }
}