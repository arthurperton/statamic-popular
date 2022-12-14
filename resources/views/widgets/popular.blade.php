<div class="card p-0 overflow-hidden h-full">
    <div class="flex justify-between items-center p-2">
        <h2>
            <a class="flex items-center" href="{{ $collection->showUrl() }}">
                <div class="h-6 w-6 mr-1 text-grey-80">
                    @cp_svg('content-writing')
                </div>
                <span class="text-grey-70">Top {{ $limit }}</span>&nbsp;<span>{{ $title }}</span>
            </a>
        </h2>
        @can('create', ['Statamic\Contracts\Entries\Entry', $collection])
            <a href="{{ $collection->createEntryUrl() }}"
                class="text-blue hover:text-blue-dark text-sm">{{ $button }}</a>
        @endcan
    </div>
    <popular-widget collection="{{ $collection->handle() }}" initial-sort-column="pageviews" initial-sort-direction="desc"
        initial-per-page="{{ $limit }}"></popular-widget>
</div>
