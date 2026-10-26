<script setup>
import FlashToast from '@/Components/FlashToast.vue';
import BackToTop from '@/Components/Public/BackToTop.vue';
import SiteFooter from '@/Components/Public/SiteFooter.vue';
import SiteHeader from '@/Components/Public/SiteHeader.vue';
</script>

<template>
    <div class="flex min-h-screen flex-col bg-white">
        <SiteHeader />
        <main class="flex-1">
            <slot />
        </main>
        <SiteFooter />
        <FlashToast />
        <BackToTop />
    </div>
</template>
