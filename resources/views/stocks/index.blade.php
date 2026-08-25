<x-layouts.app title="在庫一覧">
    <x-slot:actions>
        <x-button variant="secondary" :href="route('stocks.movements')">変動履歴を見る</x-button>
    </x-slot:actions>

    @include('stocks.partials.products-table')
    @include('stocks.partials.parts-table')
</x-layouts.app>
