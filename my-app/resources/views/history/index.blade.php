@extends('layouts.app')

@section('content')
<div class="container">
    <h1>履歴一覧</h1>
    <ul>
        @foreach ($history as $item)
            <li>{{ $item->user->name }} - {{ $item->action }} ({{ $item->created_at }})</li>
        @endforeach
    </ul>
</div>
@endsection