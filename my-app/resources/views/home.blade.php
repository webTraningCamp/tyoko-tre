<?php
    use App\Models\Mission;
    use App\Models\User;
    use App\Models\History;
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();

    $latestHistory = History::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->first();

    $latestDate = null;
    if ($latestHistory) {
        // 最新のcreated_atの日付部分を 'd' フォーマットで取得
        $latestDate = $latestHistory->created_at->format('d');
    }
    // dd($latestDate);
    $history = History::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();

    $rotate_data = [];

    foreach ($history as $item) {
        // created_at の日付部分を 'd' フォーマットで取得
        $date = $item->created_at->format('d');

        // created_atの日付をキーにrotateを値として連想配列に追加
        $rotate_data[] = [
            'date' => $date,
            'rotate' => $item->rotate, // rotateの値も追加
        ];
    }

    $hobbies1 = $user->hobbies1;
    $hobbies2 = $user->hobbies2;
    $missions = Mission::where('genre', $hobbies1)
                ->orWhere('genre', $hobbies2)
                ->orWhere('genre', 'general')
                ->inRandomOrder()
                ->take(3)
                ->get();

    $calender_array =[30,31,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,1,2,3];
    $saturday_array = [5,12,19,26];
    $sunday_array = [6,13,20,27];
    $other_month_length_array = [0,1,32,33,34];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Darumadrop+One&display=swap" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>home</title>
