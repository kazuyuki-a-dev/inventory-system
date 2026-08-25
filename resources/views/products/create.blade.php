<x-layouts.app title="商品新規登録">
    <div class="max-w-lg">
        <div class="card">
            <x-validation-errors />

            <form method="POST" action="{{ route('products.store') }}">
                @csrf

                <x-form.select name="category_id" label="カテゴリ" required>
                    <option value="">選択してください</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </x-form.select>

                <x-form.select name="customer_id" label="納入先" required>
                    <option value="">選択してください</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </x-form.select>

                <x-form.input name="sku" label="SKU" :value="old('sku')" required />

                <x-form.input name="name" label="商品名" :value="old('name')" required />

                <x-form.input name="unit" label="単位" :value="old('unit')" required />

                <x-form.input name="price" label="単価" type="number" step="0.01" :value="old('price')" required />

                <div class="mt-6 flex items-center gap-4">
                    <x-button type="submit">登録</x-button>
                    <a href="{{ route('products.index') }}" class="text-sm text-gray-600 hover:underline">一覧に戻る</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
