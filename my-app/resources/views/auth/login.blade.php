<x-guest-layout>
    <div class="flex flex-col items-center justify-center h-full">
        <img src="{{ asset('img/namake_mado.svg') }}" alt="ナマケアイコン">
        <h1 class="mt-[30px] text-white font-semibold text-[17px]">ログイン</h1>
    
        <form method="POST" action="{{ route('login') }}">
            @csrf
    
            <!-- Email Address -->
            <div class="mt-[20px]">
                <input id="email" class="block mt-1  w-[234px] rounded-[10px]" placeholder="メールアドレス" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
    
            <!-- Password -->
            <div class="mt-[20px]">
                <input id="password" class="block  w-[234px] rounded-[10px] mt-1 "
                                type="password"
                                name="password"
                                placeholder="パスワード"
                                required autocomplete="current-password" />
    
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
    
            <!-- Remember Me -->
            <!-- <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                </label>
            </div> -->
    
            <div class="flex items-center justify-center mt-[20px]">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-white hover:text-gray-900  rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                        {{ __('パスワードをお忘れですか？') }}
                    </a>
                @endif
            </div>

            <button class="bg-[#4EBDE5] border-[2px] border-white w-[157px] py-[10px] text-white flex items-center justify-center rounded-[10px] mt-[20px] m-auto">
                {{ __('ログイン') }}
            </button>
        </form>
        <div>
              <button class="bg-[#70D648] border-[2px] border-white w-[157px] py-[10px] text-white flex items-center justify-center rounded-[10px] mt-[20px] m-auto">
                  {{ __('新規登録はこちら') }}
              </button>
        </div>
    </div>
</x-guest-layout>
