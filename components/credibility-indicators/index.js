import convertToClass from 'utils/convertToClass';
import './assets/credibility-indicators.css';
import CredibilityIndicators from './assets/credibility-indicators';

const componentName = 'credibility-indicators';
const styles = civilCMSClassnames[componentName];
const credibilityIndicatorConfig = {
  name: componentName,
  class: CredibilityIndicators,
  querySelectorAll: {
    indicators: convertToClass(styles.indicator),
  },
  options: {
    styles,
    toggleClass: convertToClass(styles.heading),
    textClass: convertToClass(styles.text),
  },
};

export default credibilityIndicatorConfig;
