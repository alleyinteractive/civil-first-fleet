import convertToClass from 'utils/convertToClass';
import './assets/article-bylines.css';
import ArticleBylines from './assets/article-bylines';

const componentName = 'article-bylines';
const styles = civilCMSClassnames[componentName];

const articleBylinesConfig = {
  name: componentName,
  class: ArticleBylines,
  querySelector: {},
  querySelectorAll: {
    wrappers: `${convertToClass(styles.bio)}, .bio`,
  },
  options: {
    selectors: {
      header: convertToClass(styles.bioHeader),
      content: convertToClass(styles.bioContentWrapper),
      name: convertToClass(styles.bioName),
      contentInner: convertToClass(styles.bioContentInner),
    },
  },
};

export default articleBylinesConfig;
