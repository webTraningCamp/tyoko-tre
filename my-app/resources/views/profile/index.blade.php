<?php
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $remaining_day = $user->target_day - $user->achieved_day;
?>

<x-app-layout>
    <div id="dialog" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-[100]">
        <form action="{{ route('user.update.multiple') }}" method="POST">
        @csrf
        @method('PUT')
            <div class="relative">
                <button type="button" class="absolute top-[10px] right-[10px]">
                    <img src="{{ asset('img/dialog_close.svg') }}" alt="ダイアログを閉じるボタン" onclick="closeDialog(this)">
                </button>
                <div class="bg-white rounded-[20px] px-[65px] w-[360px] py-[25px] flex flex-col items-center justify-center">
                    <h2 class="text-[16px] font-semibold text-[#ED6E1B] font-darumadrop tracking-widest">すきなアイコンをえらんでね</h2>
                    <div class="flex items-center justify-between mt-[10px] w-full">
                        <img src="{{ asset('img/icon1.svg') }}" class="w-[58px] h-[58px] iconbtn" data-value="icon1.svg" alt="ナマケモノアイコン" onclick="selectIcon(this)">
                        <img src="{{ asset('img/icon2.svg') }}" class="w-[58px] h-[58px] iconbtn" data-value="icon2.svg" alt="ナマケモノアイコン2" onclick="selectIcon(this)">
                        <img src="{{ asset('img/icon3.svg') }}" class="w-[58px] h-[58px] iconbtn" data-value="icon3.svg" alt="ナマケモノアイコン3" onclick="selectIcon(this)">
                    </div>
                    <input type="hidden" name="icon_url" id="icon">

                    <h2 class="text-[16px] font-semibold text-[#ED6E1B] font-darumadrop tracking-widest mt-[10px]">あなたのなまえ</h2>
                    <input type="text" name="name" value="{{ $user->name }}" class="py-[3px] text-center mt-[10px] border border-[#d9d9d9] rounded-[5px] w-full font-darumadrop tracking-widest">
                    <button type="submit" class="mt-[10px] flex items-center justify-center bg-[#4EBDE5] border border-white px-[20px] py-[10px] 
                        text-white rounded-[10px] shadow-[0px 4px 4px rgba(0, 0, 0, 0.25)] text-[10px]"
                        style="box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);">
                        設定完了
                    </button>
                </div>
            </div>
        </form>
    </div>

    <header class="bg-[#F39A48] pt-[40px] pb-[20px] flex justify-center items-center flex-col relative">
        <a href="{{ route('home') }}"><img src="{{ asset('img/backarrow.svg') }}" alt="戻る" class="absolute left-[2%] top-[8%]"></a>
        <img src="{{ asset('img/' . $user->icon_url) }}" class="rounded-full w-[82px] h-[82px]" alt="ナマケモノアイコン">
        <h1 class="mt-[10px] text-white text-[1.7rem] font-bold font-darumadrop relative">{{ $user->name }} <button onclick=openDialog()><img src="{{ asset('img/edit_profile.svg') }}" class="rounded-full absolute right-[-25px] top-[15px]" alt="編集アイコン"></button></h1>
    </header>
    <section class="px-[10px] text-[12px] pb-[20px] ">
        <section class="bg-[#eaf069] w-full text-[12px] px-[10px] py-[20px] rounded-[10px] mt-[40px]">
            <section class="flex justify-between items-center pb-[17px] border-b-[1px] border-[#2A2A2A]">
                <h2 class="font-semibold">プロフィール</h2>
                <p><a href="{{ route('profile.edit') }}"  class="flex items-center font-semibold">編集する<img src="{{ asset('img/sankaku.svg') }}" class="ml-1" alt="三角"></a></p>
            </section>
            <section class="grid grid-cols-3 mt-[20px]">
                <div class="w-[108px] h-[21px] bg-white flex justify-center items-center rounded-[12px] mx-[5px]">
                    <p>{{ $user->hobbies1 }}</p>
                </div>
                <div class="w-[108px] h-[21px] bg-white flex justify-center items-center rounded-[12px] mx-[5px]">
                    <p>{{ $user->hobbies2 }}</p>
                </div>
            </section>
        </section>
        <section class="mt-[40px]">
            <h2 class="font-semibold">目標日数まで</h2>
            <div class="grid grid-cols-2 gap-[10px]">
                <section class="flex items-center justify-center bg-white rounded-[10px] h-[134px]">
                    <div class="flex flex-col justify-end">
                        <p class="flex items-center">あと<span class="text-[#F39A48] text-[58px] font-darumadrop mx-[10px] flex items-center">{{ $remaining_day }}</span>日</p>
                        <a class="text-right flex items-center justify-end font-semibold"><p class="flex">編集する<img src="{{ asset('img/sankaku.svg') }}" class="ml-1" alt="三角"></p></a>
                    </div>
                </section>
                <section>
                    <img src="{{ asset('img/namake_ganbare.svg') }}" alt="応援するナマケモノ">
                </section>
            </div>
        </section>
        
        <section class="mt-[40px] ">
            <img src="{{ asset('img/mametisiki.svg') }}" alt="豆知識">
        </section>
    </section>
</x-app-layout>

<script>
    function openDialog() {
        document.getElementById('dialog').classList.remove('hidden');
        document.getElementById('dialog').classList.add('flex');
    }

    function closeDialog(element) {
        document.getElementById('dialog').classList.remove('flex');
        document.getElementById('dialog').classList.add('hidden');
    }

    function selectIcon(element) {
        const icons = document.querySelectorAll('.iconbtn');
        icons.forEach(icon => icon.classList.remove('selected'));

        element.classList.add('selected');

        const iconValue = element.getAttribute('data-value');
        document.getElementById('icon').value = iconValue;
    }
</script>

<style>
    .iconbtn.selected {
        border: 2px solid #ED6E1B; 
        transform: scale(1.1);
    }
</style>