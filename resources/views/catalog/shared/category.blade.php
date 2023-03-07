<a href="{{ route('catalog', $item) }}" class="@if(request()->fullUrlIs('*/' . $item->slug)) btn-pink @endif p-3 sm:p-4 2xl:p-6 rounded-xl bg-card hover:bg-pink text-xxs sm:text-xs lg:text-sm text-white font-semibold">
    {{ $item->title }}
</a>
