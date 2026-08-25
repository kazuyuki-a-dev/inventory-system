<x-layouts.app title="入庫登録">
    <div class="max-w-lg">
        <div class="card">
            <p class="mb-1 text-sm text-gray-600">{{ $part->name }}（SKU: {{ $part->sku }}）</p>
            <p class="mb-6 text-sm text-gray-600">現在庫数: {{ $part->currentStock() }}{{ $part->unit }}</p>

            <x-validation-errors />

            <form method="POST" action="{{ route('parts.stock-in.store', $part) }}">
                @csrf

                <x-form.input name="quantity" label="入庫数量" type="number" min="1" :value="old('quantity')" required />

                <x-form.input name="memo" label="メモ(任意)" :value="old('memo')" placeholder="例: ○○株式会社から入荷" />

                <div class="mt-6 flex items-center gap-4">
                    <x-button type="submit">入庫登録</x-button>
                    <a href="{{ route('parts.index') }}" class="text-sm text-gray-600 hover:underline">一覧に戻る</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
