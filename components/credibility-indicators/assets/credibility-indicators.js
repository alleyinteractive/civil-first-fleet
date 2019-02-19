// File for logic corresponding to newsroom header component
import { Component } from 'js-component-framework';
import fastdom from 'fastdom';
import uiVars from 'config/css/ui';

/**
 * Component for site header
 */
export default class CredibilityIndicators extends Component {
  /**
   * Start the component
   */
  constructor(config) {
    super(config);

    this.openClass = this.options.styles.open;

    this.addToggleListeners();
  }

  addToggleListeners() {
    Array.prototype.forEach.call(
      this.children.indicators,
      (indicator) => {
        const toggle = indicator.querySelector(this.options.toggleClass);
        toggle.addEventListener('click', () => {
          this.toggle(indicator);
        });
      }
    );
  }

  toggle = (indicator) => {
    const shouldClose = indicator.classList
      .contains(this.openClass);

    if (shouldClose) {
      this.closeText(indicator);
    } else {
      this.openText(indicator);
    }
  };

  closeAll = () => {
    Array.prototype.forEach.call(
      this.children.indicators,
      (indicator) => this.closeText(indicator)
    );
  };

  /* eslint-disable no-param-reassign */
  closeText = (indicator) => {
    fastdom.mutate(() => {
      indicator.classList.remove(this.openClass);
      indicator.style.maxHeight = `${uiVars.indicatorHeight}px`;
    });
  };

  openText = (indicator) => {
    this.closeAll();

    fastdom.measure(() => {
      const text = indicator.querySelector(this.options.textClass);
      const textHeight = text.getBoundingClientRect().height;

      fastdom.mutate(() => {
        indicator.classList.add(this.openClass);
        indicator.style.maxHeight =
          `${uiVars.indicatorHeight + textHeight}px`;
      });
    });
  };
  /* eslint-enable */
}
