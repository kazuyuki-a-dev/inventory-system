<x-layouts.app title="カテゴリ編集">
    <div class="max-w-lg">
        <div class="card">
            <x-validation-errors />

            <form method="POST" action="{{ route('categories.update', $category) }}">
                @csrf
                @method('PUT')

                <x-form.input name="name" label="カテゴリ名" :value="old('name', $category->name)" required />

                <div class="mt-6 flex items-center gap-4">
                    <x-button type="submit">更新</x-button>
                    <a href="{{ route('categories.index') }}" class="text-sm text-gray-600 hover:underline">一覧に戻る</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
