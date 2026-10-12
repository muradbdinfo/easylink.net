<script setup>
import Icon from '@/Components/Icon.vue';
import PageHero from '@/Components/Public/PageHero.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';

const props = defineProps({
    packages: Array,
});

const page = usePage();
const settings = computed(() => page.props.settings ?? {});

const form = useForm({
    name: '',
    email: '',
    phone: '',
    subject: '',
    message: '',
    type: 'general',
    package_id: '',
});

onMounted(() => {
    const params = new URLSearchParams(window.location.search);
    if (params.get('package_id')) {
        form.package_id = params.get('package_id');
        form.type = params.get('type') || 'package';
        const pkg = props.packages.find((p) => String(p.id) === params.get('package_id'));
        if (pkg) {
            form.subject = `Inquiry about the ${pkg.name} package`;
        }
    }
});

const submit = () => {
    form.post(route('contact.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset('message', 'subject'),
    });
};
</script>

<template>
    <Head title="Contact" />

    <PublicLayout>
        <PageHero eyebrow="Contact" title="Let's talk" subtitle="New connection, a quote, or any question — send us a message and we'll reply quickly." />

        <section class="py-20">
            <div class="container-x grid grid-cols-1 gap-10 lg:grid-cols-3">
                <div class="space-y-5 lg:col-span-1">
                    <div class="card flex items-start gap-4 p-6">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-brand-50 text-brand-600"><Icon name="phone" class="h-5 w-5" /></span>
                        <div>
                            <p class="font-semibold text-brand-900">Hotline</p>
                            <p class="mt-1 text-sm text-slate-500">{{ settings.hotline }} / {{ settings.phone }}</p>
                        </div>
                    </div>
                    <div class="card flex items-start gap-4 p-6">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-brand-50 text-brand-600"><Icon name="envelope" class="h-5 w-5" /></span>
                        <div>
                            <p class="font-semibold text-brand-900">Email</p>
                            <p class="mt-1 text-sm text-slate-500">{{ settings.email }}</p>
                        </div>
                    </div>
                    <div class="card flex items-start gap-4 p-6">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-brand-50 text-brand-600"><Icon name="map-pin" class="h-5 w-5" /></span>
                        <div>
                            <p class="font-semibold text-brand-900">Address</p>
                            <p class="mt-1 text-sm text-slate-500">{{ settings.address }}</p>
                        </div>
                    </div>
                </div>

                <form class="card space-y-5 p-8 shadow-xl shadow-slate-900/5 lg:col-span-2" @submit.prevent="submit">
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">Name *</label>
                            <input v-model="form.name" type="text" required class="field" />
                            <p v-if="form.errors.name" class="mt-1 text-xs text-rose-600">{{ form.errors.name }}</p>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">Email *</label>
                            <input v-model="form.email" type="email" required class="field" />
                            <p v-if="form.errors.email" class="mt-1 text-xs text-rose-600">{{ form.errors.email }}</p>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">Phone</label>
                            <input v-model="form.phone" type="text" class="field" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">Subject</label>
                            <input v-model="form.subject" type="text" class="field" />
                        </div>
                    </div>

                    <div v-if="form.package_id">
                        <label class="mb-1.5 block text-sm font-medium text-slate-700">Selected package</label>
                        <select v-model="form.package_id" class="field">
                            <option v-for="p in packages" :key="p.id" :value="p.id">{{ p.name }} ({{ p.type === 'home' ? 'Home' : 'Corporate' }})</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700">Message *</label>
                        <textarea v-model="form.message" rows="5" required class="field" />
                        <p v-if="form.errors.message" class="mt-1 text-xs text-rose-600">{{ form.errors.message }}</p>
                    </div>

                    <button type="submit" class="btn-primary" :disabled="form.processing">
                        {{ form.processing ? 'Sending...' : 'Send message' }}
                    </button>
                </form>
            </div>
        </section>
    </PublicLayout>
</template>
