<x-guest-layout>
    <div class="flex flex-col items-center justify-center h-full">
        <img src="{{ asset('img/namake_mado.svg') }}" alt="ナマケアイコン">
        <h1 class="mt-[30px] text-white font-semibold text-[17px]">新規会員登録</h1>
    
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div>
                <input id="name" class="block mt-[20px] w-[234px] rounded-[10px]" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="名前" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
    
            <!-- Email Address -->
            <div class="mt-[20px]">
                <input id="email" class="block mt-1  w-[234px] rounded-[10px]" placeholder="メールアドレス" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
    
            <!-- Password -->
            <div class="mt-[20px]">
                <input id="password" class="block w-[234px] rounded-[10px] mt-1"
                                type="password"
                                name="password"
                                placeholder="パスワード"
                                required autocomplete="current-password" />
    
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-4">
                <input id="password_confirmation" class="block w-[234px] rounded-[10px] mt-1"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" placeholder="パスワード確認" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <button class="bg-[#4EBDE5] border-[2px] border-white text-[12px] p-[12.5px] py-[10px] text-white flex items-center justify-center rounded-[10px] mt-[20px] m-auto">
                {{ __('この内容で会員登録する') }}
            </button>
        </form>
    </div>
</x-guest-layout>


