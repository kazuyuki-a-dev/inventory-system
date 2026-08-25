<x-layouts.app title="製造指示新規登録">
    <div class="max-w-lg">
        <div class="card">
            <x-validation-errors />

            <form method="POST" action="{{ route('production-orders.store') }}">
                @csrf

                <x-form.select name="product_id" label="商品" required>
                    <option value="">選択してください</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>
                            {{ $product->name }}(SKU: {{ $product->sku }})
                        </option>
                    @endforeach
                </x-form.select>

                <x-form.input name="quantity" label="製造数量" type="number" min="1" :value="old('quantity')" required />

                <x-form.input name="planned_date" label="予定日" type="date" :value="old('planned_date')" />

                <div class="mt-6 flex items-center gap-4">
                    <x-button type="submit">登録</x-button>
                    <a href="{{ route('production-orders.index') }}" class="text-sm text-gray-600 hover:underline">一覧に戻る</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
