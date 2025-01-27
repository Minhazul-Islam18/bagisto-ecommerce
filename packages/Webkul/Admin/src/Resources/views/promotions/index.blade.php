<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.promotions.index.title')
    </x-slot>

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <!-- Title -->
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            @lang('admin::app.promotions.index.title')
        </p>

        <div class="flex items-center gap-x-2.5">
            @if (bouncer()->hasPermission('promotions.create'))
                <a href="{{ route('admin.promotions.create') }}">
                    <div class="primary-button">
                        @lang('admin::app.promotions.index.create-btn')
                    </div>
                </a>
            @endif
        </div>
    </div>

    {!! view_render_event('bagisto.admin.promotions.list.before') !!}

    <x-admin::datagrid :src="route('admin.promotions.index')" />

    {!! view_render_event('bagisto.admin.promotions.list.after') !!}

</x-admin::layouts>
