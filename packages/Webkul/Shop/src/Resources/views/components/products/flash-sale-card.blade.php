<v-flash-sale-product-card
    {{ $attributes }}
    :product="product"
>
</v-flash-sale-product-card>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-flash-sale-product-card-template"
    >
        <!-- Grid Card -->
        <div
            class="1180:transtion-all group w-full rounded-md 1180:relative 1180:grid 1180:content-start 1180:overflow-hidden 1180:duration-300 1180:hover:shadow-[0_5px_10px_rgba(0,0,0,0.1)]"
            v-if="mode != 'list'"
        >
            <div class="relative max-h-[300px] max-w-[291px] overflow-hidden max-md:max-h-60 max-md:max-w-full max-md:rounded-lg max-sm:max-h-[200px] max-sm:max-w-full">
                {!! view_render_event('bagisto.shop.components.products.card.image.before') !!}

                <!-- Product Image -->
                <a
                    :href="`{{ route('shop.product_or_category.index', '') }}/${product.url_key}`"
                    :aria-label="product.name + ' '"
                >
                    <x-shop::media.images.lazy
                        class="after:content-[' '] relative bg-zinc-100 transition-all duration-300 after:block after:pb-[calc(100%+9px)] group-hover:scale-105"
                        ::src="product.base_image.medium_image_url"
                        ::key="product.id"
                        ::index="product.id"
                        width="291"
                        height="300"
                        ::alt="product.name"
                    />
                </a>

                {!! view_render_event('bagisto.shop.components.products.card.image.after') !!}

                <!-- Product Ratings -->
                {!! view_render_event('bagisto.shop.components.products.card.average_ratings.before') !!}

                @if (core()->getConfigData('catalog.products.review.summary') == 'star_counts')
                    <x-shop::products.ratings
                        class="absolute bottom-1.5 items-center !border-white bg-white/80 !px-2 !py-1 text-xs max-sm:!px-1.5 max-sm:!py-0.5 ltr:left-1.5 rtl:right-1.5"
                        ::average="product.ratings.average"
                        ::total="product.ratings.total"
                        ::rating="false"
                        v-if="product.ratings.total"
                    />
                @else
                    <x-shop::products.ratings
                        class="absolute bottom-1.5 items-center !border-white bg-white/80 !px-2 !py-1 text-xs max-sm:!px-1.5 max-sm:!py-0.5 ltr:left-1.5 rtl:right-1.5"
                        ::average="product.ratings.average"
                        ::total="product.reviews.total"
                        ::rating="false"
                        v-if="product.reviews.total"
                    />
                @endif

                {!! view_render_event('bagisto.shop.components.products.card.average_ratings.after') !!}

                <div class="action-items bg-black">
                    <!-- Product Sale Badge -->
                    <p
                        class="absolute top-1.5 inline-block rounded-[44px] bg-red-600 px-2.5 text-sm text-white max-sm:rounded-l-none max-sm:rounded-r-xl max-sm:px-2 max-sm:py-0.5 max-sm:text-xs ltr:left-1.5 max-sm:ltr:left-0 rtl:right-5 max-sm:rtl:right-0"
                        v-if="product.on_sale"
                    >
                        @lang('shop::app.components.products.card.sale')
                    </p>

                    <!-- Product New Badge -->
                    <p
                        class="absolute top-1.5 inline-block rounded-[44px] bg-navyBlue px-2.5 text-sm text-white max-sm:rounded-l-none max-sm:rounded-r-xl max-sm:px-2 max-sm:py-0.5 max-sm:text-xs ltr:left-1.5 max-sm:ltr:left-0 rtl:right-1.5 max-sm:rtl:right-0"
                        v-else-if="product.is_new"
                    >
                        @lang('shop::app.components.products.card.new')
                    </p>

                    <div class="opacity-0 transition-all duration-300 group-hover:bottom-0 group-hover:opacity-100 max-lg:opacity-100 max-sm:opacity-100">

                        {!! view_render_event('bagisto.shop.components.products.card.wishlist_option.before') !!}

                        @if (core()->getConfigData('customer.settings.wishlist.wishlist_option'))
                            <span
                                class="absolute top-2.5 flex h-6 w-6 items-center justify-center rounded-full border border-zinc-200 bg-white text-lg md:hidden ltr:right-1.5 rtl:left-1.5"
                                role="button"
                                aria-label="@lang('shop::app.components.products.card.add-to-wishlist')"
                                tabindex="0"
                                :class="product.is_wishlist ? 'icon-heart-fill text-red-500' : 'icon-heart'"
                                @click="addToWishlist()"
                            >
                            </span>
                        @endif

                        {!! view_render_event('bagisto.shop.components.products.card.wishlist_option.after') !!}

                        {!! view_render_event('bagisto.shop.components.products.card.compare_option.before') !!}

                        @if (core()->getConfigData('catalog.products.settings.compare_option'))
                            <span
                                class="icon-compare absolute top-10 flex h-6 w-6 items-center justify-center rounded-full border border-zinc-200 bg-white text-lg sm:hidden ltr:right-1.5 rtl:left-1.5"
                                role="button"
                                aria-label="@lang('shop::app.components.products.card.add-to-compare')"
                                tabindex="0"
                                @click="addToCompare(product.id)"
                            >
                            </span>
                        @endif

                        {!! view_render_event('bagisto.shop.components.products.card.compare_option.after') !!}

                    </div>
                </div>
            </div>

            <!-- Product Information Section -->
            <div class="-mt-9 grid max-w-[291px] translate-y-9 content-start gap-2.5 bg-white p-2.5 transition-transform duration-300 ease-out group-hover:-translate-y-0 group-hover:rounded-t-lg max-md:relative max-md:mt-0 max-md:translate-y-0 max-md:gap-0 max-md:px-0 max-md:py-1.5 max-sm:min-w-[170px] max-sm:max-w-[192px]">
                <div  v-if="countdownLabel" class="flex items-center space-x-2 bg-red-100 text-red-700 px-3 py-2 rounded-lg shadow-md flex-col">
                    <span class="text-emerald-500 font-semibold">@{{ countdownLabel }}</span>
                    <div class="flex gap-2.5 items-center justify-center space-x-1 w-full">
                        <span class="bg-black h-12 w-12 flex items-center justify-center text-white rounded text-sm font-semibold">
                            @{{ countdown.days }}d
                        </span>
                        <span class="bg-black h-12 w-12 flex items-center justify-center text-white rounded text-sm font-semibold">
                            @{{ countdown.hours }}h
                        </span>
                        <span class="bg-black h-12 w-12 flex items-center justify-center text-white rounded text-sm font-semibold">
                            @{{ countdown.minutes }}m
                        </span>
                        <span class="bg-black h-12 w-12 flex items-center justify-center text-white rounded text-sm font-semibold">
                            @{{ countdown.seconds }}s
                        </span>
                    </div>
                </div>
                {!! view_render_event('bagisto.shop.components.products.card.name.before') !!}

                <p class="break-all text-base font-medium max-md:mb-1.5 max-md:max-w-56 max-md:whitespace-break-spaces max-md:leading-6 max-sm:max-w-[192px] max-sm:text-sm max-sm:leading-4">
                    @{{ product.name }}
                </p>

                {!! view_render_event('bagisto.shop.components.products.card.name.after') !!}

                <!-- Pricing -->
                {!! view_render_event('bagisto.shop.components.products.card.price.before') !!}

                <div
                    class="flex items-center gap-2.5 text-lg font-semibold max-sm:text-sm max-sm:leading-6"
                    v-html="product.price_html"
                >
                </div>

                {!! view_render_event('bagisto.shop.components.products.card.price.after') !!}

                <!-- Product Actions Section -->
                <div class="action-items flex items-center justify-between opacity-0 transition-all duration-300 ease-in-out group-hover:opacity-100 max-md:hidden">
                    @if (core()->getConfigData('sales.checkout.shopping_cart.cart_page'))
                        {!! view_render_event('bagisto.shop.components.products.card.add_to_cart.before') !!}

                        <button
                            class="secondary-button w-full max-w-full p-2.5 text-sm font-medium max-sm:rounded-xl max-sm:p-2"
                            :disabled="! product.is_saleable || isAddingToCart"
                            @click="addToCart()"
                        >
                            @lang('shop::app.components.products.card.add-to-cart')
                        </button>

                        {!! view_render_event('bagisto.shop.components.products.card.add_to_cart.after') !!}
                    @endif

                    {!! view_render_event('bagisto.shop.components.products.card.wishlist_option.before') !!}

                    @if (core()->getConfigData('customer.settings.wishlist.wishlist_option'))
                        <span
                            class="cursor-pointer p-2.5 text-2xl max-sm:hidden"
                            role="button"
                            aria-label="@lang('shop::app.components.products.card.add-to-wishlist')"
                            tabindex="0"
                            :class="product.is_wishlist ? 'icon-heart-fill text-red-600' : 'icon-heart'"
                            @click="addToWishlist()"
                        >
                        </span>
                    @endif

                    {!! view_render_event('bagisto.shop.components.products.card.wishlist_option.after') !!}

                    {!! view_render_event('bagisto.shop.components.products.card.compare_option.before') !!}

                    @if (core()->getConfigData('catalog.products.settings.compare_option'))
                        <span
                            class="icon-compare cursor-pointer p-2.5 text-2xl max-sm:hidden"
                            role="button"
                            aria-label="@lang('shop::app.components.products.card.add-to-compare')"
                            tabindex="0"
                            @click="addToCompare(product.id)"
                        >
                        </span>
                    @endif

                    {!! view_render_event('bagisto.shop.components.products.card.compare_option.after') !!}
                </div>
            </div>
        </div>

        <!-- List Card -->
        <div
            class="relative flex max-w-max grid-cols-2 gap-4 overflow-hidden rounded max-sm:flex-wrap"
            v-else
        >
            <div class="group relative max-h-[258px] max-w-[250px] overflow-hidden">

                {!! view_render_event('bagisto.shop.components.products.card.image.before') !!}

                <a :href="`{{ route('shop.product_or_category.index', '') }}/${product.url_key}`">
                    <x-shop::media.images.lazy
                        class="after:content-[' '] relative min-w-[250px] bg-zinc-100 transition-all duration-300 after:block after:pb-[calc(100%+9px)] group-hover:scale-105"
                        ::src="product.base_image.medium_image_url"
                        ::key="product.id"
                        ::index="product.id"
                        width="291"
                        height="300"
                        ::alt="product.name"
                    />
                </a>

                {!! view_render_event('bagisto.shop.components.products.card.image.after') !!}

                <div class="action-items bg-black">
                    <p
                        class="absolute top-5 inline-block rounded-[44px] bg-red-500 px-2.5 text-sm text-white ltr:left-5 max-sm:ltr:left-2 rtl:right-5"
                        v-if="product.on_sale"
                    >
                        @lang('shop::app.components.products.card.sale')
                    </p>

                    <p
                        class="absolute top-5 inline-block rounded-[44px] bg-navyBlue px-2.5 text-sm text-white ltr:left-5 max-sm:ltr:left-2 rtl:right-5"
                        v-else-if="product.is_new"
                    >
                        @lang('shop::app.components.products.card.new')
                    </p>

                    <div class="opacity-0 transition-all duration-300 group-hover:bottom-0 group-hover:opacity-100 max-sm:opacity-100">

                        {!! view_render_event('bagisto.shop.components.products.card.wishlist_option.before') !!}

                        @if (core()->getConfigData('customer.settings.wishlist.wishlist_option'))
                            <span
                                class="absolute top-5 flex h-[30px] w-[30px] cursor-pointer items-center justify-center rounded-md bg-white text-2xl ltr:right-5 rtl:left-5"
                                role="button"
                                aria-label="@lang('shop::app.components.products.card.add-to-wishlist')"
                                tabindex="0"
                                :class="product.is_wishlist ? 'icon-heart-fill text-red-600' : 'icon-heart'"
                                @click="addToWishlist()"
                            >
                            </span>
                        @endif

                        {!! view_render_event('bagisto.shop.components.products.card.wishlist_option.after') !!}

                        {!! view_render_event('bagisto.shop.components.products.card.compare_option.before') !!}

                        @if (core()->getConfigData('catalog.products.settings.compare_option'))
                            <span
                                class="icon-compare absolute top-16 flex h-[30px] w-[30px] cursor-pointer items-center justify-center rounded-md bg-white text-2xl ltr:right-5 rtl:left-5"
                                role="button"
                                aria-label="@lang('shop::app.components.products.card.add-to-compare')"
                                tabindex="0"
                                @click="addToCompare(product.id)"
                            >
                            </span>
                        @endif

                        {!! view_render_event('bagisto.shop.components.products.card.compare_option.after') !!}
                    </div>
                </div>
            </div>

            <div class="grid content-start gap-4">

                {!! view_render_event('bagisto.shop.components.products.card.name.before') !!}

                <p class="text-base">
                    @{{ product.name }}
                </p>

                {!! view_render_event('bagisto.shop.components.products.card.name.after') !!}

                {!! view_render_event('bagisto.shop.components.products.card.price.before') !!}

                <div
                    class="flex gap-2.5 text-lg font-semibold"
                    v-html="product.price_html"
                >
                </div>

                {!! view_render_event('bagisto.shop.components.products.card.price.after') !!}

                <!-- Needs to implement that in future -->
                <div class="flex hidden gap-4">
                    <span class="block h-[30px] w-[30px] rounded-full bg-[#B5DCB4]">
                    </span>

                    <span class="block h-[30px] w-[30px] rounded-full bg-zinc-500">
                    </span>
                </div>

                {!! view_render_event('bagisto.shop.components.products.card.average_ratings.before') !!}

                <p class="text-sm text-zinc-500">
                    <template  v-if="! product.ratings.total">
                        <p class="text-sm text-zinc-500">
                            @lang('shop::app.components.products.card.review-description')
                        </p>
                    </template>

                    <template v-else>
                        @if (core()->getConfigData('catalog.products.review.summary') == 'star_counts')
                            <x-shop::products.ratings
                                ::average="product.ratings.average"
                                ::total="product.ratings.total"
                                ::rating="false"
                            />
                        @else
                            <x-shop::products.ratings
                                ::average="product.ratings.average"
                                ::total="product.reviews.total"
                                ::rating="false"
                            />
                        @endif
                    </template>
                </p>

                {!! view_render_event('bagisto.shop.components.products.card.average_ratings.after') !!}

                @if (core()->getConfigData('sales.checkout.shopping_cart.cart_page'))

                    {!! view_render_event('bagisto.shop.components.products.card.add_to_cart.before') !!}

                    <x-shop::button
                        class="primary-button whitespace-nowrap px-8 py-2.5"
                        :title="trans('shop::app.components.products.card.add-to-cart')"
                        ::loading="isAddingToCart"
                        ::disabled="! product.is_saleable || isAddingToCart"
                        @click="addToCart()"
                    />

                    {!! view_render_event('bagisto.shop.components.products.card.add_to_cart.after') !!}

                @endif
            </div>
        </div>
    </script>

  <script type="module">
    app.component('v-flash-sale-product-card', {
        template: '#v-flash-sale-product-card-template',

        props: ['mode', 'product'],

        data() {
            return {
                isCustomer: '{{ auth()->guard('customer')->check() }}',

                isAddingToCart: false,
                countdown: {
                    days: 0,
                    hours: 0,
                    minutes: 0,
                    seconds: 0,
                },
                timer: null,
            };
        },

        computed: {
            showTimer() {
                return this.product.special_price_from && this.product.special_price_to;
            },

            countdownLabel() {
                const now = new Date();
                const specialPriceFrom = new Date(this.product.special_price_from);
                const specialPriceTo = new Date(this.product.special_price_to);

                if (specialPriceFrom > now) {
                    return '⏱️ Sale starts in';
                } else if (specialPriceTo > now) {
                    return '⏳ Sale ends in';
                } else {
                    return null;
                }
            }
        },

        methods: {
            updateCountdown() {
                if (!this.showTimer || !this.countdownLabel) return;

                const targetTime = this.countdownLabel === 'Sale starts in'
                    ? new Date(this.product.special_price_from)
                    : new Date(this.product.special_price_to);

                const now = new Date();

                if (targetTime > now) {
                    const diff = targetTime - now;

                    this.countdown.days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    this.countdown.hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    this.countdown.minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    this.countdown.seconds = Math.floor((diff % (1000 * 60)) / 1000);
                } else {
                    this.countdown = { days: 0, hours: 0, minutes: 0, seconds: 0 };
                    clearInterval(this.timer);
                }
            },
        },

        mounted() {
            if (this.showTimer) {
                this.updateCountdown();
                this.timer = setInterval(this.updateCountdown, 1000);
            }
        },

        beforeDestroy() {
            clearInterval(this.timer);
        }
    });
</script>
@endpushOnce
