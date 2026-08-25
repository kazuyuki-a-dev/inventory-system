<x-layouts.app title="納入先一覧">
    <x-slot:actions>
        <x-button :href="route('customers.create')">新規登録</x-button>
    </x-slot:actions>

    <x-flash-message />

    <x-search-form placeholder="納入先名で検索" />

    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>納入先名</th>
                    <th>連絡先</th>
                    <th>登録日</th>
                    <th class="text-right">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->contact_info }}</td>
                        <td>{{ $customer->created_at->format('Y/m/d') }}</td>
                        <td class="text-right">
                            <div class="flex justify-end gap-2">
                                <x-button variant="secondary" :href="route('customers.show', $customer)">取引一覧</x-button>
                                <x-button variant="secondary" :href="route('customers.edit', $customer)">編集</x-button>
                                <x-delete-button :action="route('customers.destroy', $customer)" />
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $customers->appends(request()->query())->links() }}
    </div>
</x-layouts.app>
