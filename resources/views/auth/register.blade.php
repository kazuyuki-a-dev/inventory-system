<x-layouts.guest title="会員登録">
    <x-validation-errors />

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <x-form.input name="name" label="名前" :value="old('name')" required autofocus />

        <x-form.input name="email" label="メールアドレス" type="email" :value="old('email')" required />

        <x-form.input name="password" label="パスワード" type="password" required />

        <x-form.input name="password_confirmation" label="パスワード(確認)" type="password" required />

        <x-button type="submit" class="w-full">登録</x-button>
    </form>

    <p class="mt-4 text-center text-sm text-gray-600">
        <a href="{{ route('login') }}" class="text-brand hover:underline">ログインはこちら</a>
    </p>
</x-layouts.guest>
