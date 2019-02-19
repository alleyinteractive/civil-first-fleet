import CallToAction from './assets/call-to-action';
import './assets/call-to-action.css';
import './assets/sticky-cta.css';

const componentName = 'call-to-action';
const styles = civilCMSClassnames[componentName];

const CallToActionConfig = {
  name: componentName,
  class: CallToAction,
  querySelector: {
    listField: '.civil__call-to-action__newsletter-list',
    emailField: '.civil__call-to-action__newsletter-email',
    submitButton: '.civil__call-to-action__newsletter-submit',
    messageField: '.civil__call-to-action__newsletter-message',
    dataField: '.civil__call-to-action__newsletter-data',
  },
  options: {
    styles,
  },
};

export default CallToActionConfig;
