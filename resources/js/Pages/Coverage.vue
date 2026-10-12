<script setup>
import Icon from '@/Components/Icon.vue';
import PageHero from '@/Components/Public/PageHero.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    districts: Array,
    areas: Array,
});

const page = usePage();
const result = computed(() => page.props.flash?.coverageResult);

const form = useForm({
    district: '',
    upazilla: '',
});

const upazillasFor = (district) => props.areas.filter((a) => a.district === district).map((a) => a.upazilla);

const submit = () => {
    form.post(route('coverage.check'), { preserveScroll: true });
};
</script>

<template>
    <Head title="Check coverage" />

    <PublicLayout>
        <PageHero eyebrow="Coverage" title="Check coverage" subtitle="Find out if EasyLink fiber is available in your area." />

        <section class="py-20">
            <div class="container-x max-w-xl">
                <form class="card space-y-5 p-8 shadow-xl shadow-slate-900/5" @submit.prevent="submit">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700">District</label>
                        <select v-model="form.district" class="field" required @change="form.upazilla = ''">
                            <option value="" disabled>Select a district</option>
                            <option v-for="d in districts" :key="d" :value="d">{{ d }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700">Thana / Upazila</label>
                        <select v-model="form.upazilla" class="field" required :disabled="!form.district">
                            <option value="" disabled>Select a thana / upazila</option>
                            <option v-for="u in upazillasFor(form.district)" :key="u" :value="u">{{ u }}</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-primary w-full" :disabled="form.processing">Check availability</button>
                </form>

                <div v-if="result" class="mt-6 rounded-3xl p-6" :class="result.available ? 'bg-emerald-50 text-emerald-800' : 'bg-rose-50 text-rose-800'">
                    <div class="flex items-start gap-3 font-semibold">
                        <Icon :name="result.available ? 'check' : 'sparkles'" class="mt-0.5 h-6 w-6 shrink-0" />
                        <span v-if="result.available">Good news! EasyLink is available in {{ result.upazilla }}, {{ result.district }}.</span>
                        <span v-else>Sorry, we haven't reached {{ result.upazilla }}, {{ result.district }} yet.</span>
                    </div>
                    <Link v-if="result.available" :href="route('packages.index')" class="btn-primary mt-5">View packages</Link>
                    <Link v-else :href="route('contact.index')" class="btn-secondary mt-5">Contact us</Link>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
