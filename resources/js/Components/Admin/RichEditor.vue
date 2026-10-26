<script setup>
import Editor from '@tinymce/tinymce-vue';

// TinyMCE is self-hosted: scripts/copy-tinymce.mjs copies it to /public/tinymce on `npm run build` / `npm run dev`.
const model = defineModel({ type: String, default: '' });

const props = defineProps({
    height: { type: Number, default: 360 },
});

const xsrf = () => decodeURIComponent(document.cookie.split('; ').find((c) => c.startsWith('XSRF-TOKEN='))?.split('=')[1] ?? '');

// Pictures dropped or pasted into the editor are uploaded to /admin/uploads/image.
const uploadImage = (blobInfo) =>
    new Promise((resolve, reject) => {
        const body = new FormData();
        body.append('file', blobInfo.blob(), blobInfo.filename());
        fetch(route('admin.uploads.image'), { method: 'POST', body, headers: { 'X-XSRF-TOKEN': xsrf(), Accept: 'application/json' }, credentials: 'same-origin' })
            .then((r) => (r.ok ? r.json() : Promise.reject(new Error('Upload failed'))))
            .then((json) => resolve(json.location))
            .catch((e) => reject(e.message));
    });

const init = {
    height: props.height,
    menubar: false,
    branding: false,
    promotion: false,
    content_style: 'body{font-family:Inter,system-ui,sans-serif;font-size:15px;line-height:1.6;padding:8px}img{max-width:100%;height:auto}',
    plugins: 'advlist autolink charmap code fullscreen image link lists media preview searchreplace table wordcount',
    toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image media table | removeformat code fullscreen',
    toolbar_mode: 'sliding',
    convert_urls: false,
    relative_urls: false,
    automatic_uploads: true,
    images_upload_handler: uploadImage,
    paste_data_images: true,
};
</script>

<template>
    <Editor v-model="model" license-key="gpl" tinymce-script-src="/tinymce/tinymce.min.js" :init="init" />
</template>
