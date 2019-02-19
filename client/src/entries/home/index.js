/**
 * Homepage entry
 */
import initEntry from 'entries';

// Homepage components
import 'components/article-bylines';
import 'components/featured-articles';
import 'components/article-grid';
import 'components/content-item';

// Template CSS
import './user-archive.css';

initEntry();

if (module.hot) {
  module.hot.accept();
}
