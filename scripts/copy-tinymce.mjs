// Self-host TinyMCE: copy the npm package to public/tinymce so the editor loads its own skin, theme and plugins.
import { cpSync, existsSync, mkdirSync, rmSync } from 'node:fs';

const from = 'node_modules/tinymce';
const to = 'public/tinymce';

if (!existsSync(from)) {
    console.warn('tinymce not installed, skipping copy (run npm install)');
    process.exit(0);
}

rmSync(to, { recursive: true, force: true });
mkdirSync(to, { recursive: true });
['tinymce.min.js', 'icons', 'models', 'plugins', 'skins', 'themes', 'license.md'].forEach((name) => cpSync(`${from}/${name}`, `${to}/${name}`, { recursive: true }));
console.log('tinymce copied to public/tinymce');
