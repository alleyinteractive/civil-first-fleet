// File for logic corresponding to footer component
import './assets/civil-footer.css';
import CivilFooter from './assets/civil-footer';

const componentName = 'civil-footer';
const styles = civilCMSClassnames[componentName];

const civilFooterConfig = {
  name: componentName,
  class: CivilFooter,
  options: {
    styles,
    picoID: 'pico-widget-container',
  },
};

export default civilFooterConfig;
