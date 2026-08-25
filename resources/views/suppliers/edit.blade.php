<x-layouts.app title="仕入先編集">
    <div class="max-w-lg">
        <div class="card">
            <x-validation-errors />

            <form method="POST" action="{{ route('suppliers.update', $supplier) }}">
                @csrf
                @method('PUT')

                <x-form.input name="name" label="仕入先名" :value="old('name', $supplier->name)" required />

                <x-form.input name="contact_info" label="連絡先" :value="old('contact_info', $supplier->contact_info)" />

                <div class="mt-6 flex items-center gap-4">
                    <x-button type="submit">更新</x-button>
                    <a href="{{ route('suppliers.index') }}" class="text-sm text-gray-600 hover:underline">一覧に戻る</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
