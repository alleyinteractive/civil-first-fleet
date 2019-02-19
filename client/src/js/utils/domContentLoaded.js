const domContentLoaded = (cb) => {
  if ('complete' !== document.readyState &&
    'interactive' !== document.readyState) {
    document.addEventListener('DOMContentLoaded', cb);
  } else {
    cb();
  }
};

export default domContentLoaded;
