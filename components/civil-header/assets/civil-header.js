// File for logic corresponding to header component
import { Component } from 'js-component-framework';

/**
 * Component for site header
 */
export default class CivilHeader extends Component {
  /**
   * Start the component
   */
  constructor(config) {
    super(config);
    this.addMenuListener();
  }

  addMenuListener() {
    this.children.menuExpand.addEventListener('click', this.toggle);
  }

  toggle = () => {
    this.element.classList.toggle(this.options.styles.open);
  }
}
