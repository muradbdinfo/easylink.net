<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';

const page = usePage();
const message = ref(null);
const type = ref('success');

watch(
    () => [page.props.flash?.success, page.props.flash?.error],
    ([success, error]) => {
        if (success) {
            message.value = success;
            type.value = 'success';
        } else if (error) {
            message.value = error;
            type.value = 'error';
        } else {
            return;
        }

        setTimeout(() => (message.value = null), 4500);
    },
    { immediate: true },
);

const classes = computed(() =>
    type.value === 'success' ? 'bg-emerald-600' : 'bg-rose-600',
);
</script>

<template>
    <Transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="opacity-0 translate-y-2"
        leave-active-class="transition duration-200 ease-in"
        leave-to-class="opacity-0"
    >
        <div v-if="message" class="fixed bottom-5 right-5 z-[100] max-w-sm rounded-lg px-4 py-3 text-sm font-medium text-white shadow-lg" :class="classes">
            {{ message }}
        </div>
    </Transition>
</template>
