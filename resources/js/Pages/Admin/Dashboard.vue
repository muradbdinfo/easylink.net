<script setup>
import AreaChart from '@/Components/Admin/Dashboard/AreaChart.vue';
import DonutCard from '@/Components/Admin/Dashboard/DonutCard.vue';
import HealthCard from '@/Components/Admin/Dashboard/HealthCard.vue';
import LatestPosts from '@/Components/Admin/Dashboard/LatestPosts.vue';
import QuickActions from '@/Components/Admin/Dashboard/QuickActions.vue';
import RecentMessages from '@/Components/Admin/Dashboard/RecentMessages.vue';
import WelcomeBanner from '@/Components/Admin/Dashboard/WelcomeBanner.vue';
import { safeRoute } from '@/Components/Admin/Dashboard/helpers';
import SmallBox from '@/Components/Admin/SmallBox.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';

// Every prop has a default so the page still renders if the controller omits a key.
const props = defineProps({
    counts: { type: Object, default: () => ({}) },
    trend: { type: Array, default: () => [] },
    byType: { type: Array, default: () => [] },
    packagesByType: { type: Object, default: () => ({}) },
    recentMessages: { type: Array, default: () => [] },
    latestPosts: { type: Array, default: () => [] },
    contentHealth: { type: Array, default: () => [] },
    siteUrl: { type: String, default: '' },
});

const n = (key) => Number(props.counts?.[key] ?? 0);

const tiles = computed(() => [
    {
        key: 'packages',
        label: 'Packages',
        icon: 'cube',
        color: 'info',
        route: 'admin.packages.index',
        hint: props.packagesByType?.home !== undefined ? `${props.packagesByType.home ?? 0} home · ${props.packagesByType.corporate ?? 0} corporate` : 'Plans & pricing',
    },
    { key: 'services', label: 'Services', icon: 'wrench', color: 'success', route: 'admin.services.index', hint: 'What you offer' },
    { key: 'blogPosts', label: 'Blog posts', icon: 'newspaper', color: 'warning', route: 'admin.blog-posts.index', hint: 'Articles & news' },
    {
        key: 'unreadMessages',
        label: 'Unread messages',
        icon: 'envelope',
        color: 'danger',
        route: 'admin.contact-messages.index',
        hint: `${n('todayMessages')} today · ${n('weekMessages')} this week`,
    },
    { key: 'testimonials', label: 'Testimonials', icon: 'chat-bubble-left-right', color: 'violet', route: 'admin.testimonials.index', hint: 'Customer reviews' },
    { key: 'partners', label: 'Clients & partners', icon: 'user-group', color: 'cyan', route: 'admin.partners.index', hint: 'Logos on the site' },
    { key: 'sliders', label: 'Homepage sliders', icon: 'photo', color: 'indigo', route: 'admin.sliders.index', hint: 'Banner slides' },
    { key: 'quoteRequests', label: 'Quote requests', icon: 'banknotes', color: 'slate', route: 'admin.contact-messages.index', hint: `${n('messages')} messages in total` },
]);
</script>

<template>
    <Head title="Dashboard" />

    <AdminLayout title="Dashboard">
        <div class="space-y-6">
            <WelcomeBanner :unread="n('unreadMessages')" :today="n('todayMessages')" :week="n('weekMessages')" :site-url="siteUrl" />

            <section aria-label="Key numbers" class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <SmallBox v-for="t in tiles" :key="t.key" :value="n(t.key)" :label="t.label" :icon="t.icon" :color="t.color" :hint="t.hint" :href="safeRoute(t.route)" />
            </section>

            <QuickActions />

            <section class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <div class="min-w-0 lg:col-span-2"><AreaChart :trend="trend" /></div>
                <div class="min-w-0"><DonutCard :by-type="byType" :packages-by-type="packagesByType" /></div>
            </section>

            <section class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <div class="min-w-0 lg:col-span-2"><RecentMessages :messages="recentMessages" /></div>
                <div class="min-w-0"><HealthCard :items="contentHealth" /></div>
            </section>

            <LatestPosts :posts="latestPosts" />
        </div>
    </AdminLayout>
</template>
