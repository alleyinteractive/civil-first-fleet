/* globals civilCMS */

// File for logic corresponding to header component
import { Component } from 'js-component-framework';

/**
 * Component for the CallToAction.
 */
export default class CallToAction extends Component {
  /**
   * Start the component
   */
  constructor(config) {
    super(config);
    this.submitForm();
  }

  /**
   * Listens for the form submission and performs an AJAX request to ther server
   * to send the user email to Mailchimp.
   */
  submitForm() {
    this.children.submitButton
      .addEventListener('click', (event) => {
        event.preventDefault();

        this.children.dataField.style.display = 'none';

        // Send data to backend for processing.
        jQuery.post(civilCMS.commonData.ajaxUrl, {
          action: 'civil_newsletter_submission',
          email: this.children.emailField.value,
          list: this.children.listField.value,
          newsletter_nonce: civilCMS.commonData.newsletterNonce,
        }, (response) => {
          this.children.dataField.style.display = 'block';
          this.children.messageField.innerHTML = response.data;

          // Add class to message based on response type.
          if (response.success) {
            this.children.messageField.classList
              .add('message-success');
          } else {
            this.children.messageField.classList
              .add('message-error');
          }
        });
      });
  }
}
