/*
 * Shared logic for all entry points
 */

// Global modules
import { ComponentManager } from 'js-component-framework';
import domContentLoaded from 'utils/domContentLoaded';

// Global components
import civilHeaderConfig from 'components/civil-header';
import civilFooterConfig from 'components/civil-footer';
import newsroomHeaderConfig from 'components/newsroom-header';
import contentListConfig from 'components/content-list';
import CallToActionConfig from 'components/call-to-action';
import 'components/newsroom-footer';
import 'components/logo';
import 'components/image';
import 'components/subscribe-button';
import 'components/search-form';

// Global styles
import 'css/global/global.css';

/*
 * Create a new component manager, initialize global components,
 * return manager for use with initializing entry-specific components
 */
export default function initEntry() {
  // Create instance of the component manager using `civil-cms`
  const manager = new ComponentManager('civil-cms');

  // Initialize components
  domContentLoaded(() => {
    manager.initComponents([
      civilHeaderConfig,
      civilFooterConfig,
      newsroomHeaderConfig,
      CallToActionConfig,
      contentListConfig,
    ]); // You can supply an array of configurations to start many components at once
  });

  return manager;
}
