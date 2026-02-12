module.exports = (isProd = false) => {
  const plugins = [require('@tailwindcss/postcss'), require('autoprefixer')];

  if (isProd) {
    plugins.push(require('cssnano')({ preset: 'default' }));
  }

  return plugins;
};
