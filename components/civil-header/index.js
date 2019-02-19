import convertToClass from 'utils/convertToClass';
import CivilHeader from './assets/civil-header';
import './assets/civil-header.css';

const componentName = 'civil-header';
const styles = civilCMSClassnames[componentName];

const civilHeaderConfig = {
  name: componentName,
  class: CivilHeader,
  querySelector: {
    menuExpand: convertToClass(styles.menuTrigger),
  },
  options: {
    styles,
  },
};

export default civilHeaderConfig;
