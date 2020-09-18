/**
 * Homepage entry
 */
import initEntry from 'entries';

// Homepage components
import 'components/article-bylines';
import 'components/featured-articles';
import 'components/middle-feature';
import 'components/article-grid';
import 'components/content-item';
import 'components/ziprecruiter-jobs-block';

// Template CSS
import './user-archive.css';

initEntry();

if (module.hot) {
  module.hot.accept();
}
