<script setup>
import Icon from '@/Components/Icon.vue';
import { onMounted, onUnmounted, ref } from 'vue';

const visible = ref(false);

const onScroll = () => (visible.value = window.scrollY > 400);
const toTop = () => window.scrollTo({ top: 0, behavior: 'smooth' });

onMounted(() => {
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
});
onUnmounted(() => window.removeEventListener('scroll', onScroll));
</script>

<template>
    <Transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="translate-y-4 opacity-0"
        leave-active-class="transition duration-200 ease-in"
        leave-to-class="translate-y-4 opacity-0"
    >
        <button
            v-show="visible"
            type="button"
            aria-label="Back to top"
            title="Back to top"
            class="fixed bottom-[max(1.25rem,env(safe-area-inset-bottom))] right-[max(1rem,env(safe-area-inset-right))] z-40 flex h-12 w-12 items-center justify-center rounded-full bg-accent-500 text-white shadow-lg shadow-accent-500/30 ring-1 ring-white/30 transition hover:-translate-y-1 hover:bg-accent-600 focus:outline-none focus-visible:ring-4 focus-visible:ring-accent-300"
            @click="toTop"
        >
            <Icon name="arrow-up" class="h-6 w-6" />
        </button>
    </Transition>
</template>
