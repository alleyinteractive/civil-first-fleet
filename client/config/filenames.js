module.exports = {
  fileNoHash: 'js/[name].bundle.js',
  chunkNoHash: 'js/[name].chunk.js',
  cssNoHash: 'css/[name].css',
  fileWithHash: 'js/[name].[chunkhash].bundle.min.js',
  chunkWithHash: 'js/[name].[chunkhash].chunk.min.js',
  cssWithHash: 'css/[name].[hash].min.css',
  localIdentTemplate: '[name]__[local]___[hash:base64:5]',
};
