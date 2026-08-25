<x-layouts.app title="カテゴリ新規登録">
    <div class="max-w-lg">
        <div class="card">
            <x-validation-errors />

            <form method="POST" action="{{ route('categories.store') }}">
                @csrf

                <x-form.input name="name" label="カテゴリ名" :value="old('name')" required />

                <div class="mt-6 flex items-center gap-4">
                    <x-button type="submit">登録</x-button>
                    <a href="{{ route('categories.index') }}" class="text-sm text-gray-600 hover:underline">一覧に戻る</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
