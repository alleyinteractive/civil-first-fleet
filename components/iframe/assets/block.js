/* globals civilIframeBlockSettings */

/**
 * iFrame Gutenberg Block.
 */
(function invoke(blocks, components, i18n, element, editor) {
  // Alias a couple of common functions.
  const el = element.createElement;
  const { __ } = i18n;

  const { InspectorControls } = editor;
  const {
    PanelBody,
    TextControl,
    ServerSideRender,
  } = components;

  // Register block.
  blocks.registerBlockType('civil/iframe', {
    title: __('iframe'),
    icon: 'media-code',
    category: 'embed',

    // Declare attributes to be saved.
    attributes: civilIframeBlockSettings,

    // Create editing interface.
    edit(props) {
      const {
        src,
        width,
        height,
        scrolling,
        style,
        classes,
      } = props.attributes;

      return [
        el(
          InspectorControls,
          { key: 'controls' },
          el(
            PanelBody,
            { title: __('iframe Settings') },
            el(
              TextControl,
              {
                label: __('Source'),
                help: __('The source URL of the iframe (i.e. "https://joincivil.com")'),
                value: src,
                onChange(value) {
                  props.setAttributes({ src: value });
                },
              }
            ),
            el(
              TextControl,
              {
                label: __('Width'),
                help: __('The width of the iframe (i.e. "640")'),
                value: width,
                onChange(value) {
                  props.setAttributes({ width: value });
                },
              }
            ),
            el(
              TextControl,
              {
                label: __('Height'),
                help: __('The height of the iframe (i.e. "320")'),
                value: height,
                onChange(value) {
                  props.setAttributes({ height: value });
                },
              }
            ),
            el(
              TextControl,
              {
                label: __('Scrolling'),
                help: __('The scrolling attribute, leave blank to remove ' +
                  'attribute'),
                value: scrolling,
                onChange(value) {
                  props.setAttributes({ scrolling: value });
                },
              }
            ),
            el(
              TextControl,
              {
                label: __('Style'),
                help: __('The style attribute of the iframe (i.e. ' +
                  '"font-size: 14px;"")'),
                value: style,
                onChange(value) {
                  props.setAttributes({ style: value });
                },
              }
            ),
            el(
              TextControl,
              {
                label: __('Classes'),
                help: __('Extra classes for the iframe (i.e. ' +
                  '"class-1 class-2")'),
                value: classes,
                onChange(value) {
                  props.setAttributes({ classes: value });
                },
              }
            )
          ),
        ),
        el(
          ServerSideRender,
          {
            block: 'civil/iframe',
            attributes: props.attributes,
          }
        ),
      ];
    },

    // No need to save content--this uses dynamic rendering and stores attributes only.
    save() {
      return null;
    },
  });
}(
  window.wp.blocks,
  window.wp.components,
  window.wp.i18n,
  window.wp.element,
  window.wp.editor,
));
