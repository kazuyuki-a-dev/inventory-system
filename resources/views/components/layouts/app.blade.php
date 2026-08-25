@props(['title' => '在庫管理システム'])

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} | 在庫管理システム</title>
    @include('partials.vite-assets')
</head>

<body class="min-h-screen bg-gray-50 text-gray-900 antialiased">
    <input type="checkbox" id="sidebar-toggle" class="peer hidden">

    <label for="sidebar-toggle" class="fixed inset-0 z-30 hidden bg-black/50 peer-checked:block lg:hidden" aria-hidden="true"></label>

    <div class="lg:flex lg:min-h-screen">
        <div class="lg:w-60 lg:shrink-0">
            <aside class="fixed inset-y-0 left-0 z-40 flex h-screen w-60 -translate-x-full flex-col overflow-y-auto bg-slate-900 text-slate-100 transition-transform duration-200 peer-checked:translate-x-0 lg:sticky lg:top-0 lg:z-auto lg:translate-x-0">
                <div class="px-6 py-5 text-lg font-semibold tracking-wide">在庫管理</div>

                <nav class="flex-1 space-y-1 px-3">
                    @php
                        $navItems = [
                            ['route' => 'dashboard', 'pattern' => 'dashboard', 'label' => 'ダッシュボード'],
                            ['route' => 'categories.index', 'pattern' => 'categories.*', 'label' => 'カテゴリ'],
                            ['route' => 'suppliers.index', 'pattern' => 'suppliers.*', 'label' => '仕入先'],
                            ['route' => 'customers.index', 'pattern' => 'customers.*', 'label' => '納入先'],
                            ['route' => 'parts.index', 'pattern' => 'parts.*', 'label' => '部品'],
                            ['route' => 'products.index', 'pattern' => 'products.*', 'label' => '商品'],
                            ['route' => 'production-orders.index', 'pattern' => 'production-orders.*', 'label' => '製造指示'],
                            ['route' => 'stocks.index', 'pattern' => 'stocks.*', 'label' => '在庫'],
                        ];
                    @endphp
                    @foreach ($navItems as $item)
                        <a
                            href="{{ route($item['route']) }}"
                            class="block rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs($item['pattern']) ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                        >
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>

                <div class="border-t border-slate-800 px-3 py-4">
                    <div class="px-3 pb-2 text-xs text-slate-400">{{ auth()->user()->name }}さん</div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full rounded-md px-3 py-2 text-left text-sm text-slate-300 hover:bg-slate-800 hover:text-white">
                            ログアウト
                        </button>
                    </form>
                </div>
            </aside>
        </div>

        <div class="flex min-h-screen min-w-0 flex-1 flex-col">
            <header class="border-b border-gray-200 bg-white px-4 py-4 sm:px-6 lg:px-8">
                <div class="mx-auto flex w-full max-w-7xl items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <label for="sidebar-toggle" class="-ml-1 cursor-pointer rounded-md p-2 text-gray-500 hover:bg-gray-100 lg:hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </label>
                        <h1 class="text-xl font-semibold text-gray-900">{{ $title }}</h1>
                    </div>
                    @isset($actions)
                        <div class="flex items-center gap-2">{{ $actions }}</div>
                    @endisset
                </div>
            </header>

            <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
                <div class="mx-auto w-full max-w-7xl">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>

</html>
