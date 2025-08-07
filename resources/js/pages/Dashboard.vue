<script setup lang="ts">
import AppMap from '@/components/leaflet/AppMap.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BusinessPromotion, type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

defineProps<{
    businesses: BusinessPromotion[];
}>();
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <AppMap :businesses />
        </div>
    </AppLayout>
</template>
