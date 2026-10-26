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
    areas: Array,
});

const showModal = ref(false);
const editing = ref(null);

const form = useForm({
    district: '',
    upazilla: '',
    is_active: true,
});

const openCreate = () => {
    editing.value = null;
    form.reset();
    form.is_active = true;
    form.clearErrors();
    showModal.value = true;
};

const openEdit = (area) => {
    editing.value = area;
    form.district = area.district;
    form.upazilla = area.upazilla;
    form.is_active = area.is_active;
    form.clearErrors();
    showModal.value = true;
};

const submit = () => {
    const url = editing.value ? route('admin.coverage-areas.update', editing.value.id) : route('admin.coverage-areas.store');
    const method = editing.value ? 'put' : 'post';
    form[method](url, { onSuccess: () => (showModal.value = false) });
};

const destroy = (area) => {
    if (confirm(`"${area.district}, ${area.upazilla}" Delete this item?`)) {
        router.delete(route('admin.coverage-areas.destroy', area.id), { preserveScroll: true });
    }
};
</script>

<template>
    <Head title="Coverage Area Management" />

    <AdminLayout title="Coverage Area Management">
        <AdminCard title="All areas">
            <template #tools>
                <PrimaryButton @click="openCreate">+ New area</PrimaryButton>
            </template>
            <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase text-slate-500">
                    <tr>
                        <th class="px-4 py-3">District</th>
                        <th class="px-4 py-3">Thana / Upazila</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr v-for="area in areas" :key="area.id">
                        <td class="px-4 py-3 font-medium text-slate-700">{{ area.district }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ area.upazilla }}</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full px-2 py-1 text-xs font-semibold" :class="area.is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500'">
                                {{ area.is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 text-right">
                            <button class="mr-1 px-2 py-2 text-brand-600 hover:underline" @click="openEdit(area)">Edit</button>
                            <button class="px-2 py-2 text-rose-600 hover:underline" @click="destroy(area)">Delete</button>
                        </td>
                    </tr>
                    <tr v-if="!areas.length">
                        <td colspan="4" class="px-4 py-8 text-center text-slate-400">No areas yet.</td>
                    </tr>
                </tbody>
            </table>
            </div>
        </AdminCard>

        <Modal :show="showModal" @close="showModal = false">
            <form class="p-6" @submit.prevent="submit">
                <h2 class="text-lg font-semibold text-slate-800">{{ editing ? 'Edit Area' : 'New area' }}</h2>

                <div class="mt-4 space-y-4">
                    <div>
                        <InputLabel value="District *" />
                        <TextInput v-model="form.district" class="mt-1 w-full" required />
                        <InputError :message="form.errors.district" class="mt-1" />
                    </div>
                    <div>
                        <InputLabel value="Thana / Upazila *" />
                        <TextInput v-model="form.upazilla" class="mt-1 w-full" required />
                        <InputError :message="form.errors.upazilla" class="mt-1" />
                    </div>
                    <label class="flex items-center gap-2">
                        <Checkbox v-model:checked="form.is_active" />
                        <span class="text-sm text-slate-600">Active</span>
                    </label>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <SecondaryButton type="button" @click="showModal = false">Cancel</SecondaryButton>
                    <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                </div>
            </form>
        </Modal>
    </AdminLayout>
</template>
