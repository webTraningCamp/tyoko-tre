<?php
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
    // dd($users);
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
            'text1'=>"まずは",
            'text2'=>"3日間"
        ],
        [
            'value'=>7,
            'text1'=>"やれるぞ",
            'text2'=>"7日間"
        ],
        [
            'value'=>30,
            'text1'=>"どんとこい",
            'text2'=>"30日間"
        ],
        [
            'value'=>90,
            'text1'=>"卒業したい",
            'text2'=>"90日間"
        ]
    ]
?>

<x-app-layout >

    <form action="{{ route('user.increment.achieved_day') }}" method="POST">
        @csrf
        <button type="submit" class="bg-green-500 px-4 py-2 rounded">１日達成</button>
    </form>
    
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="bg-red-500 text-black px-4 py-2 rounded">ログアウト</button>
    </form>


        <img src="{{ asset('img/left_happa.svg') }}" alt="左葉っぱ" class="absolute left-0">
        <img src="{{ asset('img/right_happa.svg') }}" alt="右葉っぱ" class="absolute right-0">
    
    <section class="px-[10px] text-[12px] ">
        <div class="speechBubble font-14">
            <p>
                はじめまして！<br>
                あなたのことを教えて！
            </p>
        </div>
    
        <img src="{{ asset('img/namake_hi.svg') }}" class="topImgTenp">
    
        <form action="{{ route('user.update.multiple') }}" method="POST">
            @csrf
            @method('PUT')

            <section class="bg-[#eaf069] w-full text-[12px] px-[10px] py-[20px] rounded-[10px] mt-[40px]">
                <section class="flex justify-between items-center pb-[17px] border-b-[1px] border-[#2A2A2A]">
                        <h2 class="font-semibold">あなたに当てはまるものは？</h2>
                </section>
                <section class="grid grid-cols-3 grid-row-2 mt-[20px]">
                    @foreach($hobbies as $hobby)
                        <button type="button" class="h-[21px] flex justify-center items-center rounded-[12px] mx-[5px] mb-[10px] hobbie_btn
                        @if(in_array($hobby['text'], [old('hobbies1', Auth::user()->hobbies1), old('hobbies2', Auth::user()->hobbies2)]))
                            selected text-white bg-[#ED6E1B]
                        @else text-black bg-white
                        @endif"
                            data-value="{{ $hobby['text'] }}" 
                            onclick="toggleHobby(this)">
                            {{ $hobby['text'] }}
                        </button>
                    @endforeach
                </section>
            </section>

            <input type="hidden" name="hobbies1" id="hobbies1" value="{{ Auth::user()->hobbies1 }}">
            <input type="hidden" name="hobbies2" id="hobbies2" value="{{ Auth::user()->hobbies2 }}">
    
            <section class="bg-[#eaf069] w-full text-[12px] px-[10px] py-[20px] rounded-[10px] mt-[40px]">
                <section class="flex justify-between items-center pb-[17px] border-b-[1px] border-[#2A2A2A]">
                        <h2 class="font-semibold">チャレンジしたい日数は？</h2>
                </section>
                <section class="flex justify-between mt-[20px]">
                    @foreach($target_day_array as $target_day)
                        <button type="button" data-value="{{ $target_day['value'] }}" 
                            class="@if(old('target_day', Auth::user()->target_day) == $target_day['value']) text-white
                                @if($target_day['value'] == 3) bg-[#70D648]
                                @endif
                                @if($target_day['value'] == 7) bg-[#48B4F3]
                                @endif
                                @if($target_day['value'] == 30) bg-[#F39A48]
                                @endif
                                @if($target_day['value'] == 90) bg-[#FF6D6F]
                                @endif
                            @endif target-day-btn quesDayItem rounded border-[2px] border-white">
                            {{ $target_day['text1'] }}<br>
                            {{ $target_day['text2'] }}
                        </button>
                    @endforeach
                </section>
            </section>

            <input type="hidden" name="target_day" id="target_day" value="{{ old('target_day', Auth::user()->target_day) }}">
            
            <button type="submit" class="select font-12 flex items-center justify-center border-[2px] border-white shadow-[0,4px,4px,0]">
                選択した内容ではじめる
            </button>
        </form>
    </section>


    <script>
            document.querySelectorAll('.target-day-btn').forEach(button => {
                button.addEventListener('click', function() {
                    // 全ボタンの色をリセット
                    document.querySelectorAll('.target-day-btn').forEach(btn => btn.classList.remove('text-white', 'bg-[#70D648]', 'bg-[#48B4F3]', 'bg-[#F39A48]', 'bg-[#FF6D6F]'));
                    document.querySelectorAll('.target-day-btn').forEach(btn => btn.classList.add('bg-white'));

                    // 選択したボタンの色を変更
                    this.classList.remove('bg-white');
                    this.classList.add('text-white');

                    if (this.dataset.value === "3") {
                        this.classList.add('bg-[#70D648]');
                    }else if (this.dataset.value === "7") {
                        this.classList.add('bg-[#48B4F3]');
                    }else if (this.dataset.value === "30") {
                        this.classList.add('bg-[#F39A48]');
                    }else if (this.dataset.value === "90") {
                        this.classList.add('bg-[#FF6D6F]');
                    }

                    // hidden input に選択した値をセット
                    document.getElementById('target_day').value = this.dataset.value;
                });
            });

            function toggleHobby(button) {
                let selectedButtons = document.querySelectorAll('.hobbie_btn.selected');

                if (button.classList.contains('selected')) {
                    // 既に選択されている場合は解除
                    button.classList.remove('selected', 'text-white' ,'bg-[#ED6E1B]');
                    button.classList.add('bg-white');
                } else {
                    if (selectedButtons.length >= 2) {
                        alert('選択できる趣味は最大2つまでです！');
                        return;
                    }
                    button.classList.add('selected', 'text-white','bg-[#ED6E1B]');
                    button.classList.remove('bg-white');
                }

                // 選択されたボタンの値を取得し、hidden inputにセット
                let selectedValues = Array.from(document.querySelectorAll('.hobbie_btn.selected'))
                    .map(btn => btn.dataset.value);

                document.getElementById('hobbies1').value = selectedValues[0] || '';
                document.getElementById('hobbies2').value = selectedValues[1] || '';
            }
    </script>
</x-app-layout>
