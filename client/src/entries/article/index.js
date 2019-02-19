/**
 * JS for articles (is_single() or is_singular())
 */
import { ComponentManager } from 'js-component-framework';
import domContentLoaded from 'utils/domContentLoaded';
import initEntry from 'entries';

// Article components
import credibilityIndicatorConfig from 'components/credibility-indicators';
import articleBylinesConfig from 'components/article-bylines';
import bodyContentConfig from 'components/body-content';
import galleryConfig from 'components/gallery';

// Entry CSS
import 'components/content-item/assets/card.css';
import 'components/article-grid';
import 'components/article-header';
import 'components/article-body';
import 'components/article-footer';
import 'components/article-taxonomies';
import 'components/featured-articles-widget';
import './article-template.css';

initEntry();

// Create instance of the component manager using `civil-first-fleet`
const manager = new ComponentManager('civil-first-fleet');

// Initialize components
domContentLoaded(() => {
  manager.initComponents([
    articleBylinesConfig,
    credibilityIndicatorConfig,
    bodyContentConfig,
    galleryConfig,
  ]);
});

if (module.hot) {
  module.hot.accept();
}
