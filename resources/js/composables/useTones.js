// Two brand tones (signal red and deep navy) alternate so repeated tiles (stats, reasons, ...) stay on-brand.
// Class names are written out in full so Tailwind can see them.
const red = { tile: 'bg-accent-500 text-white shadow-accent-500/30', soft: 'bg-accent-100 text-accent-600', bar: 'from-accent-400 to-accent-600', dark: 'bg-accent-400/20 text-accent-300 ring-accent-300/30', wash: 'from-accent-100/40 to-white', top: 'from-accent-400 to-accent-600', glow: 'bg-accent-300/30', hover: 'hover:border-accent-300 hover:shadow-accent-500/15', text: 'text-accent-600', avatar: 'from-accent-500 to-accent-600' };
const navy = { tile: 'bg-brand-800 text-white shadow-brand-800/30', soft: 'bg-brand-100 text-brand-700', bar: 'from-brand-500 to-brand-800', dark: 'bg-brand-400/20 text-brand-200 ring-brand-300/30', wash: 'from-brand-50 to-white', top: 'from-brand-500 to-brand-800', glow: 'bg-brand-300/30', hover: 'hover:border-brand-300 hover:shadow-brand-700/15', text: 'text-brand-700', avatar: 'from-brand-600 to-brand-800' };
const tones = [red, navy, red, navy, red, navy];

export const tone = (i) => tones[Math.abs(Number(i) || 0) % tones.length];
