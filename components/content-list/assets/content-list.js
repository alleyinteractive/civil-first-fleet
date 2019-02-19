// File for logic corresponding to header component
import { Component } from 'js-component-framework';

/**
 * Component for site header
 */
export default class LoadMore extends Component {
  /**
   * Start the component
   */
  constructor(config) {
    super(config);
    this.addLoadMoreListener();

    // Vars
    this.currentPage = 1;
  }

  addLoadMoreListener() {
    if (this.children.loadMoreButton) {
      this.children.loadMoreButton
        .addEventListener('click', this.requestMore);
    }
  }

  removeButton = () => {
    this.children.loadMoreButton
      .parentElement
      .removeChild(this.children.loadMoreButton);
  };

  requestMore = async () => {
    this.currentPage += 1;
    // Disable button
    this.children.loadMoreButton
      .setAttribute('disabled', true);

    const endpoint =
      `${window.location.pathname}page/${this.currentPage}/?ajax=true`;
    const res = await fetch(endpoint);

    if (200 <= res.status && 300 > res.status) {
      const body = await res.text();
      this.displayMore(body);
    } else {
      // If no more posts, remove button and log status
      console.warn(res.statusText); // eslint-disable-line no-console
      this.removeButton();
    }
  };

  displayMore = (responseBody) => {
    // Query new articles
    const queryWrapper = document.createElement('div');
    queryWrapper.innerHTML = responseBody;
    const moreWrapper = queryWrapper
      .querySelector(this.options.wrapperClass);
    const moreArticles = [...moreWrapper.children];

    // Append new articles
    moreArticles.forEach((article) => {
      this.children.loadMoreWrapper.append(article);
    });

    // Re-enable load more button
    this.children.loadMoreButton
      .removeAttribute('disabled');

    // Remove button if we've reached the end
    if (9 > moreArticles.length) {
      this.removeButton();
    }
  }
}
