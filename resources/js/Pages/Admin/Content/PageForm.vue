<script setup>
import AdminCard from '@/Components/Admin/AdminCard.vue';
import Icon from '@/Components/Icon.vue';
import iconNames from '@/Components/iconNames.js';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import RichEditor from '@/Components/Admin/RichEditor.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { router, useForm } from '@inertiajs/vue3';

const props = defineProps({
    group: Object,
    values: Object,
});

const fields = props.group.sections.flatMap((s) => Object.entries(s.fields));

const initial = {};
fields.forEach(([key, field]) => {
    if (field.type !== 'image') {
        initial[key] = field.type === 'list' ? JSON.parse(JSON.stringify(props.values[key] ?? [])) : (props.values[key] ?? '');
    }
});

const form = useForm({ page: props.group.page, values: initial, files: {}, remove: {} });

// Laravel reads "." in input names as nesting, so send keys with "|" instead.
const encode = (obj) => Object.fromEntries(Object.entries(obj).map(([k, v]) => [k.replaceAll('.', '|'), v]));

const submit = () =>
    form
        .transform((data) => ({
            page: data.page,
            _method: 'put',
            values: encode(data.values),
            files: encode(data.files),
            remove: encode(data.remove),
        }))
        .post(route('admin.content.update'), {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                form.files = {};
                form.remove = {};
            },
        });

const resetPage = () => {
    if (confirm(`Reset all "${props.group.page}" content to the original defaults?`)) {
        router.delete(route('admin.content.reset'), { data: { page: props.group.page }, preserveScroll: true });
    }
};

// images
const previews = {};
const onFile = (key, e) => {
    const file = e.target.files[0] || null;
    form.files[key] = file;
    delete form.remove[key];
    previews[key] = file ? URL.createObjectURL(file) : null;
};
const removeImage = (key) => {
    delete form.files[key];
    form.remove[key] = true;
    previews[key] = null;
};
const imageSrc = (key) => (form.remove[key] ? null : (previews[key] ?? props.values[key]) || null);

// lists
const blankItem = (field) => Object.fromEntries(Object.keys(field.fields).map((k) => [k, '']));
const addItem = (key, field) => form.values[key].push(blankItem(field));
const removeItem = (key, i) => {
    if (confirm('Remove this item?')) form.values[key].splice(i, 1);
};
const moveItem = (key, i, dir) => {
    const list = form.values[key];
    const j = i + dir;
    if (j < 0 || j >= list.length) return;
    [list[i], list[j]] = [list[j], list[i]];
};
const itemTitle = (item, field) => item[Object.keys(field.fields)[0]] || 'New item';
</script>

