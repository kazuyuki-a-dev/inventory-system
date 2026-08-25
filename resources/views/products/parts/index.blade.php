<x-layouts.app :title="$product->name . 'の部品表'">
    <p class="mb-6 text-sm text-gray-600">{{ $product->name }}(SKU: {{ $product->sku }})の部品表</p>

    <x-flash-message />
    <x-validation-errors />

    <h2 class="mb-3 text-lg font-semibold text-gray-900">必要な部品一覧</h2>

    <div class="table-wrap mb-8">
        <table class="data-table">
            <thead>
                <tr>
                    <th>部品SKU</th>
                    <th>部品名</th>
                    <th>必要数</th>
                    <th>現在庫数</th>
                    <th>単位</th>
                    <th class="text-right">操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($product->parts as $part)
                    @php
                        $currentStock = $part->currentStock();
                        $isShort = $currentStock < $part->pivot->quantity_required;
                    @endphp
                    <tr>
                        <td>{{ $part->sku }}</td>
                        <td>{{ $part->name }}</td>
                        <td>
                            <form action="{{ route('products.parts.update', [$product, $part]) }}" method="POST" class="inline-flex items-center gap-2">
                                @csrf
                                @method('PUT')
                                <input type="number" name="quantity_required" value="{{ $part->pivot->quantity_required }}" min="1" class="form-input w-20">
                                <button type="submit" class="btn btn-secondary">更新</button>
                            </form>
                        </td>
                        <td class="{{ $isShort ? 'font-semibold text-red-600' : '' }}">{{ $currentStock }}</td>
                        <td>{{ $part->unit }}</td>
                        <td class="text-right">
                            <x-delete-button :action="route('products.parts.destroy', [$product, $part])" />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500">まだ部品が割り当てられていません。</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <h2 class="mb-3 text-lg font-semibold text-gray-900">部品を追加</h2>

    @if ($availableParts->isEmpty())
        <p class="text-sm text-gray-600">追加できる部品がありません(すべて割り当て済みです)。</p>
    @else
        <form action="{{ route('products.parts.store', $product) }}" method="POST" class="card flex flex-wrap items-end gap-4">
            @csrf

            <div>
                <label for="part_id" class="form-label">部品</label>
                <select id="part_id" name="part_id" required class="form-select">
                    <option value="">選択してください</option>
                    @foreach ($availableParts as $part)
                        <option value="{{ $part->id }}">{{ $part->name }}(SKU: {{ $part->sku }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="quantity_required" class="form-label">必要数</label>
                <input id="quantity_required" type="number" name="quantity_required" min="1" value="1" required class="form-input w-24">
            </div>

            <x-button type="submit">追加</x-button>
        </form>
    @endif

    <p class="mt-6">
        <a href="{{ route('products.index') }}" class="text-sm text-brand hover:underline">商品一覧に戻る</a>
    </p>
</x-layouts.app>
