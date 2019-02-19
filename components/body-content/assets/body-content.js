// File for logic corresponding to header component
import fastdom from 'fastdom';
import { Component } from 'js-component-framework';

/**
 * Component for site header
 */
export default class BodyContent extends Component {
  /**
   * Start the component
   */
  constructor(config) {
    super(config);

    this.videoEmbeds = Array.prototype
      .filter.call(
        this.children.embeds,
        (embed) => embed.height && embed.width
      )
      .map((iframe) => ({
        floated: 0 < iframe.parentElement.className.search(/align(right|left)/),
        parent: iframe.parentElement,
        iframe,
      }));

    this.resizeEmbed = this.resizeEmbed.bind(this);
    this.setupEmbed = this.setupEmbed.bind(this);

    this.setupEmbed();
  }

  /**
   * Set up iframe attributes and resize listener.
   */
  setupEmbed() {
    Object.keys(this.videoEmbeds).forEach((key) => {
      const embed = this.videoEmbeds[key];

      embed.iframe.setAttribute(
        'data-aspect-ratio',
        `${embed.iframe.height / embed.iframe.width}`
      );
      embed.iframe.removeAttribute('height');
      embed.iframe.removeAttribute('width');
    });

    this.resizeEmbed();
    window.addEventListener('resize', this.resizeEmbed);
  }

  /**
   * Resize the video embed.
   */
  resizeEmbed() {
    Object.keys(this.videoEmbeds).forEach((key) => {
      const embed = this.videoEmbeds[key];

      fastdom.measure(() => {
        const newWidth = embed.floated ?
          embed.parent.offsetWidth :
          this.element.offsetWidth;
        fastdom.mutate(() => {
          embed.iframe.setAttribute(
            'height',
            newWidth * embed.iframe.dataset.aspectRatio
          );
          embed.iframe.setAttribute('width', newWidth);
        });
      });
    });
  }
}
