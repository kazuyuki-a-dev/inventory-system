<x-layouts.app title="仕入先一覧">
    <x-slot:actions>
        <x-button :href="route('suppliers.create')">新規登録</x-button>
    </x-slot:actions>

    <x-flash-message />

    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>仕入先名</th>
                    <th>連絡先</th>
                    <th>登録日</th>
                    <th class="text-right">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suppliers as $supplier)
                    <tr>
                        <td>{{ $supplier->id }}</td>
                        <td>{{ $supplier->name }}</td>
                        <td>{{ $supplier->contact_info }}</td>
                        <td>{{ $supplier->created_at->format('Y/m/d') }}</td>
                        <td class="text-right">
                            <div class="flex justify-end gap-2">
                                <x-button variant="secondary" :href="route('suppliers.show', $supplier)">取引一覧</x-button>
                                <x-button variant="secondary" :href="route('suppliers.edit', $supplier)">編集</x-button>
                                <x-delete-button :action="route('suppliers.destroy', $supplier)" />
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $suppliers->links() }}
    </div>
</x-layouts.app>
