<template>
    <div>
        <div v-if="initializing" class="loading">
            <loading-graphic />
        </div>

        <data-list
            v-if="!initializing && items.length"
            :rows="items"
            :columns="cols"
            :sort="false"
            :sort-column="sortColumn"
            :sort-direction="sortDirection"
        >
            <div slot-scope="{}">
                <data-list-table :loading="loading">
                    <template
                        slot="cell-title"
                        slot-scope="{ row: entry, displayIndex: index }"
                    >
                        <div class="flex justify-between items-center">
                            <div class="flex-1 flex">
                                <div
                                    class="
                                        mr-2
                                        px-1
                                        bg-grey-30
                                        text-grey-80
                                        rounded-full
                                    "
                                >
                                    {{ offset + index + 1 }}
                                </div>
                                <a :href="entry.edit_url">{{ entry.title }}</a>
                            </div>
                            <div
                                class="flex-0"
                                v-tooltip="`${entry.pageviews ?? 0} views`"
                            >
                                {{ shorten(entry.pageviews) }}
                                {{ __("views") }}
                            </div>
                        </div>
                    </template>
                </data-list-table>
                <data-list-pagination
                    v-if="meta.last_page != 1"
                    class="py-1 border-t bg-grey-20 rounded-b-lg text-sm"
                    :resource-meta="meta"
                    @page-selected="selectPage"
                    :scroll-to-top="false"
                />
            </div>
        </data-list>

        <p
            v-else-if="!initializing && !items.length"
            class="p-2 pt-1 text-sm text-grey-50"
        >
            {{ __("There are no entries in this collection") }}
        </p>
    </div>
</template>

<script>
import Listing from "../../../../vendor/statamic/cms/resources/js/components/Listing.vue";

export default {
    mixins: [Listing],

    props: {
        collection: String,
    },

    data() {
        return {
            cols: [{ label: "Title", field: "title", visible: true }],
            listingKey: "entries",
            requestUrl: cp_url(`collections/${this.collection}/entries`),
            offset: 0,
        };
    },

    watch: {
        loading(loading) {
            if (!loading) {
                this.offset = (this.page - 1) * this.perPage;
            }
        },
    },

    methods: {
        shorten(number) {
            if (!number) {
                return 0;
            }

             if (number < 1E3) {
                return number;
            }

            let suffix;
            for (suffix of ['K', 'M', 'B', 'T']) {
                number /= 1E3;
                if (number < 1E3) {
                    break;
                }
            }

            return `${Number(number.toFixed(number < 10 ? 1 : 0))}${suffix}`;
        },
    },
};
</script>
