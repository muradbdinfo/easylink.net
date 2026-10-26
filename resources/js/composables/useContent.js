import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

/**
 * Admin-editable page content (see App\Support\SiteContent and config/site_content/*.php).
 *   const { c, list } = useContent();
 *   c('home.hero.badge')              -> string (image fields resolve to a URL)
 *   list('home.entertainment.items')  -> array of items
 */
export function useContent() {
    const page = usePage();
    const content = computed(() => page.props.content ?? {});

    const c = (key, fallback = '') => content.value[key] ?? fallback;
    const list = (key) => content.value[key] ?? [];

    // Rich text from the editor is HTML; older plain text (with line breaks) is escaped and kept readable.
    const richHtml = (text) => {
        const t = text ?? '';
        if (/<[a-z][\s\S]*>/i.test(t)) return t;
        return t.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/\n/g, '<br>');
    };

    return { content, c, list, richHtml };
}
