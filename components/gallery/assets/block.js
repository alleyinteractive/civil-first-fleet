import omit from 'lodash/fp/omit';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { addFilter } = wp.hooks;

const extendGallery = (galleryBlock) => {
  registerBlockType('civil/lightbox-gallery', {
    ...galleryBlock,
    name: 'civil/lightbox-gallery',
    title: __('Lightbox Gallery'),
    save: () => null,
    attributes: {
      ...galleryBlock.attributes,
      images: omit(
        ['source', 'selector', 'query'],
        galleryBlock.attributes.images
      ),
    },
  });
};

const onBlockRegistered = (block, name) => {
  // register the subcomponent first
  if ('core/gallery' === name) {
    extendGallery(block);
  }
  return block;
};

addFilter(
  'blocks.registerBlockType',
  'civil/lightbox-gallery-register',
  onBlockRegistered
);

export default extendGallery;
