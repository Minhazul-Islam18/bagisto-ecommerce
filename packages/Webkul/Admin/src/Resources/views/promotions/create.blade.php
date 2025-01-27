<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.promotions.create.title')
    </x-slot>

    <!-- Promotion Form Template -->
    <script type="text/x-template" id="v-create-promotion-template">
        <x-admin::form :action="route('admin.promotions.store')" enctype="multipart/form-data">
            <div>
                <label>Promotion Name</label>
                <input type="text" v-model="promotion.name" required>
            </div>

            <div>
                <label>Discount Type</label>
                <select v-model="promotion.discountType">
                    <option value="fixed">Fixed</option>
                    <option value="percentage">Percentage</option>
                </select>
            </div>

            <div>
                <label>Discount Value</label>
                <input type="number" v-model="promotion.discountValue" required>
            </div>

            <div>
                <label>Start Date</label>
                <input type="date" v-model="promotion.startDate" required>
            </div>

            <div>
                <label>End Date</label>
                <input type="date" v-model="promotion.endDate" required>
            </div>

            <div>
                <label>Promotion Image</label>
                <input type="file" @change="handleFileUpload">
                <img v-if="promotion.imageUrl" :src="promotion.imageUrl" width="100">
            </div>

            <button type="submit">Save Promotion</button>
        </x-admin::form>
    </script>

    <div id="v-create-promotion-container">
        <v-create-promotion></v-create-promotion>
    </div>

    @pushOnce('scripts')
        <script>
            if (typeof app !== 'undefined') {
                app.component('v-create-promotion', {
                    template: '#v-create-promotion-template',
                    data() {
                        return {
                            promotion: {
                                name: '',
                                discountType: 'fixed',
                                discountValue: '',
                                startDate: '',
                                endDate: '',
                                image: null,
                                imageUrl: null
                            }
                        };
                    },
                    methods: {
                        handleFileUpload(event) {
                            const file = event.target.files[0];
                            if (file) {
                                this.promotion.image = file;
                                this.promotion.imageUrl = URL.createObjectURL(file);
                            }
                        },

                        storePromotion() {
                            let formData = new FormData();
                            formData.append('name', this.promotion.name);
                            formData.append('discount_type', this.promotion.discountType);
                            formData.append('discount_value', this.promotion.discountValue);
                            formData.append('start_date', this.promotion.startDate);
                            formData.append('end_date', this.promotion.endDate);
                            formData.append('image', this.promotion.image);

                            fetch('/admin/promotions/store', {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                alert("Promotion Created Successfully!");
                            })
                            .catch(error => {
                                console.error("Error:", error);
                            });
                        }
                    }
                });

                // Mount Vue to the specific container
                app.mount("#v-create-promotion-container");
            } else {
                console.error("Vue app instance 'app' is not defined. Component registration failed.");
            }
        </script>
    @endpushOnce
</x-admin::layouts>