</head>
<body class="text-[12px]">
    <div id="dialog" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-[100]">
        <form action="{{ route('history.update') }}">
        @csrf
        @method('PUT')
            <div class="relative">
                <button type="button" class="absolute top-[10px] right-[10px]"><img src="{{ asset('img/dialog_close.svg') }}" alt="ダイアログを閉じるボタン" onclick="closeDialog(this)"></button>
                <div class="bg-white rounded-[20px] px-[65px] w-[360px] h-[150px] flex flex-col items-center justify-center">
                    <h2 class="text-[16px] font-semibold text-[#ED6E1B] font-darumadrop tracking-widest">おもいで</h2>
                    <input type="text" name="text" class="tracking-widest py-[3px] text-center mt-[10px] border border-[#d9d9d9] rounded-[5px] w-full font-darumadrop">
                    <input type="hidden" name="date" id="dialogDate">
                    <button type="submit" class="mt-[10px] flex items-center justify-center bg-[#4EBDE5] border border-white px-[20px] py-[10px] 
                        text-white rounded-[10px] shadow-[0px 4px 4px rgba(0, 0, 0, 0.25)]"
                        style="box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);">
                        おもいでを保管する
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div id="dialog2" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-[100] hidden"> 
        <div class="p-[20px] pb-[40px] bg-[#BDEEFF] rounded-[20px] mt-[20px]">
            <div class="relative h-[200px]">
                <div class="flex justify-between">
                    <p class="text-[48px] font-bold text-[#2AB9ED]">4<span class="text-[38px]">月</span></p>
                    <img src="{{ asset('img/calender_namake.svg') }}" class="absolute right-0 top-0 w-[283px] h-[200px]" alt="カレンダーナマケモノ">
                </div>  
            </div>
            <div class="grid grid-cols-7 grid-rows-5 gap-[9px]">
                @foreach($calender_array as $index => $day)
                    <div class="bg-white w-[30px] h-[30px] relative"><p class="
                    @foreach($saturday_array as $saturday)
                        @if($day == $saturday)
                            text-[#549EFF]
                        @endif
                    @endforeach
                    @foreach($sunday_array as $sunday)
                        @if($day == $sunday)
                            text-[#F76868]
                        @endif
                    @endforeach
                    @foreach($other_month_length_array as $other_month_length)
                        @if($index == $other_month_length)
                            text-[#BAB8B8]
                        @endif
                    @endforeach
                    ">{{$day}}</p>
                    @foreach($rotate_data as $data)
                        @if($day == $data['date'] && $day != $latestDate)
                            <img src="{{ asset('img/yokudekimasita.svg') }}" alt="ナマケモノ" class="absolute top-0 left-0 rotate-[{{ $data['rotate'] }}deg]">
                        @endif
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="head flex items-center justify-end">
            <a href="{{ route('profile.index') }}">
                <img src="{{ asset('img/' . $user->icon_url) }}" alt="アイコン" class="rounded-full w-[45px] h-[45px] mr-2">
            </a>
   
    </div>

    <div class="px-[26px] py-[20px]">
        <div class="flex justify-center items-center">
            <div class="bg-white flex items-center justify-center rounded-[20px] px-[30px] py-[20px] h-[57px] font-14">
                <p>今日は何しよう？</p>
            </div>
        </div>
    
       <div class="flex justify-around">
            <img src="{{ asset('img/namake_face1.svg') }}" class="namakeHead">
            <img src="{{ asset('img/namake_face2.svg') }}" class="namakeHead">
            <img src="{{ asset('img/namake_face3.svg') }}" class="namakeHead">
        
       </div>
    
        <div class="mt-[20px] bg-white px-[45px] py-[13px] rounded-[20px]" style="box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);">
            <div class="resetFlex">
                <div class="flex items-end font-semibold">今日のクエスト</div>
                @if($user->mission == null)
                    <div class="flex flex-col items-center">
                        <img src="{{ asset('img/reset.svg') }}" class="w-[20px] h-[20px]">
                        <p class="text-[8px]">別クエスト</p>
                    </div>
                @endif
            </div>
            <div class="flex flex-col items-center">
                
                @if($user->mission == null)
                    <form action="{{ route('user.update.multiple') }}" class="w-full flex flex-col items-center" method="POST">
                        @csrf
                        @method('PUT')
                        @foreach($missions as $randomMission)
                            <div class="w-full flex justify-between px-[30px] border-b-[1px] border-[#D9D9D9]
                            @if($loop->last) border-none @endif">
                                <input type="checkbox" name="mission" value="{{ $randomMission->mission }}" onclick="toggleCheckbox(this)"/>
                                <div class="queText">{{ $randomMission->mission }}</div>
                            </div>
                        @endforeach
                        <button type="submit" class="mt-[20px] flex items-center justify-center bg-[#4EBDE5] border border-white px-[20px] py-[10px] text-white rounded-[10px] shadow-[0px 4px 4px rgba(0, 0, 0, 0.25)]" style="box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);">
                            <p>選択した内容ではじめる</p>
                        </button>
                    </form>
                    @else
                    <form action="{{ route('history.store') }}" method="POST" class="w-full flex flex-col items-center">

                        @csrf
                        @method('POST')

                        <div class="w-full flex justify-between px-[30px]">
                            <input type="hidden" name="mission" value="{{ $user->mission }}">
                            <input type="checkbox" name="mission" value="{{ $user->mission }}"  onclick="endMission(this)" required/>
                            <div class="queText">{{ $user->mission }}</div>
                        </div>
                        <button type="submit" class="mt-[20px] flex items-center justify-center bg-[#4EBDE5] border border-white px-[20px] py-[10px] text-white rounded-[10px] shadow-[0px 4px 4px rgba(0, 0, 0, 0.25)]" style="box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);">
                            <p>クリアしたよ！</p>
                        </button>
                    </form>
                @endif
            </div>
        </div>
        
        <div class="p-[20px] pb-[40px] bg-[#BDEEFF] rounded-[20px] mt-[20px]">
            <div class="relative h-[200px]">
                <div class="flex justify-between">
                    <p class="text-[48px] font-bold text-[#2AB9ED]">4<span class="text-[38px]">月</span></p>
                    <img src="{{ asset('img/calender_namake.svg') }}" class="absolute right-0 top-0 w-[283px] h-[200px]" alt="カレンダーナマケモノ">
                </div>  
            </div>
    
    
            <div class="grid grid-cols-7 grid-rows-5 gap-[9px]">
                @foreach($calender_array as $index => $day)
                    <div class="bg-white w-[30px] h-[30px] relative"><p class="
                    @foreach($saturday_array as $saturday)
                        @if($day == $saturday)
                            text-[#549EFF]
                        @endif
                    @endforeach
                    @foreach($sunday_array as $sunday)
                        @if($day == $sunday)
                            text-[#F76868]
                        @endif
                    @endforeach
                    @foreach($other_month_length_array as $other_month_length)
                        @if($index == $other_month_length)
                            text-[#BAB8B8]
                        @endif
                    @endforeach
                    ">{{$day}}</p>
                    @foreach($rotate_data as $data)
                        @if($day == $data['date'])
                            <img src="{{ asset('img/yokudekimasita.svg') }}" alt="ナマケモノ"  class="absolute top-0 left-0 rotate-[{{ $data['rotate'] }}deg] cursor-pointer" onclick="openDialog({{$day}})">
                        @endif
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>
    </div>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ダイアログを表示するかどうかをチェック
        @if(session('show_dialog2'))
            const dialog2 = document.getElementById('dialog2');
            const stampedDay = {{ session('stamped_day') }};
            
            if (dialog2) {
                dialog2.style.display = 'flex';
                dialog2.style.opacity = '1';
                dialog2.style.transition = 'opacity 0.5s ease-out';
                
                // カレンダー内の対応する日付の要素を取得
                const dayElements = document.querySelectorAll('.bg-white');
                dayElements.forEach(dayElement => {
                    const dayText = dayElement.querySelector('p');
                    if (dayText && parseInt(dayText.textContent) === stampedDay) {
                        // 既存のスタンプを非表示にする
                        const existingStamp = dayElement.querySelector('img[alt="ナマケモノ"]');
                        if (existingStamp) {
                            existingStamp.style.display = 'none';
                        }

                        // 新しいアニメーションスタンプを追加
                        const stampImg = document.createElement('img');
                        stampImg.src = "{{ asset('img/yokudekimasita.svg') }}";
                        stampImg.alt = "ナマケモノ";
                        stampImg.classList.add('absolute', 'top-0', 'left-0', 'animate-stamp');
                        
                        // ランダムな角度を生成
                        const randomRotation = Math.floor(Math.random() * 361);
                        stampImg.style.transform = `rotate(${randomRotation}deg)`;
                        
                        dayElement.appendChild(stampImg);

                        // アニメーション終了後にdialog2をフェードアウト
                        stampImg.addEventListener('animationend', function() {
                            setTimeout(() => {
                                dialog2.style.opacity = '0';
                                
                                // opacityアニメーション完了後にdisplayを none にする
                                dialog2.addEventListener('transitionend', function() {
                                    dialog2.style.display = 'none';
                                }, { once: true });
                            }, 1500); // スタンプアニメーションの後に少し待ってからフェードアウト
                        });
                    }
                });
            }
        @endif

        
    });
    function toggleCheckbox(selected) {
        document.querySelectorAll('input[name="mission"]').forEach(checkbox => {
            if (checkbox !== selected) {
                checkbox.checked = false;
            }
        });
    }
    function closeDialog(element) {
        const dialog = document.getElementById('dialog');
        dialog.style.display = 'none';
    }

    function openDialog(day) {
        const dialog = document.getElementById('dialog');
        const dialogDateInput = document.getElementById('dialogDate');
        
        // クリックされた日付を隠しinputに設定
        dialogDateInput.value = day;
        
        // ダイアログを表示
        dialog.style.display = 'flex';
    }
</script>

<style>
    @keyframes stamp {
        0% {
            transform: scale(5) rotate(0deg);
            opacity: 0;
        }
        70% {
            transform: scale(1.2) rotate(var(--rotation));
            opacity: 1;
        }
        100% {
            transform: scale(1) rotate(var(--rotation));
            opacity: 1;
        }
    }

    .animate-stamp {
        animation: stamp 1.5s ease-out;
        animation-fill-mode: forwards;
    }
</style>
</html>