<script setup>
import AdminCard from '@/Components/Admin/AdminCard.vue';
import Checkbox from '@/Components/Checkbox.vue';
import Icon from '@/Components/Icon.vue';
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
    stats: Array,
});

const iconOptions = ['calendar', 'users', 'map', 'headset', 'bolt', 'shield-check', 'star', 'globe'];

const showModal = ref(false);
const editing = ref(null);

const form = useForm({
    label: '',
    value: '',
    suffix: '',
    icon: 'sparkles',
    order: 0,
    is_active: true,
});

const openCreate = () => {
    editing.value = null;
    form.reset();
    form.icon = 'sparkles';
    form.is_active = true;
    form.clearErrors();
    showModal.value = true;
};

const openEdit = (stat) => {
    editing.value = stat;
    form.label = stat.label;
    form.value = stat.value;
    form.suffix = stat.suffix;
    form.icon = stat.icon;
    form.order = stat.order;
    form.is_active = stat.is_active;
    form.clearErrors();
    showModal.value = true;
};

const submit = () => {
    const url = editing.value ? route('admin.stats.update', editing.value.id) : route('admin.stats.store');
    const method = editing.value ? 'put' : 'post';
    form[method](url, { onSuccess: () => (showModal.value = false) });
};

const destroy = (stat) => {
    if (confirm(`"${stat.label}" Delete this item?`)) {
        router.delete(route('admin.stats.destroy', stat.id), { preserveScroll: true });
    }
};
</script>

<template>
    <Head title="Stats Counter Management" />

    <AdminLayout title="Stats Counter Management">
        <AdminCard title="All stats">
            <template #tools>
                <PrimaryButton @click="openCreate">+ New stat</PrimaryButton>
            </template>
            <div class="grid grid-cols-1 gap-4 p-4 sm:grid-cols-2 lg:grid-cols-4">
                <div v-for="stat in stats" :key="stat.id" class="rounded-md border border-slate-200 p-5 text-center">
                    <Icon :name="stat.icon" class="mx-auto h-7 w-7 text-accent-500" />
                    <p class="mt-2 text-2xl font-bold text-brand-900">{{ stat.value }}{{ stat.suffix }}</p>
                    <p class="text-sm text-slate-500">{{ stat.label }}</p>
                    <div class="mt-3 flex justify-center gap-3 text-sm">
                        <button class="px-2 py-2 text-brand-600 hover:underline" @click="openEdit(stat)">Edit</button>
                        <button class="px-2 py-2 text-rose-600 hover:underline" @click="destroy(stat)">Delete</button>
                    </div>
                </div>
                <p v-if="!stats.length" class="col-span-full p-8 text-center text-slate-400">No stats yet.</p>
            </div>
        </AdminCard>

        <Modal :show="showModal" @close="showModal = false">
            <form class="p-6" @submit.prevent="submit">
                <h2 class="text-lg font-semibold text-slate-800">{{ editing ? 'Edit Stat' : 'New stat' }}</h2>

                <div class="mt-4 space-y-4">
                    <div>
                        <InputLabel value="Label *" />
                        <TextInput v-model="form.label" class="mt-1 w-full" required />
                        <InputError :message="form.errors.label" class="mt-1" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel value="Value *" />
                            <TextInput v-model="form.value" class="mt-1 w-full" required />
                        </div>
                        <div>
                            <InputLabel value="Suffix" />
                            <TextInput v-model="form.suffix" class="mt-1 w-full" placeholder="+, K+, %" />
                        </div>
                    </div>
                    <div>
                        <InputLabel value="Icon" />
                        <select v-model="form.icon" class="mt-1 w-full rounded-md border-slate-300 text-sm">
                            <option v-for="icon in iconOptions" :key="icon" :value="icon">{{ icon }}</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel value="Order" />
                            <TextInput v-model="form.order" type="number" class="mt-1 w-full" />
                        </div>
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
