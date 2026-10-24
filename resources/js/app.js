// Public site scripts. jQuery based vendor libraries (slick, mmenu, aos) are
// loaded from public/js/legacy in the layout and Alpine comes with Livewire.
import 'simplelightbox/dist/simple-lightbox.css';

// simplelightbox's bundle registers itself on `global`, which browsers lack.
window.global ||= window;

await import('simplelightbox');
const SimpleLightbox = window.SimpleLightbox;

const initGalleries = () => {
    document.querySelectorAll('[data-lightbox]').forEach((gallery) => {
        if (gallery.dataset.lightboxReady) {
            return;
        }

        gallery.dataset.lightboxReady = '1';
        new SimpleLightbox(`#${gallery.id} a`, { captionsData: 'title' });
    });
};

initGalleries();
document.addEventListener('livewire:init', () => {
    Livewire.hook('morphed', initGalleries);
});
