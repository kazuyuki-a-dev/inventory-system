<x-layouts.guest title="ログイン">
    <x-validation-errors />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <x-form.input name="email" label="メールアドレス" type="email" :value="old('email')" required autofocus />

        <x-form.input name="password" label="パスワード" type="password" required />

        <x-button type="submit" class="w-full">ログイン</x-button>
    </form>

    <p class="mt-4 text-center text-sm text-gray-600">
        <a href="{{ route('register') }}" class="text-brand hover:underline">会員登録はこちら</a>
    </p>
</x-layouts.guest>
