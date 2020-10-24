@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])

    @push('metatags')
        <meta property="og:title" content="@lang('metatags.wallet.title')" />
        <meta property="og:description" content="@lang('metatags.wallet.description')">
    @endpush

    @section('content')
        <div class="bg-white border-t-20 border-theme-secondary-100 dark:border-black dark:bg-theme-secondary-900">
            <div class="py-16 content-container md:px-8">
                <div x-data="{
                    dropdownOpen: false,
                    selected: 'all',
                    direction: 'all',
                    transactionTypeFilter: 'all',
                    transactionTypeFilterLabel: 'All',
                }" x-cloak class="w-full">
                    <div class="w-full mb-8">
                        <div class="relative flex items-end justify-between">
                            <h2 class="text-3xl sm:text-4xl">@lang('pages.wallet.transaction_history')</h2>

                            <x-transaction-table-filter />
                        </div>
                    </div>

                    <livewire:wallet-transaction-table :address="$wallet->address" :public-key="$wallet->public_key" />
                </div>
            </div>
        </div>
    @endsection

@endcomponent