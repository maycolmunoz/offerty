<script setup lang="ts">
import { useMap } from '@/composables/useMap';
import { BusinessPromotion } from '@/types';
import { router } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const props = defineProps<{
    businesses: BusinessPromotion[];
}>();

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
            onSuccess: () => addMarkersWithPromotions(props.businesses),
        });
    });
});
</script>

<template>
    <section class="m-auto flex flex-col items-center p-6 text-[#1b1b18] lg:justify-center">
        <div class="z-0 h-[60vh] w-[80vw] rounded-2xl p-6 text-gray-900 md:w-[50vw]" id="map"></div>
    </section>
</template>
