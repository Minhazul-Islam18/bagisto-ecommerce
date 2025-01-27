@php
    $channel = core()->getCurrentChannel();
@endphp

<!-- SEO Meta Content -->
@push ('meta')
    <meta name="title" content="{{ $channel->home_seo['meta_title'] ?? '' }}" />

    <meta name="description" content="{{ $channel->home_seo['meta_description'] ?? '' }}" />

    <meta name="keywords" content="{{ $channel->home_seo['meta_keywords'] ?? '' }}" />
@endPush

<x-shop::layouts>
    <!-- Page Title -->
    <x-slot:title>
        {{  $channel->home_seo['meta_title'] ?? '' }}
    </x-slot>

    <!-- Loop over the theme customization -->
    @foreach ($customizations as $customization)
        @php ($data = $customization->options) @endphp

        <!-- Static content -->
        @switch ($customization->type)
            @case ($customization::IMAGE_CAROUSEL)
                <!-- Image Carousel -->
                <x-shop::carousel :options="$data" aria-label="Image Carousel" />

                @break
            @case ($customization::STATIC_CONTENT)
                <!-- push style -->
                @if (! empty($data['css']))
                    @push ('styles')
                        <style>
                            {{ $data['css'] }}
                        </style>
                    @endpush
                @endif

                <!-- render html -->
                @if (! empty($data['html']))
                    {!! $data['html'] !!}
                @endif

                @break
            @case ($customization::CATEGORY_CAROUSEL)
                <!-- Categories carousel -->
                <x-shop::categories.carousel
                    :title="$data['title'] ?? ''"
                    :src="route('shop.api.categories.index', $data['filters'] ?? [])"
                    :navigation-link="route('shop.home.index')"
                    aria-label="Categories Carousel"
                />

                @break
            @case ($customization::PRODUCT_CAROUSEL)
                <!-- Product Carousel -->
                <x-shop::products.carousel
                    :title="$data['title'] ?? ''"
                    :src="route('shop.api.products.index', $data['filters'] ?? [])"
                    :navigation-link="route('shop.search.index', $data['filters'] ?? [])"
                    aria-label="Product Carousel"
                />

                @break
        @endswitch
    @endforeach

         <!-- Product Carousel -->
                <x-shop::products.carousel
                    :title="$data['title'] ?? 'Flash sales'"
                    :src="route('shop.api.products.on-flash-sale', $data['filters'] ?? [])"
                    :navigation-link="route('shop.search.index', $data['filters'] ?? [])"
                    aria-label="Product Carousel"
                />
    <div class="container mt-20 max-lg:px-8 max-md:mt-8 max-sm:mt-7 max-sm:!px-4">
        <div class="mt-8 flex items-center justify-between max-md:mt-5">
            <h1
                class="font-dmserif text-3xl max-md:text-2xl max-sm:text-xl">@lang('shop::app.products.view.our-products')</h1>
        </div>
        <!-- Product Listing -->
        <v-search>
            <x-shop::shimmer.categories.view />
        </v-search>

        @pushOnce('scripts')
            <script
                type="text/x-template"
                id="v-search-template"
            >
                <div class="">
                    <div class="flex items-start gap-10 max-lg:gap-5 md:mt-10">
                        <!-- Product Listing Container -->
                        <div class="flex-1">
                            <!-- Desktop Product Listing Toolbar -->
                            <div class="hidden">
                                @include('shop::categories.toolbar')
                            </div>

                            <!-- Product List Card Container -->
                            <div
                                class="mt-8 grid grid-cols-1 gap-6"
                                v-if="filters.toolbar.mode === 'list'"
                            >
                                <!-- Product Card Shimmer Effect -->
                                <template v-if="isLoading">
                                    <x-shop::shimmer.products.cards.list count="12" />
                                </template>

                                <!-- Product Card Listing -->
                                <template v-else>
                                    <template v-if="products.length">
                                        <x-shop::products.card
                                            ::mode="'list'"
                                            v-for="product in products"
                                        />
                                    </template>

                                    <!-- Empty Products Container -->
                                    <template v-else>
                                        <div class="m-auto grid w-full place-content-center items-center justify-items-center py-32 text-center">
                                            <img
                                                class="max-sm:h-[100px] max-sm:w-[100px]"
                                                src="{{ bagisto_asset('images/thank-you.png') }}"
                                                alt="Empty result"
                                            />

                                            <p
                                                class="text-xl max-sm:text-sm"
                                                role="heading"
                                            >
                                                @lang('shop::app.categories.view.empty')
                                            </p>
                                        </div>
                                    </template>
                                </template>
                            </div>

                            <!-- Product Grid Card Container -->
                            <div v-else>
                                <!-- Product Card Shimmer Effect -->
                                <template v-if="isLoading">
                                    <div class="mt-8 grid grid-cols-4 gap-8 max-1060:grid-cols-2 max-md:gap-x-4 max-sm:mt-5 max-sm:justify-items-center max-sm:gap-y-5">
                                        <x-shop::shimmer.products.cards.grid count="12" />
                                    </div>
                                </template>

                                <!-- Product Card Listing -->
                                <template v-else>
                                    <template v-if="products.length">
                                        <div class="mt-8 grid grid-cols-4 gap-8 max-1060:grid-cols-2 max-md:mt-5 max-md:justify-items-center max-md:gap-x-4 max-md:gap-y-5">
                                            <x-shop::products.card
                                                ::mode="'grid'"
                                                v-for="product in products"
                                                :navigation-link="route('shop.search.index')"
                                            />
                                        </div>
                                    </template>

                                    <!-- Empty Products Container -->
                                    <template v-else>
                                        <div class="m-auto grid w-full place-content-center items-center justify-items-center py-32 text-center">
                                            <img
                                                class="max-sm:h-[100px] max-sm:w-[100px]"
                                                src="{{ bagisto_asset('images/thank-you.png') }}"
                                                alt="Empty result"
                                            />

                                            <p
                                                class="text-xl max-sm:text-sm"
                                                role="heading"
                                            >
                                                @lang('shop::app.categories.view.empty')
                                            </p>
                                        </div>
                                    </template>
                                </template>
                            </div>

                            <!-- Load More Button -->
                            <button
                                class="secondary-button mx-auto mt-[60px] block w-max rounded-2xl px-11 py-3 text-center text-base max-md:rounded-lg max-md:text-sm max-sm:mt-7 max-sm:px-7 max-sm:py-2"
                                @click="loadMoreProducts"
                                v-if="links.next"
                            >
                                @lang('shop::app.categories.view.load-more')
                            </button>
                        </div>
                    </div>
                </div>
            </script>

            <script type="module">
                app.component('v-search', {
                    template: '#v-search-template',

                    data() {
                        return {
                            isMobile: window.innerWidth <= 767,

                            isLoading: true,

                            isDrawerActive: {
                                toolbar: false,

                                filter: false,
                            },

                            filters: {
                                toolbar: {},

                                filter: {},
                            },

                            products: [],

                            links: {},
                        }
                    },

                    computed: {
                        queryParams() {
                            let queryParams = Object.assign({}, this.filters.filter, this.filters.toolbar);

                            return this.removeJsonEmptyValues(queryParams);
                        },

                        queryString() {
                            return this.jsonToQueryString(this.queryParams);
                        },
                    },

                    watch: {
                        queryParams() {
                            this.getProducts();
                        },
                    },

                    methods: {
                        setFilters(type, filters) {
                            this.filters[type] = filters;
                        },

                        clearFilters(type, filters) {
                            this.filters[type] = {};
                        },

                        getProducts() {
                            this.isDrawerActive = {
                                toolbar: false,
                                filter: false,
                            };

                            this.$axios
                                .get("{{ route('shop.api.products.index') }}", {
                                    params: this.queryParams,
                                })
                                .then((response) => {
                                    this.isLoading = false;
                                    this.products = response.data.data;
                                    this.links = response.data.links;
                                })
                                .catch((error) => {
                                    console.log(error);
                                });
                        },
                        loadMoreProducts() {
                            if (this.links.next) {
                                this.$axios.get(this.links.next).then(response => {
                                    this.products = [...this.products, ...response.data.data];

                                    this.links = response.data.links;
                                }).catch(error => {
                                    console.log(error);
                                });
                            }
                        },

                        removeJsonEmptyValues(params) {
                            Object.keys(params).forEach(function (key) {
                                if ((! params[key] && params[key] !== undefined)) {
                                    delete params[key];
                                }

                                if (Array.isArray(params[key])) {
                                    params[key] = params[key].join(',');
                                }
                            });

                            return params;
                        },

                        jsonToQueryString(params) {
                            let parameters = new URLSearchParams();

                            for (const key in params) {
                                parameters.append(key, params[key]);
                            }

                            return parameters.toString();
                        }
                    },
                });
            </script>
        @endPushOnce
    </div>
</x-shop::layouts>
