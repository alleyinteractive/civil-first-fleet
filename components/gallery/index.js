import convertToClass from 'utils/convertToClass';
import Gallery from './assets/gallery';
import './assets/gallery.css';

const componentName = 'gallery';
const styles = civilCMSClassnames[componentName];

const galleryConfig = {
  name: componentName,
  class: Gallery,
  querySelectorAll: {
    slides: '.lightbox-gallery__item',
  },
  querySelector: {
    lightboxWrapper: convertToClass(styles.lightboxWrapper),
    lightboxGallery: convertToClass(styles.lightboxGallery),
    nextButton: convertToClass(styles.next),
    previousButton: convertToClass(styles.previous),
    closeButton: convertToClass(styles.close),
  },
  options: {
    styles,
    visibleClass: 'lightbox-gallery--visible',
  },
};

export default galleryConfig;
