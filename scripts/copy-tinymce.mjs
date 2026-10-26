// Self-host TinyMCE: copy the parts of the npm package we use to public/tinymce, so the editor
// loads its own skin, theme and plugins. Only minified files and the plugins listed in
// resources/js/Components/Admin/RichEditor.vue are copied (11 MB -> a few MB to deploy and sync).
import { cpSync, existsSync, mkdirSync, rmSync } from 'node:fs';
import { basename } from 'node:path';

const from = 'node_modules/tinymce';
const to = 'public/tinymce';

const plugins = ['advlist', 'autolink', 'charmap', 'code', 'fullscreen', 'image', 'link', 'lists', 'media', 'preview', 'searchreplace', 'table', 'wordcount'];

if (!existsSync(from)) {
    console.warn('tinymce not installed, skipping copy (run npm install)');
    process.exit(0);
}

// Keep minified js/css and static assets; drop sources, typings and non-minified duplicates.
const keep = (src) => {
    const name = basename(src);
    if (!name.includes('.')) return true; // directories
    if (/\.(ts|map|md)$/.test(name)) return false;
    if (/\.(js|css)$/.test(name)) return /\.min\.(js|css)$/.test(name);
    return true;
};

rmSync(to, { recursive: true, force: true });
mkdirSync(to, { recursive: true });

const copy = (name) => cpSync(`${from}/${name}`, `${to}/${name}`, { recursive: true, filter: keep });

['tinymce.min.js', 'icons/default', 'models/dom', 'themes/silver', 'skins/ui/oxide', 'skins/content/default', 'license.md'].forEach((name) => {
    mkdirSync(`${to}/${name.split('/').slice(0, -1).join('/')}`, { recursive: true });
    copy(name);
});
plugins.forEach((plugin) => copy(`plugins/${plugin}`));

console.log('tinymce copied to public/tinymce');
