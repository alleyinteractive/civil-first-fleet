import convertToClass from 'utils/convertToClass';
import ContentList from './assets/content-list';
import './assets/content-list.css';

const componentName = 'content-list';
const styles = civilCMSClassnames[componentName];

const contentListConfig = {
  name: componentName,
  class: ContentList,
  querySelector: {
    loadMoreButton: convertToClass(styles.loadMoreButton),
    loadMoreWrapper: convertToClass(styles.loadMoreWrapper),
  },
  options: {
    styles,
    wrapperClass: convertToClass(styles.loadMoreWrapper),
    contentItemClass: '.content-item',
  },
};

export default contentListConfig;
