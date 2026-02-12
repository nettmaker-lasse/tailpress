(() => {
  const blocks = document.querySelectorAll('.tailpress-example');
  if (!blocks.length) return;

  blocks.forEach((block) => {
    block.setAttribute('data-example-ready', 'true');
  });
})();
