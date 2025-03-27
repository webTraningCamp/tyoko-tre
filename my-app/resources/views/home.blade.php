<?php
    use App\Models\Mission;
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $hobbies1 = $user->hobbies1;
    $hobbies2 = $user->hobbies2;
    $missions = Mission::where('genre', $hobbies1)
                    ->orWhere('genre', $hobbies2)
                    ->orWhere('genre', 'general')
                    ->get();
    $randomMissions = $missions->random(3);
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
    <div id="dialog" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <form>
            <div class="relative">
                <button type="submit" class="absolute top-[10px] right-[10px]"><img src="{{ asset('img/dialog_close.svg') }}" alt="ダイアログを閉じるボタン" onclick="closeDialog(this)"></button>
                <div class="bg-white rounded-[20px] px-[65px] w-[360px] h-[150px] flex flex-col items-center justify-center">
                    <h2 class="text-[16px] font-semibold text-[#ED6E1B]">おもいで</h2>
                    <input type="text" class="py-[3px] text-center mt-[10px] border border-[#d9d9d9] rounded-[5px] w-full">
                    <button class="mt-[10px] flex items-center justify-center bg-[#4EBDE5] border border-white px-[20px] py-[10px] 
                    text-white rounded-[10px] shadow-[0px 4px 4px rgba(0, 0, 0, 0.25)]" 
                    style="box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);">
                        おもいでを保管する
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="head flex items-center justify-end">
        <img src="{{ asset('img/icon.svg') }}" alt="アイコン" class="rounded-full w-[45px] h-[45px]">
    </div>

    <div class="px-[26px]">
        <div class="flex justify-center items-center mt-[20px]">
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
                        @foreach($randomMissions as $randomMission)
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
                    <form action="{{ route('history.create') }}" class="w-full flex flex-col items-center" method="POST">
                        @csrf
                        @method('POST')
                        <div class="w-full flex justify-between px-[30px]">
                            <input type="checkbox" name="mission" value="{{ $user->mission }}"  onclick="endMission(this)" required/>
                            <div class="queText">{{ $user->mission }}</div>
                        </div>
                        <button type="submit" onclick="openDialog(this)" class="mt-[20px] flex items-center justify-center bg-[#4EBDE5] border border-white px-[20px] py-[10px] text-white rounded-[10px] shadow-[0px 4px 4px rgba(0, 0, 0, 0.25)]" style="box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);">
                            <p>クリアしたよ！</p>
                        </button>
                    </form>
                @endif
            </div>
        </div>
        
        <div class="calenderOutside">
            <div class="calenderInside">
                <div class="calenderImgCluster">
                    <div>
                    <div class="nowMonth">
                        4月
                    </div>
                       <img src="image/sakuraNamake.png" class="monthImg">
                </div>
                </div>
                <div class="calenderInside"></div>
                
            </div>
    
    
            <div class="calenderAbout">
                <div class="weeks"></div>
                <div class="calenderWeeks">
                    <div class="calenderDay">30</div>
                    <div class="calenderDay">31</div>
                    <div class="calenderDay">1</div>
                    <div class="calenderDay">2</div>
                    <div class="calenderDay">3</div>
                    <div class="calenderDay">4</div>
                    <div class="calenderDay weekMon">5</div>
                    <div class="calenderDay weekSat">6</div>
                </div>
                <div class="calenderWeeks">
                    <div class="calenderDay">7</div>
                    <div class="calenderDay">8</div>
                    <div class="calenderDay">9</div>
                    <div class="calenderDay">10</div>
                    <div class="calenderDay">11</div>
                    <div class="calenderDay weekMon">12</div>
                    <div class="calenderDay weekSat">13</div>
                    <div class="calenderDay">14</div>
                </div>
                <div class="calenderWeeks">
                    <div class="calenderDay">15</div>
                    <div class="calenderDay">16</div>
                    <div class="calenderDay">17</div>
                    <div class="calenderDay">18</div>
                    <div class="calenderDay weekMon">19</div>
                    <div class="calenderDay weekSat">20</div>
                    <div class="calenderDay">21</div>
                    <div class="calenderDay">22</div>
                </div>
                <div class="calenderWeeks">
                    <div class="calenderDay">23</div>
                    <div class="calenderDay">24</div>
                    <div class="calenderDay">25</div>
                    <div class="calenderDay weekMon">26</div>
                    <div class="calenderDay weekSat">27</div>
                    <div class="calenderDay">28</div>
                    <div class="calenderDay">29</div>
                    <div class="calenderDay">30</div>
                </div>
                <div class="calenderWeeks">
                    <div class="calenderDay">1</div>
                    <div class="calenderDay">2</div>
                    <div class="calenderDay">3</div>
                    <div class="calenderDay">4</div>
                    <div class="calenderDay">5</div>
                    <div class="calenderDay">6</div>
                    <div class="calenderDay">7</div>
                    <div class="calenderDay">8</div>
                </div>
                <div class="calenderWeeks">
                    <div class="calenderDay">9</div>
                    <div class="calenderDay">10</div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    function toggleCheckbox(selected) {
        document.querySelectorAll('input[name="mission"]').forEach(checkbox => {
            if (checkbox !== selected) {
                checkbox.checked = false;
            }
        });
    }

    function openDialog(element) {
        const dialog = document.getElementById('dialog');
        dialog.style.display = 'fixed';
    }

    function closeDialog(element) {
        const dialog = document.getElementById('dialog');
        dialog.style.display = 'none';
    }
</script>
</html>