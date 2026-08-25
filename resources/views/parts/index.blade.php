<x-layouts.app title="部品一覧">
    <x-slot:actions>
        <x-button :href="route('parts.create')">新規登録</x-button>
    </x-slot:actions>

    <x-flash-message />

    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>部品名</th>
                    <th>仕入先</th>
                    <th>単価</th>
                    <th class="text-right">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($parts as $part)
                    <tr>
                        <td>{{ $part->sku }}</td>
                        <td>{{ $part->name }}</td>
                        <td>{{ $part->supplier->name }}</td>
                        <td>{{ number_format($part->price) }}円</td>
                        <td class="text-right">
                            <div class="flex justify-end gap-2">
                                <x-button variant="secondary" :href="route('parts.stock-in.create', $part)">入庫登録</x-button>
                                <x-button variant="secondary" :href="route('parts.edit', $part)">編集</x-button>
                                <x-delete-button :action="route('parts.destroy', $part)" />
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $parts->links() }}
    </div>
</x-layouts.app>
