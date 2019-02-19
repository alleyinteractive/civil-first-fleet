import convertToClass from 'utils/convertToClass';
import NewsroomHeader from './assets/newsroom-header';
import './assets/newsroom-header.css';

const styles = civilCMSClassnames['newsroom-header'];

const newsroomHeaderConfig = {
  name: 'newsroom-header',
  class: NewsroomHeader,
  querySelector: {
    menuTrigger: convertToClass(styles.menuTrigger),
    searchTrigger: convertToClass(styles.searchTrigger),
  },
  querySelectorAll: {
    submenuTriggers: '.menu-item-has-children > a',
  },
  options: {
    styles,
    submenuSelector: '.sub-menu',
    openSearchClass: 'header-search-is-open',
    searchInputSelector: '.search-form__input',
  },
};

export default newsroomHeaderConfig;
