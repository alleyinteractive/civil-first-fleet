// File for logic corresponding to header component
import { Component } from 'js-component-framework';

/**
 * Component for the CivilFooter.
 */
export default class CivilFooter extends Component {
  /**
   * Start the component
   */
  constructor(config) {
    super(config);
    this.picoWidget = document.getElementById(this.options.picoID);

    this.addPicoClass();
  }

  addPicoClass() {
    if (this.picoWidget) {
      this.element.classList
        .add(this.options.styles.avoidPico);
    }
  }
}
