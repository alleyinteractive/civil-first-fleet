import './user-profile.css';
import loadAttachmentDetails from './loadAttachmentDetails';
import './blocks';
import './sidebar';

/* globals wp, fm */
const { data } = wp;

/* Fix Fieldmanager Autocomplete
 * Trigger the fieldmanager autocomplete init after Gutenberg
 * has rendered the fields -- only then can the jQuery init be called in
 * wordpress-fieldmanager/js/fieldmanager-autocomplete.js
 *
 * Ultimately, fm will have to have custom admin blocks
 */

let isActive;

// subscribe to WP state to monitor whether the metaboxes are rendered
window.addEventListener('load', () => {
  if (data) {
    data.subscribe(() => {
      isActive = data.select('core/edit-post').hasMetaBoxes();
    });
  }

  loadAttachmentDetails();
});

// If the state shows metaboxes enabled, trigger the jQuery init to setup
const autocompleteInit = window.addEventListener('click', () => {
  if (isActive && fm.autocomplete && fm.autocomplete.enable_autocomplete) {
    fm.autocomplete.enable_autocomplete();
    window.removeEventListener('click', autocompleteInit);
  }
});
