<div id="network-list" class="w-full" wire:poll.8s>
    <x-delegates.table-desktop-monitor :delegates="$delegates" />

    {{-- <x-delegates.list-mobile-monitor :delegates="$delegates" /> --}}
</div>