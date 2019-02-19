import BodyContent from './assets/body-content';
import './assets/body-content.css';

const componentName = 'body-content';

const bodyContentConfig = {
  name: componentName,
  class: BodyContent,
  querySelectorAll: {
    embeds: '.wp-block-embed.is-type-video iframe',
  },
};

export default bodyContentConfig;
