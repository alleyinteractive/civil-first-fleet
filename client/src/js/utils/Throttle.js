const raf = window.requestAnimationFrame
  || window.webkitRequestAnimationFrame
  || window.mozRequestAnimationFrame
  || window.msRequestAnimationFrame
  || function raf(cb) { return setTimeout(cb, 16); };

/**
 * Network component for handling throttling of events via requestAnimationFrame
 */
export default class Throttle {

  /**
   * Contstructor
   * @param {function} callback - function to debounce (don't forget to bind it!)
   * @param {string} event - event on which the throttle should be applied
   * @param {HTMLElement} element - element on which throttle should be applied
   * @param {int} frequency - maximum frequency at which callback should be executed
   */
  constructor(callback, event, element, frequency = 250) {
    this.event = event;
    this.element = element;
    this.frequency = frequency;
    this.timeout = false;

    // Bound events
    this.requestTick = this.requestTick.bind(this);
    this.update = this.update.bind(this);

    if (! this.callback) {
      window.error('Throttle error: you must specify a callback.');
    } else {
      this.addHandler();
    }
  }

  addHandler() {
    this.element.addEventListener(this.event, this.requestTick);
  }

  /**
   * Dispatches the event to the supplied callback
   * @private
   */
  update() {
    this.callback();
    window.clearTimeout(this.timeout);
    this.timeout = false;
  }

  /**
   * Ensures events don't get stacked
   * @private
   */
  requestTick() {
    if (! this.timeout) {
      this.timeout = window.setTimeout(() => {
        raf(() => {
          this.update();
        });
      }, this.frequency);
    }
  }

  /**
   * Remove debouncer
   * @private
   */
  destroy() {
    this.element.removeEventListerer(this.event, this.requestTick);
  }
}
