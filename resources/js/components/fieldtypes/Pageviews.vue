<template>
    <div>
        <text-input
            ref="input"
            type="number"
            :is-read-only="!editing"
            :value="pending"
            @input="updatePending"
        />
        <div v-if="saving" class="mt-1 h-6 px-1 flex justify-end text-sm">
            <loading-graphic inline :text="__('Saving')" />
        </div>
        <div v-else class="mt-1 h-6 px-1 flex justify-between text-sm">
            <button
                v-if="!editing"
                class="
                    text-button text-blue
                    hover:text-grey-80
                    mr-3
                    flex
                    items-center
                    outline-none
                "
                @click="edit"
            >
                {{ __("Edit") }}
            </button>

            <button
                v-if="editing"
                class="
                    text-button text-blue
                    hover:text-grey-80
                    mr-3
                    flex
                    items-center
                    outline-none
                "
                @click="cancel"
            >
                {{ __("Cancel") }}
            </button>

            <button
                v-if="editing"
                class="
                    text-button text-blue
                    hover:text-grey-80
                    flex
                    items-center
                    outline-none
                "
                @click="confirm"
            >
                {{ __("Confirm") }}
            </button>
        </div>
    </div>
</template>
 
<script>
export default {
    mixins: [Fieldtype],

    data() {
        return {
            editing: false,
            saving: false,
            pending: this.value,
        };
    },

    computed: {
        input() {
            return this.$refs.input.$refs.input;
        },
    },

    methods: {
        edit() {
            this.editing = true;

            this.input.focus();
        },

        stopEditing() {
            this.editing = false;
        },

        confirm() {
            this.stopEditing();

            this.saving = true;

            setTimeout(() => {
                this.update(this.pending);

                this.saving = false;

                this.$toast.success(__("Pageviews updated"));
            }, 1000);
            // this.$axios
            //     .post(cp_url(`popular/pageviews/${"entry_id"}`), {
            //         views: this.pending,
            //     })
            //     .then(() => {
            //         this.update(this.pending);

            //         this.$toast.success(__("Pageviews updated"));
            //     })
            //     .catch(() => {
            //         this.pending = this.value;

            //         this.$toast.error(__("Something went wrong"));
            //     })
            //     .finally(() => {
            //         this.saving = false;
            //     });
        },

        cancel() {
            this.stopEditing();

            this.pending = this.value;
        },

        updatePending(value) {
            this.pending = value;
        },
    },
};
</script>