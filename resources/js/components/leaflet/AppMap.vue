<script setup lang="ts">
import { useMap } from '@/composables/useMap';
import { BusinessPromotion } from '@/types';
import { router } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const props = defineProps<{
    businesses: BusinessPromotion[];
}>();

const old_businesses = ref<BusinessPromotion[]>(props.businesses);

const lat = 40.758;
const lon = -73.9855;

const { initMap, addDraggableMarker, addMarkersWithPromotions } = useMap();

onMounted(() => {
    initMap(lat, lon, 'map');

    addMarkersWithPromotions(props.businesses);

    addDraggableMarker(lat, lon, ({ lat, lng }) => {
        router.reload({
            only: ['businesses'],
            data: { lat, lon: lng },
            onSuccess: () => {
                const newBusinesses = props.businesses.filter((item) => !old_businesses.value.some((b) => b.id === item.id));

                old_businesses.value.push(...newBusinesses);

                addMarkersWithPromotions(newBusinesses);
            },
        });
    });
});
</script>

<template>
    <section class="m-auto flex flex-col items-center text-[#1b1b18] lg:justify-center">
        <div class="z-0 h-[80vh] w-[90vw] rounded-2xl text-gray-900 md:h-[80vh] md:w-[50vw]" id="map"></div>
    </section>
</template>
