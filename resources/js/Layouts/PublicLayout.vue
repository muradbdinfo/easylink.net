<script setup>
import FlashToast from '@/Components/FlashToast.vue';
import BackToTop from '@/Components/Public/BackToTop.vue';
import SiteFooter from '@/Components/Public/SiteFooter.vue';
import SiteHeader from '@/Components/Public/SiteHeader.vue';
import { onBeforeUnmount, onMounted } from 'vue';

// Fade-up on scroll for every section of every page: the blocks inside each .container-x, or the cards inside
// a grid. Anything already marked with v-reveal is left alone; the hero banner is never hidden.
let observer;
onMounted(() => {
    if (!('IntersectionObserver' in window) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('reveal-in');
                observer.unobserve(entry.target);
            });
        },
        { threshold: 0.08, rootMargin: '0px 0px -40px 0px' },
    );

    const skip = (el) => el.classList.contains('reveal') || el.querySelector('.reveal') || el.matches('form, iframe, .marquee, script, style');
    const add = (el, index) => {
        if (skip(el)) return;
        el.classList.add('reveal');
        el.style.setProperty('--d', `${(index % 4) * 90}ms`);
        observer.observe(el);
    };

    document.querySelectorAll('main section:not(.page-hero)').forEach((section, i) => {
        if (i === 0 && section.querySelector('h1')) return; // home hero
        section.querySelectorAll(':scope > .container-x > *').forEach((block, bi) => {
            if (block.matches('[class*="grid-cols"]')) {
                [...block.children].forEach((child, ci) => add(child, ci));
            } else {
                add(block, bi);
            }
        });
    });
});
onBeforeUnmount(() => observer?.disconnect());
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
