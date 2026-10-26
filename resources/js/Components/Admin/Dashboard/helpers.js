import { onMounted, onUnmounted, ref, watch } from 'vue';

/** route() that never throws (unknown route names fall back to "#"). */
export const safeRoute = (name, fallback = '#') => {
    try {
        return route(name);
    } catch {
        return fallback;
    }
};

const reducedMotion = () => typeof window !== 'undefined' && window.matchMedia?.('(prefers-reduced-motion: reduce)').matches;

/** Animated number: counts up from the previous value to getter() (instant when motion is reduced). */
export function useCountUp(getter, duration = 900) {
    const display = ref(0);
    let raf = null;

    const run = (to) => {
        cancelAnimationFrame(raf);
        const from = display.value;
        const target = Number(to) || 0;

        if (reducedMotion() || from === target) {
            display.value = target;
            return;
        }

        const start = performance.now();
        const step = (now) => {
            const t = Math.min(1, (now - start) / duration);
            display.value = Math.round(from + (target - from) * (1 - Math.pow(1 - t, 3)));
            if (t < 1) raf = requestAnimationFrame(step);
        };
        raf = requestAnimationFrame(step);
    };

    onMounted(() => run(getter()));
    watch(getter, run);
    onUnmounted(() => cancelAnimationFrame(raf));

    return display;
}

export const initials = (name = '') =>
    (name || '?')
        .trim()
        .split(/\s+/)
        .map((w) => w[0])
        .slice(0, 2)
        .join('')
        .toUpperCase();

const avatarGradients = [
    'from-sky-500 to-blue-600',
    'from-violet-500 to-fuchsia-500',
    'from-emerald-500 to-teal-500',
    'from-amber-500 to-orange-500',
    'from-rose-500 to-pink-500',
    'from-indigo-500 to-sky-500',
];

export const avatarGradient = (seed = '') => {
    let h = 0;
    for (const ch of String(seed)) h = (h * 31 + ch.charCodeAt(0)) >>> 0;
    return avatarGradients[h % avatarGradients.length];
};

export const formatDate = (value) => {
    if (!value) return '';
    const d = new Date(value);
    return Number.isNaN(d.getTime()) ? '' : d.toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
};
