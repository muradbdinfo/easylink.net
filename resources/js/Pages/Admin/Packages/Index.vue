<script setup>
import AdminCard from '@/Components/Admin/AdminCard.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    packages: Array,
});

const showModal = ref(false);
const editing = ref(null);

const form = useForm({
    name: '',
    type: 'home',
    speed_mbps: 20,
    price: 0,
    price_note: '+ VAT / month',
    description: '',
    features: [''],
    is_popular: false,
    is_active: true,
    order: 0,
});

const openCreate = () => {
    editing.value = null;
    form.reset();
    form.features = [''];
    form.clearErrors();
    showModal.value = true;
};

const openEdit = (pkg) => {
    editing.value = pkg;
    form.name = pkg.name;
    form.type = pkg.type;
    form.speed_mbps = pkg.speed_mbps;
    form.price = pkg.price;
    form.price_note = pkg.price_note;
    form.description = pkg.description;
    form.features = pkg.features?.length ? [...pkg.features] : [''];
    form.is_popular = pkg.is_popular;
    form.is_active = pkg.is_active;
    form.order = pkg.order;
    form.clearErrors();
    showModal.value = true;
};

const addFeature = () => form.features.push('');
const removeFeature = (i) => form.features.splice(i, 1);

const submit = () => {
    const url = editing.value ? route('admin.packages.update', editing.value.id) : route('admin.packages.store');
    const method = editing.value ? 'put' : 'post';
    form[method](url, { onSuccess: () => (showModal.value = false) });
};

const destroy = (pkg) => {
    if (confirm(`"${pkg.name}" Delete this item?`)) {
        router.delete(route('admin.packages.destroy', pkg.id), { preserveScroll: true });
    }
};
</script>

<template>
    <Head title="Package Management" />

    <AdminLayout title="Package Management">
        <AdminCard title="All packages">
            <template #tools>
                <PrimaryButton @click="openCreate">+ New package</PrimaryButton>
            </template>
            <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">Speed</th>
                        <th class="px-4 py-3">Price</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr v-for="pkg in packages" :key="pkg.id">
                        <td class="px-4 py-3 font-medium text-slate-700">{{ pkg.name }} <span v-if="pkg.is_popular" class="ml-1 rounded-full bg-accent-100 px-2 py-0.5 text-xs text-accent-700">Popular</span></td>
                        <td class="px-4 py-3 capitalize text-slate-500">{{ pkg.type }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ pkg.speed_mbps }} Mbps</td>
                        <td class="px-4 py-3 text-slate-500">৳{{ pkg.price }}</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full px-2 py-1 text-xs font-semibold" :class="pkg.is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500'">
                                {{ pkg.is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button class="mr-3 text-brand-600 hover:underline" @click="openEdit(pkg)">Edit</button>
                            <button class="text-rose-600 hover:underline" @click="destroy(pkg)">Delete</button>
                        </td>
                    </tr>
                    <tr v-if="!packages.length">
                        <td colspan="6" class="px-4 py-8 text-center text-slate-400">No packages yet.</td>
                    </tr>
                </tbody>
            </table>
            </div>
        </AdminCard>

        <Modal :show="showModal" max-width="2xl" @close="showModal = false">
            <form class="max-h-[85vh] overflow-y-auto p-6" @submit.prevent="submit">
                <h2 class="text-lg font-semibold text-slate-800">{{ editing ? 'Edit Package' : 'New package' }}</h2>

                <div class="mt-4 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel value="Name *" />
                            <TextInput v-model="form.name" class="mt-1 w-full" required />
                            <InputError :message="form.errors.name" class="mt-1" />
                        </div>
                        <div>
                            <InputLabel value="Type *" />
                            <select v-model="form.type" class="mt-1 w-full rounded-md border-slate-300 text-sm">
                                <option value="home">Home</option>
                                <option value="corporate">Corporate</option>
                            </select>
                        </div>
                        <div>
                            <InputLabel value="Speed (Mbps) *" />
                            <TextInput v-model="form.speed_mbps" type="number" class="mt-1 w-full" required />
                        </div>
                        <div>
                            <InputLabel value="Price (৳) *" />
                            <TextInput v-model="form.price" type="number" class="mt-1 w-full" required />
                        </div>
                        <div class="col-span-2">
                            <InputLabel value="Price note" />
                            <TextInput v-model="form.price_note" class="mt-1 w-full" />
                        </div>
                    </div>

                    <div>
                        <InputLabel value="Description" />
                        <textarea v-model="form.description" rows="2" class="mt-1 w-full rounded-md border-slate-300 text-sm" />
                    </div>

                    <div>
                        <InputLabel value="Features" />
                        <div v-for="(feature, i) in form.features" :key="i" class="mt-2 flex gap-2">
                            <TextInput v-model="form.features[i]" class="w-full" placeholder="e.g. Unlimited data" />
                            <button type="button" class="text-rose-500" @click="removeFeature(i)">✕</button>
                        </div>
                        <button type="button" class="mt-2 text-sm font-medium text-brand-600" @click="addFeature">+ Add feature</button>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <InputLabel value="Order" />
                            <TextInput v-model="form.order" type="number" class="mt-1 w-full" />
                        </div>
                        <label class="mt-6 flex items-center gap-2">
                            <Checkbox v-model:checked="form.is_popular" />
                            <span class="text-sm text-slate-600">Popular</span>
                        </label>
                        <label class="mt-6 flex items-center gap-2">
                            <Checkbox v-model:checked="form.is_active" />
                            <span class="text-sm text-slate-600">Active</span>
                        </label>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <SecondaryButton type="button" @click="showModal = false">Cancel</SecondaryButton>
                    <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                </div>
            </form>
        </Modal>
    </AdminLayout>
</template>
