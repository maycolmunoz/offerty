<script setup lang="ts">
import { useMap } from '@/composables/useMap';
import { router } from '@inertiajs/vue3';
import { onMounted } from 'vue';

interface Promotion {
    title: string;
}

interface Business {
    latitude: number;
    longitude: number;
    promotion: Promotion;
}

const props = defineProps<{
    businesses: Business[];
}>();

const lat = 40.758;
const lon = -73.9855;

const { initMap, addDraggableMarker, addMarkersWithPromotions } = useMap();

onMounted(() => {
    initMap(lat, lon, 'map');

    addDraggableMarker(lat, lon, ({ lat, lng }) => {
        router.reload({
            only: ['businesses'],
            data: { lat, lon: lng },
            onSuccess: () => addMarkersWithPromotions(props.businesses),
        });
    });

    addMarkersWithPromotions(props.businesses);
});
</script>

<template>
    <section class="m-auto flex flex-col items-center p-6 text-[#1b1b18] lg:justify-center lg:p-8">
        <div class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
            <main class="flex w-full max-w-[400px] flex-col overflow-hidden rounded-lg lg:max-w-4xl lg:flex-row">
                <div
                    id="map"
                    class="relative aspect-[335/376] w-full shrink-0 overflow-hidden rounded-t-lg bg-gray-900 lg:mb-0 lg:-ml-px lg:w-[438px] lg:rounded-t-none lg:rounded-r-lg"
                ></div>

                <div
                    class="flex-1 rounded-br-lg rounded-bl-lg bg-white p-4 lg:rounded-tl-lg lg:rounded-br-none dark:bg-[#161615] dark:text-[#EDEDEC]"
                >
                    <div class="mb-6">
                        <img
                            src="https://images.unsplash.com/photo-1529070538774-1843cb3265df?auto=format&fit=crop&w=800&q=80"
                            alt="Promotion image"
                            class="w-full rounded-lg shadow-md"
                        />
                    </div>

                    <h1 class="mb-2 text-xl font-semibold">Buy One Get One Free – Specialty Coffee</h1>

                    <div class="mb-4 flex flex-wrap gap-2">
                        <span class="rounded-full bg-[#e0e0e0] px-3 py-1 text-xs font-medium text-[#1b1b18] dark:bg-[#2c2c2a] dark:text-[#f0f0ee]">
                            Weekend
                        </span>
                        <span class="rounded-full bg-[#e0e0e0] px-3 py-1 text-xs font-medium text-[#1b1b18] dark:bg-[#2c2c2a] dark:text-[#f0f0ee]">
                            In-Store Only
                        </span>
                        <span class="rounded-full bg-[#e0e0e0] px-3 py-1 text-xs font-medium text-[#1b1b18] dark:bg-[#2c2c2a] dark:text-[#f0f0ee]">
                            Limited Time
                        </span>
                    </div>

                    <p class="mb-6 text-[#706f6c] dark:text-[#A1A09A]">
                        Enjoy a unique experience with our exclusive weekend offer: buy one specialty coffee and get the second one free. Available at
                        all locations until the end of the month.
                    </p>

                    <div class="flex gap-3 text-sm">
                        <a
                            href="#"
                            class="inline-block rounded-sm border border-black bg-[#1b1b18] px-5 py-1.5 text-white hover:border-black hover:bg-black dark:border-[#eeeeec] dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:hover:border-white dark:hover:bg-white"
                        >
                            View Promotion
                        </a>
                    </div>
                </div>
            </main>
        </div>
    </section>
</template>
