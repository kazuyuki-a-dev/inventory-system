<x-layouts.guest title="ログイン">
    <x-validation-errors />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <x-form.input name="email" label="メールアドレス" type="email" :value="old('email')" required autofocus />

        <x-form.input name="password" label="パスワード" type="password" required />

        <x-button type="submit" class="w-full">ログイン</x-button>
    </form>
</x-layouts.guest>
