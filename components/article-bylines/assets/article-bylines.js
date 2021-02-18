/* eslint-disable no-param-reassign */
import { Component } from 'js-component-framework';
import { Aria } from 'js-component-framework/lib/plugins';
import fastdom from 'fastdom';
import { debounce } from 'lodash';

import breakpoints from 'config/css/breakpoints';

// Extend Aria class so we can use it's methods.
class AriaManager extends Aria {
  constructor(target) {
    super();

    this.targetElement = target;
  }
}

export default class ArticleBylines extends Component {
  /**
   * Get the element's height.
   *
   * @param {HTMLElement} element The element of which we're checking the height.
   *
   * @returns {Number|Boolean} The element height.
   */
  static getHeight(element) {
    return (null !== element) ? element.offsetHeight : false;
  }

  /**
   * Get the controlling element based on the target element.
   *
   * @param {HTMLElement} element The parent element on which to query.
   * @param {String} targetId The ID attribute of the bio's target element.
   *
   * @returns HTMLElement The associated controlling element.
   */
  static getController(element, targetId) {
    return element.querySelector(`[href="#${targetId}"]`);
  }

  static rovingTabIndex({ target, isExpanded }) {
    const ariaManager = new AriaManager(target);
    ariaManager.collectInteractiveChildren();

    Array.prototype.forEach.call(
      ariaManager.interactiveChildElements,
      (child) => {
        if (isExpanded) {
          child.removeAttribute('tabindex');
        } else {
          child.setAttribute('tabindex', '-1');
        }
      }
    );
  }

  constructor(config) {
    super(config);

    this.wrappers = Array.prototype.slice.call(this.children.wrappers);
    this.i8nExpand = window.civilCMS.commonData.bioExpand;
    this.mdMin = window.matchMedia(breakpoints.mdMin);

    // header, content, name, contentInner
    Object.assign(this, this.options.selectors);

    this.manageBioHeights = this.manageBioHeights.bind(this);
    this.headerSetup = this.headerSetup.bind(this);
    this.tearDownBioExpanders = this.tearDownBioExpanders.bind(this);
    this.handleBioClick = this.handleBioClick.bind(this);

    this.headerSetup();
    this.mdMin.addListener(this.headerSetup);
  }

  /**
   * Get bio heights on browser resize.
   * Gets the height of the inner wrapper, since the outter wrapper could be set to 0.
   */
  manageBioHeights() {
    this.bios.forEach((bio) => {
      const contentInner = bio.target.querySelector(this.contentInner);

      fastdom.measure(() => {
        bio.height = this.constructor.getHeight(contentInner);
      });

      if (bio.isExpanded) {
        fastdom.mutate(() => {
          bio.target.style.height = `${bio.height}px`;
        });
      }
    });
  }

  /**
   * Test for a breakpoint match and multiple bylines; initialize bio expanders.
   */
  headerSetup() {
    this.bios = this.wrappers.reduce((acc, wrapper, index) => {
      const target = wrapper.querySelector(this.content);
      const header = wrapper.querySelector(this.header);
      const name = wrapper.querySelector(this.name).innerText;
      const controller = this.constructor.getController(header, target.id);

      // Hotfix to accommodate disabling of expansion logic.
      if (null === controller) {
        return acc;
      }

      const bio = {
        index,
        wrapper,
        target,
        controller,
        id: target.id,
        label: `${this.i8nExpand} ${name}'s bio`,
        isExpanded: (0 === index),
      };

      return acc.concat(bio);
    }, []);

    if (this.mdMin.matches && 1 < this.wrappers.length) {
      this.manageBioHeights();
      window.addEventListener('resize', debounce(this.manageBioHeights, 250));

      this.initBioExpanders();
    } else {
      this.tearDownBioExpanders();
    }
  }

  /**
   * Initialize the attributes and event listeners for the bio expanders.
   */
  initBioExpanders() {
    this.bios.forEach((bio, index) => {
      const {
        target, controller, id, height, label,
      } = bio;

      if (false !== height) {
        // Load the first one open.
        target.style.height = (0 === index) ? `${height}px` : 0;

        controller.setAttribute('aria-expanded', `${(0 === index)}`);
        controller.setAttribute('aria-controls', id);
        controller.removeAttribute('role');

        target.setAttribute('aria-hidden', `${(0 !== index)}`);

        controller.setAttribute('aria-label', `${label}`);

        this.constructor.rovingTabIndex(bio);

        controller.addEventListener('click', this.handleBioClick);
      }
    });
  }

  /**
   * Reset attributes and event listeners to dismantle bio expanders.
   */
  tearDownBioExpanders() {
    this.bios.forEach((bio, index) => {
      const {
        target, controller, height,
      } = bio;

      if (false !== height) {
        // Load the first one open.
        target.style.height = (0 === index) ? `${height}px` : 0;

        controller.removeAttribute('aria-expanded');
        controller.removeAttribute('aria-controls');
        controller.setAttribute('role', 'presentation');

        target.removeAttribute('aria-hidden');

        controller.removeAttribute('aria-label');

        this.constructor.rovingTabIndex(bio);

        controller.removeEventListener('click', this.handleBioClick);
        controller.addEventListener('click', (event) => {
          event.preventDefault();
        });
      }
    });
  }

  /**
   * Handle clicks on bio toggles.
   * Expand the target bio; collapse others.
   *
   * @param {Object} event The event object.
   */
  handleBioClick(event) {
    event.preventDefault();

    fastdom.mutate(() => {
      this.bios.forEach((bio) => {
        const {
          target, controller, height, wrapper,
        } = bio;

        if (wrapper.contains(event.target)) {
          target.style.height = `${height}px`;
          target.setAttribute('aria-hidden', 'false');
          controller.setAttribute('aria-expanded', 'true');
          bio.isExpanded = true;
          this.constructor.rovingTabIndex(bio);
        } else {
          target.style.height = '0';
          target.setAttribute('aria-hidden', 'true');
          controller.setAttribute('aria-expanded', 'false');
          bio.isExpanded = false;
          this.constructor.rovingTabIndex(bio);
        }
      });
    });
  }
}
