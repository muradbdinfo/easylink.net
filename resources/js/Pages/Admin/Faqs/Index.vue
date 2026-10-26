<script setup>
import AdminCard from '@/Components/Admin/AdminCard.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import RichEditor from '@/Components/Admin/RichEditor.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    faqs: Array,
});

const showModal = ref(false);
const editing = ref(null);

const form = useForm({
    question: '',
    answer: '',
    order: 0,
    is_active: true,
});

const openCreate = () => {
    editing.value = null;
    form.reset();
    form.is_active = true;
    form.clearErrors();
    showModal.value = true;
};

const openEdit = (faq) => {
    editing.value = faq;
    form.question = faq.question;
    form.answer = faq.answer;
    form.order = faq.order;
    form.is_active = faq.is_active;
    form.clearErrors();
    showModal.value = true;
};

const submit = () => {
    const url = editing.value ? route('admin.faqs.update', editing.value.id) : route('admin.faqs.store');
    const method = editing.value ? 'put' : 'post';
    form[method](url, { onSuccess: () => (showModal.value = false) });
};

const destroy = (faq) => {
    if (confirm('Delete this FAQ?')) {
        router.delete(route('admin.faqs.destroy', faq.id), { preserveScroll: true });
    }
};
</script>

<template>
    <Head title="FAQ Management" />

    <AdminLayout title="FAQ Management">
        <AdminCard title="All FAQs">
            <template #tools>
                <PrimaryButton @click="openCreate">+ New FAQ</PrimaryButton>
            </template>
            <div class="divide-y divide-slate-100">
                <div v-for="faq in faqs" :key="faq.id" class="p-4">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="font-semibold text-slate-700">{{ faq.question }}</p>
                            <p class="mt-1 text-sm text-slate-500">{{ faq.answer }}</p>
                        </div>
                        <div class="flex shrink-0 gap-3 text-sm">
                            <button class="px-2 py-2 text-brand-600 hover:underline" @click="openEdit(faq)">Edit</button>
                            <button class="px-2 py-2 text-rose-600 hover:underline" @click="destroy(faq)">Delete</button>
                        </div>
                    </div>
                </div>
                <p v-if="!faqs.length" class="p-8 text-center text-slate-400">No FAQs yet.</p>
            </div>
        </AdminCard>

        <Modal :show="showModal" @close="showModal = false">
            <form class="p-6" @submit.prevent="submit">
                <h2 class="text-lg font-semibold text-slate-800">{{ editing ? 'Edit FAQ' : 'New FAQ' }}</h2>

                <div class="mt-4 space-y-4">
                    <div>
                        <InputLabel value="Question *" />
                        <TextInput v-model="form.question" class="mt-1 w-full" required />
                        <InputError :message="form.errors.question" class="mt-1" />
                    </div>
                    <div>
                        <InputLabel value="Answer *" />
                        <RichEditor v-model="form.answer" :height="220" />
                        <InputError :message="form.errors.answer" class="mt-1" />
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
