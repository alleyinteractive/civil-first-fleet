/* global wp */

/**
 * Load our custom Attachment template to override attributes like the caption
 * and add other image attributes like the title.  This template is shown when
 * viewing a gallery within the tinymce editor.
 */
export default function loadAttachmentDetails() {
  const { media } = wp;

  if (undefined !== media) {
    if (undefined !== media.view.Attachment.Details.TwoColumn) {
      media.view.Attachment.Details.TwoColumn.prototype.template =
        wp.template('civil-attachment-details-two-column');
    }

    if (undefined !== media.view.Attachment.Details) {
      media.view.Attachment.Details.prototype.template =
        wp.template('civil-attachment-details');
    }
  }
}
