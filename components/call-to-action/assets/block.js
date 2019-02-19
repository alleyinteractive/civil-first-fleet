import React, { Fragment } from 'react';

/**
 * Call To Action Gutenberg Block.
 */
const {
  blocks,
  components,
  i18n,
  editor,
} = window.wp;

// Alias a couple of common functions.
const { __ } = i18n;
const { InspectorControls } = editor;
const { registerBlockType } = blocks;
const {
  PanelBody,
  TextareaControl,
  TextControl,
  ToggleControl,
  SelectControl,
  ServerSideRender,
} = components;

// Register block.
/* eslint-disable camelcase */
registerBlockType('civil/call-to-action', {
  title: __('Call to Action'),
  icon: 'megaphone',
  category: 'widgets',

  // Declare attributes to be saved.
  attributes: {
    title: {
      type: 'text',
    },
    cta_text: {
      type: 'text',
    },
    cta_button_text: {
      type: 'text',
    },
    newsletter: {
      type: 'boolean',
    },
    newsletter_list: {
      type: 'text',
    },
  },

  // Create editing interface.
  edit(props) {
    const {
      attributes,
      setAttributes,
    } = props;
    const {
      title,
      cta_text,
      cta_button_text,
      newsletter,
      newsletter_list,
    } = attributes;
    const createOnChange = (field) => (value) => {
      setAttributes({ [field]: value });
    };

    return (
      <Fragment>
        <InspectorControls key="controls">
          <PanelBody title={__('Call to Action Settings')}>
            <TextControl
              label={__('Call to Action Title')}
              value={title}
              onChange={createOnChange('title')}
            />
            <TextareaControl
              label={__('Call to Action Description')}
              value={cta_text}
              onChange={createOnChange('cta_text')}
            />
            <TextControl
              label={__('CTA Button Text')}
              value={cta_button_text}
              onChange={createOnChange('cta_button_text')}
            />
            <ToggleControl
              value={newsletter}
              checked={!! newsletter}
              label={__('Show newsletter form')}
              onChange={createOnChange('newsletter')}
            />
            <SelectControl
              label={__('Newsletter')}
              value={newsletter_list}
              onChange={createOnChange('newsletter_list')}
              options={window.civilNewsletterOptions}
            />
          </PanelBody>
        </InspectorControls>
        <ServerSideRender
          block="civil/call-to-action"
          attributes={attributes}
        />
      </Fragment>
    );
  },

  // No need to save content--this uses dynamic rendering and stores attributes only.
  save() {
    return null;
  },
});
/* eslint-enable */
