// File for logic corresponding to newsroom header component
import { Component } from 'js-component-framework';
import fastdom from 'fastdom';
import uiVars from 'config/css/ui';
import breakpoints from 'config/css/breakpoints';

/**
 * Component for site header
 */
export default class NewsroomHeader extends Component {
  /**
   * Start the component
   */
  constructor(config) {
    super(config);

    this.breakpoint = window.matchMedia(breakpoints.lgMax);

    this.addMenuListener();
    this.addSubmenuListeners();
    this.addSearchTriggerListener();
  }

  /**
   * Add listener for opening/closing newsroom main menu
   */
  addMenuListener() {
    this.children.menuTrigger
      .addEventListener('click', this.toggleMenu);
  }

  /**
   * Toggle newsroom main menu open/close state
   */
  toggleMenu = () => {
    this.element.classList.toggle(this.options.styles.open);
  };

  /**
   * Add click listeners for submenus
   */
  addSubmenuListeners() {
    Array.prototype.forEach.call(this.children.submenuTriggers, (trigger) => {
      trigger.addEventListener('click', (e) => {
        e.preventDefault();
        this.toggleSubmenu(trigger);
      });
    });
  }

  /**
   * Logic for toggling submenu open/close state
   */
  toggleSubmenu = (trigger) => {
    const openClass = this.options.styles.subMenuOpen;
    const menuItem = trigger.parentElement;

    if (menuItem.classList.contains(openClass)) {
      this.closeSubmenu(trigger);
    } else {
      this.openSubmenu(trigger);
    }
  };

  /**
   * Close all submenus
   */
  closeSubmenus = () => {
    Array.prototype.forEach.call(this.children.submenuTriggers, (trigger) => {
      this.closeSubmenu(trigger);
    });
  };

  /**
   * Close a submenu
   *
   * @param {HTMLElement} trigger submenu trigger link for which to close submenu
   */
  closeSubmenu = (trigger) => {
    const menuItem = trigger.parentElement;

    // Remove open calss
    menuItem.classList.remove(this.options.styles.subMenuOpen);

    // Reset parent menu item max-height to default
    if (this.breakpoint.matches) {
      fastdom.mutate(() => {
        menuItem.style.maxHeight = `${uiVars.newsroomHeaderMenuItemHeight}px`;
      });
    }
  };

  /**
   * Open a submenu
   *
   * @param {HTMLElement} trigger submenu trigger link for which to close submenu
   */
  openSubmenu = (trigger) => {
    const menuItem = trigger.parentElement;
    const submenu = menuItem.querySelector(this.options.submenuSelector);

    // Close all submenus
    this.closeSubmenus();

    // Add open class
    menuItem.classList.add(this.options.styles.subMenuOpen);

    // Set parent menu item max-height based on submenu height
    if (this.breakpoint.matches) {
      fastdom.measure(() => {
        const submenuHeight = submenu.getBoundingClientRect().height;
        const openHeight = uiVars.newsroomHeaderMenuItemHeight +
          submenuHeight;

        fastdom.mutate(() => {
          menuItem.style.maxHeight = `${openHeight}px`;
        });
      });
    }
  };

  /**
   * Add listener for opening/closing header search form if there is one.
   */
  addSearchTriggerListener() {
    if (this.children.searchTrigger) {
      this.children.searchTrigger.addEventListener('click', this.toggleSearch);
    }
  }

  /**
   * Toggle search form open/close state
   */
  toggleSearch = () => {
    const wrapper = this.element;
    const searchInput = wrapper.querySelector(this.options.searchInputSelector);

    if (wrapper.classList.contains(this.options.openSearchClass)) {
      wrapper.classList.remove(this.options.openSearchClass);
      searchInput.blur();
    } else {
      wrapper.classList.add(this.options.openSearchClass);
      searchInput.focus();
    }
  };
}
