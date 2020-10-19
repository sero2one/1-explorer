<div class="flex items-center justify-between py-8 @if($noBorder ?? false) border-0 @endif">
    <div>
        <div class="font-semibold">{{ $title }}</div>
        <div class="text-sm text-theme-secondary-500">{{ $subtitle }}</div>
    </div>

    <div>
        {{ $slot }}
    </div>
</div>