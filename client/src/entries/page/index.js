/**
 * JS for pages
 */
import initEntry from 'entries';

// Entry CSS
import 'components/body-content';
import 'components/page-header';
import 'components/page-body';
import 'components/error-page';
import './page-template.css';

initEntry();

if (module.hot) {
  module.hot.accept();
}
