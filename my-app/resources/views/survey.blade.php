<?php
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user()
    // dd($users);]
?>

<x-app-layout >
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('survey') }}
        </h2>
    </x-slot>


    @if (session('success'))
    <div class="text-green-500">{{ session('success') }}</div>
@endif

<form action="{{ route('user.update.multiple') }}"  method="POST">
    @csrf
    @method('PUT')

    <label for="name">名前:</label>
    <input type="text" class="text-black" name="name" value="{{ Auth::user()->name }}" required>

    <label for="email">メールアドレス:</label>
    <input type="email" class="text-black" name="email" value="{{ Auth::user()->email }}" required>

    <label for="nickname">ニックネーム:</label>
    <input type="text" class="text-black" name="nickname" value="{{ Auth::user()->nickname }}" ></input>

    <select name="age" required>
        <?php
            for($i = 1; $i <= 80; $i++){
                echo "<option value='$i'>$i</option>";
            }
        ?>
    </select>

    <input type="radio" name="gender" value="1" required>
    <label for="1">男性</label>
    <input type="radio" name="gender" value="2" required>
    <label for="2">女性</label>


    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">更新</button>
</form>
    
    
</x-app-layout>
