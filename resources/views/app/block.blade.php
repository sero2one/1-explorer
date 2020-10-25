@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])

    @push('metatags')
        <meta property="og:title" content="@lang('metatags.block.title')" />
        <meta property="og:description" content="@lang('metatags.block.description')">
    @endpush

    @push('scripts')
        <script src="{{ mix('js/clipboard.js')}}"></script>
    @endpush

    @section('breadcrumbs')
        <x-general.breadcrumbs :crumbs="[
            ['route' => 'home', 'label' => trans('menus.home')],
            ['label' => trans('menus.block')],
        ]" />
    @endsection

    @section('content')
        <x-block.header :block="$block" />

        <x-details.grid>
            <x-details.generic :title="trans('general.block.height')" icon="app-volume">
                {{ $block->height() }}
            </x-details.generic>

            <x-details.generic :title="trans('general.block.timestamp')" icon="app-volume">
                {{ $block->timestamp() }}
            </x-details.generic>

            <x-details.generic :title="trans('general.block.reward')" icon="app-volume">
                {{ $block->reward() }}
            </x-details.generic>

            <x-details.generic :title="trans('general.block.fee')" icon="app-volume">
                {{ $block->fee() }}
            </x-details.generic>

            <x-details.generic :title="trans('general.block.confirmations')" icon="app-volume">
                {{ $block->confirmations() }}
            </x-details.generic>
        </x-details.grid>

        <div class="bg-white border-t-20 border-theme-secondary-100 dark:border-black dark:bg-theme-secondary-900">
            <div class="py-16 content-container md:px-8">
                <div id="transaction-list" class="w-full">
                    <div class="relative flex items-end justify-between mb-8">
                        <h2 class="text-3xl sm:text-4xl">@lang('pages.block.transactions')</h2>
                    </div>

                    <x-transactions.table-desktop :transactions="$transactions" />

                    <x-transactions.list-mobile :transactions="$transactions" />
                </div>
            </div>
        </div>
    @endsection

@endcomponent
