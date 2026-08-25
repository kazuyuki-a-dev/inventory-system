<x-layouts.app title="カテゴリ一覧">
    <x-slot:actions>
        <x-button :href="route('categories.create')">新規登録</x-button>
    </x-slot:actions>

    <x-flash-message />

    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>カテゴリ名</th>
                    <th>登録日</th>
                    <th class="text-right">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->created_at->format('Y/m/d') }}</td>
                        <td class="text-right">
                            <div class="flex justify-end gap-2">
                                <x-button variant="secondary" :href="route('categories.edit', $category)">編集</x-button>
                                <x-delete-button :action="route('categories.destroy', $category)" />
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>
</x-layouts.app>
