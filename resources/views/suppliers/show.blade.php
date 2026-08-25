<x-layouts.app :title="$supplier->name . 'の取引一覧'">
    <p class="mb-6 text-sm text-gray-600">{{ $supplier->name }}が納めている部品一覧</p>

    @if ($supplier->parts->isEmpty())
        <p class="text-sm text-gray-600">取引のある部品はありません。</p>
    @else
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>部品名</th>
                        <th>単価</th>
                        <th class="text-right">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($supplier->parts as $part)
                        <tr>
                            <td>{{ $part->sku }}</td>
                            <td>{{ $part->name }}</td>
                            <td>{{ number_format($part->price) }}円</td>
                            <td class="text-right">
                                <x-button variant="secondary" :href="route('parts.edit', $part)">編集</x-button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <p class="mt-6">
        <a href="{{ route('suppliers.index') }}" class="text-sm text-brand hover:underline">仕入先一覧に戻る</a>
    </p>
</x-layouts.app>
