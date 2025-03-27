<?php
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
    // dd($users);]
    $remaining_day = $user->target_day - $user->achieved_day;
    $hobbies = [
        [
            'text'=>'ダンス'
        ],
        [
            'text'=>'サイクリング'
        ],
        [
            'text'=>'ペット'
        ],
        [
            'text'=>'読書'
        ],
        [
            'text'=>'散歩'
        ],
        [
            'text'=>'買い物'
        ]
    ];

    $target_day_array = [
        [
            'value'=>3,
            'text'=>"まずは3日間"
        ],
        [
            'value'=>7,
            'text'=>"やれるぞ7日間"
        ],
        [
            'value'=>30,
            'text'=>"どんとこい30日間"
        ],
        [
            'value'=>90,
            'text'=>"卒業したい90日間"
        ]
    ]
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

    <form action="{{ route('user.update.multiple') }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">名前:</label>
        <input type="text" class="text-black" name="name" value="{{ Auth::user()->name }}" required>

        <label for="email">メールアドレス:</label>
        <input type="email" class="text-black" name="email" value="{{ Auth::user()->email }}" required>

        <label for="nickname">ニックネーム:</label>
        <input type="text" class="text-black" name="nickname" value="{{ Auth::user()->nickname }}" ></input>

        <select name="age" required>
            @for ($i = 1; $i <= 80; $i++)
                <option value="{{ $i }}" @selected(old('age', Auth::user()->age) == $i)>{{ $i }}</option>
            @endfor
        </select>

        <input type="radio" name="gender" value="1" @checked(old('gender', Auth::user()->gender) == 1) required>
        <label for="1">男性</label>
        <input type="radio" name="gender" value="2" @checked(old('gender', Auth::user()->gender) == 2) required>
        <label for="2">女性</label>

        <div class="border border-2px border-black mt-4">
            @foreach($target_day_array as $target_day)
                <button type="button" data-value="{{ $target_day['value'] }}" 
                    class="target-day-btn 
                    @if(old('target_day', Auth::user()->target_day) == $target_day['value']) bg-blue-500 font-semibold  
                    @else bg-gray-200 
                    @endif px-4 py-2 rounded">
                    {{ $target_day['text'] }}
                </button>
            @endforeach
        </div>
        <input type="hidden" name="target_day" id="target_day" value="{{ old('target_day', Auth::user()->target_day) }}">

        <div class="border border-2px border-black mt-4">
            @foreach($hobbies as $hobby)
                <button type="button" class="hobbie_btn bg-gray-200 px-4 py-2 rounded" 
                    data-value="{{ $hobby['text'] }}" 
                    onclick="toggleHobby(this)">
                    {{ $hobby['text'] }}
                </button>
            @endforeach
        </div>
        <input type="hidden" name="hobbies1" id="hobbies1" value="{{ Auth::user()->hobbies1 }}">
        <input type="hidden" name="hobbies2" id="hobbies2" value="{{ Auth::user()->hobbies2 }}">
        
        <button type="submit" class="bg-blue-500 px-4 py-2 rounded">更新</button>
    </form>

    
    <form action="{{ route('user.increment.achieved_day') }}" method="POST">
        @csrf
        <button type="submit" class="bg-green-500 px-4 py-2 rounded">１日達成</button>
    </form>
    
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="bg-red-500 text-black px-4 py-2 rounded">ログアウト</button>
    </form>
    
    <p>残り{{ $remaining_day }}日</p>

    <script>
            document.querySelectorAll('.target-day-btn').forEach(button => {
                button.addEventListener('click', function() {
                    // 全ボタンの色をリセット
                    document.querySelectorAll('.target-day-btn').forEach(btn => btn.classList.remove('bg-blue-500', 'font-semibold'));
                    document.querySelectorAll('.target-day-btn').forEach(btn => btn.classList.add('bg-gray-200'));

                    // 選択したボタンの色を変更
                    this.classList.remove('bg-gray-200');
                    this.classList.add('bg-blue-500', 'font-semibold');

                    // hidden input に選択した値をセット
                    document.getElementById('target_day').value = this.dataset.value;
                });
            });

            function toggleHobby(button) {
                let selectedButtons = document.querySelectorAll('.hobbie_btn.bg-blue-500');

                if (button.classList.contains('bg-blue-500')) {
                    // 既に選択されている場合は解除
                    button.classList.remove('bg-blue-500', 'font-semibold');
                    button.classList.add('bg-gray-200');
                } else {
                    if (selectedButtons.length >= 2) {
                        alert('選択できる趣味は最大2つまでです！');
                        return;
                    }
                    button.classList.add('bg-blue-500', 'font-semibold');
                    button.classList.remove('bg-gray-200');
                }

                // 選択されたボタンの値を取得し、hidden inputにセット
                let selectedValues = Array.from(document.querySelectorAll('.hobbie_btn.bg-blue-500'))
                    .map(btn => btn.dataset.value);

                document.getElementById('hobbies1').value = selectedValues[0] || '';
                document.getElementById('hobbies2').value = selectedValues[1] || '';
            }

    </script>
</x-app-layout>