<template>
    <form class="space-y-5" @submit.prevent="submit">
        <AdminCard v-for="section in group.sections" :key="section.title" :title="section.title">
            <div class="space-y-5 p-5">
                <div v-for="[key, field] in Object.entries(section.fields)" :key="key">
                    <InputLabel :value="field.label" />
                    <p v-if="field.help" class="mb-1 text-xs text-slate-400">{{ field.help }}</p>

                    <!-- text / url -->
                    <TextInput v-if="field.type === 'text' || field.type === 'url' || !field.type" v-model="form.values[key]" class="mt-1 w-full" />

                    <!-- textarea -->
                    <textarea v-else-if="field.type === 'textarea'" v-model="form.values[key]" rows="3" class="mt-1 w-full rounded-md border-slate-300 text-sm" />

                    <!-- rich text (TinyMCE) -->
                    <div v-else-if="field.type === 'richtext'" class="mt-1"><RichEditor v-model="form.values[key]" :height="field.height || 320" /></div>

                    <!-- icon -->
                    <div v-else-if="field.type === 'icon'" class="mt-1 flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-md bg-slate-100 text-slate-700"><Icon :name="form.values[key]" class="h-5 w-5" /></span>
                        <select v-model="form.values[key]" class="rounded-md border-slate-300 text-sm">
                            <option v-for="n in iconNames" :key="n" :value="n">{{ n }}</option>
                        </select>
                    </div>

                    <!-- image -->
                    <div v-else-if="field.type === 'image'" class="mt-1 flex flex-wrap items-center gap-4">
                        <div class="flex h-24 w-40 items-center justify-center overflow-hidden rounded-md border border-slate-200 bg-slate-50">
                            <img v-if="imageSrc(key)" :src="imageSrc(key)" alt="" class="h-full w-full object-cover" />
                            <span v-else class="text-xs text-slate-400">No picture</span>
                        </div>
                        <div>
                            <input type="file" accept="image/*" class="block text-sm" @change="onFile(key, $event)" />
                            <button v-if="imageSrc(key)" type="button" class="mt-1 text-xs text-rose-600 hover:underline" @click="removeImage(key)">Remove picture</button>
                            <InputError :message="form.errors[`files.${key}`]" class="mt-1" />
                        </div>
                    </div>

                    <!-- list of items -->
                    <div v-else-if="field.type === 'list'" class="mt-2 space-y-3">
                        <div v-for="(item, i) in form.values[key]" :key="i" class="rounded-md border border-slate-200 bg-slate-50/60">
                            <div class="flex items-center justify-between gap-2 border-b border-slate-200 px-3 py-2">
                                <span class="truncate text-sm font-semibold text-slate-700">{{ i + 1 }}. {{ itemTitle(item, field) }}</span>
                                <span class="flex shrink-0 items-center gap-1">
                                    <button type="button" class="rounded px-2 py-1.5 text-sm text-slate-500 hover:bg-slate-200 disabled:opacity-30" :disabled="i === 0" aria-label="Move up" @click="moveItem(key, i, -1)">↑</button>
                                    <button type="button" class="rounded px-2 py-1.5 text-sm text-slate-500 hover:bg-slate-200 disabled:opacity-30" :disabled="i === form.values[key].length - 1" aria-label="Move down" @click="moveItem(key, i, 1)">↓</button>
                                    <button type="button" class="rounded px-2 py-1.5 text-sm text-rose-600 hover:bg-rose-50" @click="removeItem(key, i)">Delete</button>
                                </span>
                            </div>
                            <div class="grid grid-cols-1 gap-3 p-3 sm:grid-cols-2">
                                <div v-for="[subKey, sub] in Object.entries(field.fields)" :key="subKey" :class="sub.type === 'textarea' ? 'sm:col-span-2' : ''">
                                    <InputLabel :value="sub.label" />
                                    <textarea v-if="sub.type === 'textarea'" v-model="item[subKey]" rows="2" class="mt-1 w-full rounded-md border-slate-300 text-sm" />
                                    <div v-else-if="sub.type === 'icon'" class="mt-1 flex items-center gap-2">
                                        <span class="flex h-9 w-9 items-center justify-center rounded-md bg-white text-slate-700 ring-1 ring-slate-200"><Icon :name="item[subKey]" class="h-5 w-5" /></span>
                                        <select v-model="item[subKey]" class="rounded-md border-slate-300 text-sm">
                                            <option v-for="n in iconNames" :key="n" :value="n">{{ n }}</option>
                                        </select>
                                    </div>
                                    <TextInput v-else v-model="item[subKey]" class="mt-1 w-full" />
                                </div>
                            </div>
                        </div>
                        <button type="button" class="text-sm font-medium text-accent-600 hover:underline" @click="addItem(key, field)">+ Add item</button>
                    </div>
                </div>
            </div>
        </AdminCard>

        <div class="sticky bottom-0 -mx-4 flex flex-wrap items-center justify-between gap-3 border-t border-slate-200 bg-white/95 px-4 py-3 backdrop-blur sm:-mx-6 sm:px-6">
            <SecondaryButton type="button" @click="resetPage">Reset to defaults</SecondaryButton>
            <PrimaryButton :disabled="form.processing">{{ form.processing ? 'Saving…' : 'Save changes' }}</PrimaryButton>
        </div>
    </form>
</template>
