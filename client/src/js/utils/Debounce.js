const raf = window.requestAnimationFrame
  || window.webkitRequestAnimationFrame
  || window.mozRequestAnimationFrame
  || window.msRequestAnimationFrame
  || function raf(cb) { return setTimeout(cb, 16); };

/**
 * Network component for handling debouncing of events
 */
export default class Debounce {

  /**
   * Constructor
   * @param {function} callback - function to debounce (don't forget to bind it!)
   * @param {string} event - event on which the throttle should be applied
   * @param {HTMLElement} element - element on which throttle should be applied
   * @param {int} frequency - maximum frequency at which callback should be executed
   * @param {bool} initial - whether or not to execute the callback on the leading edge of the event
   */
  constructor(
    callback,
    event,
    element,
    frequency = 250,
    initial = true
  ) {
    this.event = event;
    this.element = element;
    this.frequency = frequency;
    this.timer = false;
    this.initial = initial;

    // Bound events
    this.requestTick = this.requestTick.bind(this);
    this.update = this.update.bind(this);

    if (! this.callback) {
      window.error('Debounce error: you must specify a callback.');
    } else {
      this.addHandler();
    }
  }

  /**
   * Add event handler for debouncer
   */
  addHandler() {
    this.element.addEventListener(this.event, this.requestTick);
  }

  /**
   * Dispatches the event to the supplied callback
   * @private
   */
  update() {
    this.callback();
    this.timer = false;
  }

  /**
   * Ensures events don't get stacked
   * @private
   */
  requestTick() {
    // call update if initial
    if (! this.timer && this.initial) {
      this.update();
    }

    // Clear existing timeout
    if (this.timer) {
      window.clearTimeout(this.timer);
    }

    this.timer = window.setTimeout(() => {
      raf(() => {
        this.update();
      });
    }, this.frequency);
  }

  /**
   * Remove debouncer
   * @private
   */
  destroy() {
    this.element.removeEventListerer(this.event, this.requestTick);
  }
}
