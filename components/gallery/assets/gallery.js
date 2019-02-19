// File for logic corresponding to header component
import { Component } from 'js-component-framework';
import Siema from 'siema';

/**
 * Component for galleries
 */
export default class Gallery extends Component {
  /**
   * Start the component
   */
  constructor(config) {
    super(config);

    this.gallery = new Siema({
      selector: this.children.lightboxGallery,
      draggable: false,
      onInit: this.addClickHandlers,
      onChange: this.checkGalleryPosition,
    });
  }

  checkGalleryPosition = () => {
    // reset button disabled states
    this.children.previousButton.disabled = false;
    this.children.nextButton.disabled = false;

    if (0 === this.gallery.currentSlide) {
      this.children.previousButton.disabled = true;
    } else if (
      (this.children.slides.length - 1) === this.gallery.currentSlide
    ) {
      this.children.nextButton.disabled = true;
    }
  };

  handleKeys = (e) => {
    if (! e.key) {
      return;
    }

    switch (e.key) {
      case 'Escape':
        this.close();
        break;

      case 'ArrowRight':
        this.gallery.next();
        break;

      case 'ArrowLeft':
        this.gallery.prev();
        break;

      default:
        break;
    }
  };

  addKeyboardHandler = () => {
    document.addEventListener('keydown', this.handleKeys);
  };

  removeKeyboardHandler = () => {
    document.removeEventListener('keydown', this.handleKeys);
  };

  addClickHandlers = () => {
    Array.prototype.forEach.call(this.children.slides, (slide) => {
      slide.addEventListener('click', (e) => {
        e.preventDefault();
        const idx = slide.dataset.index;
        this.open(idx);
      });
    });

    this.children.closeButton.addEventListener('click', this.close);
    this.children.nextButton.addEventListener('click', () => {
      this.gallery.next();
    });
    this.children.previousButton.addEventListener('click', () => {
      this.gallery.prev();
    });
  };

  open = (idx = 0) => {
    this.gallery.goTo(idx);

    // add classes
    this.children.lightboxWrapper
      .classList
      .add(this.options.styles.open);
    document.body
      .classList
      .add(this.options.visibleClass);

    // add keyboard event handler
    this.addKeyboardHandler();
  };

  close = () => {
    this.children.lightboxWrapper
      .classList
      .remove(this.options.styles.open);
    document.body
      .classList
      .remove(this.options.visibleClass);
  };
}
