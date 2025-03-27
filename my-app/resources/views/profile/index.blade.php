<?php
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $remaining_day = $user->target_day - $user->achieved_day;
?>

<x-app-layout>
    <header class="bg-[#F39A48] pt-[40px] pb-[20px] flex justify-center items-center flex-col">
        <img src="{{ asset('img/icon.svg') }}" class="rounded-full" alt="ナマケモノアイコン">
        <h1 class="mt-[10px] text-white text-[1.7rem] font-bold font-darumadrop">{{ $user->name }}</h1>
    </header>
    <section class="px-[10px] text-[12px] ">
        <section class="bg-[#eaf069] w-full text-[12px] px-[10px] py-[20px] rounded-[10px] mt-[40px]">
            <section class="flex justify-between items-center pb-[17px] border-b-[1px] border-[#2A2A2A]">
                <h2 class="font-semibold">プロフィール</h2>
                <p>編集する</p>
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
                        <p class="flex items-center">あと<span class="text-[#F39A48] text-[58px] font-darumadrop mx-[10px]">{{ $remaining_day }}</span>日</p>
                        <button class="text-right"><p>編集する</p></button>
                    </div>
                </section>
                <section>
                    <img src="{{ asset('img/namake_ganbare.svg') }}" alt="応援するナマケモノ">
                </section>
            </div>
        </section>
        
        <section class="mt-[40px] ">
                <section class="flex justify-between items-center pb-[17px] border-b-[1px] border-[#2A2A2A]">
                        <h2 class="font-semibold">直近メニュー</h2>
                </section>

        </section>

        </section>
    </section>
</x-app-layout>