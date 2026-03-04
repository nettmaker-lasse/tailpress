const path = require('path');
const { src, dest, watch, series, parallel } = require('gulp');
const sassCompiler = require('sass');
const gulpSass = require('gulp-sass')(sassCompiler);
const postcss = require('gulp-postcss');
const sourcemaps = require('gulp-sourcemaps');
const rename = require('gulp-rename');
const terser = require('gulp-terser');
const gulpIf = require('gulp-if');
const { globSync } = require('glob');
const log = require('fancy-log');

const isProd = process.env.NODE_ENV === 'production';

const paths = {
  global: {
    styles: 'assets/styles/main.css',
    scripts: 'assets/scripts/main.js',
    stylesDest: 'dist/styles',
    scriptsDest: 'dist/javascript',
  },
  blocks: {
    styles: 'blocks/*/*.scss',
    scripts: 'blocks/*/*.js',
  },
};

function styles() {
  return src(paths.global.styles, { allowEmpty: true })
    .pipe(gulpIf(!isProd, sourcemaps.init()))
    .pipe(postcss(require('./postcss.config')(isProd)))
    .pipe(rename('main.min.css'))
    .pipe(gulpIf(!isProd, sourcemaps.write('.')))
    .pipe(dest(paths.global.stylesDest));
}

function scripts() {
  return src(paths.global.scripts, { allowEmpty: true })
    .pipe(gulpIf(isProd, terser()))
    .pipe(rename('main.min.js'))
    .pipe(dest(paths.global.scriptsDest));
}

function getBlockStyleEntries() {
  return globSync(paths.blocks.styles).filter((file) => {
    const slug = path.basename(path.dirname(file));
    return path.basename(file, '.scss') === slug;
  });
}

function getBlockScriptEntries() {
  return globSync(paths.blocks.scripts).filter((file) => {
    const slug = path.basename(path.dirname(file));
    return path.basename(file, '.js') === slug;
  });
}

function blockStylesTask() {
  const entries = getBlockStyleEntries();

  if (!entries.length) {
    log('No block styles found');
    return Promise.resolve();
  }

  return src(entries, { base: 'blocks', allowEmpty: true })
    .pipe(gulpIf(!isProd, sourcemaps.init()))
    .pipe(gulpSass.sync({ outputStyle: 'expanded' }).on('error', gulpSass.logError))
    .pipe(postcss(require('./postcss.config')(isProd)))
    .pipe(rename((file) => {
      file.basename = path.basename(file.dirname) + '.min';
      file.dirname = '';
    }))
    .pipe(gulpIf(!isProd, sourcemaps.write('.')))
    .pipe(dest(paths.global.stylesDest));
}

function blockScriptsTask() {
  const entries = getBlockScriptEntries();

  if (!entries.length) {
    log('No block scripts found');
    return Promise.resolve();
  }

  return src(entries, { base: 'blocks', allowEmpty: true })
    .pipe(gulpIf(isProd, terser()))
    .pipe(rename((file) => {
      file.basename = path.basename(file.dirname) + '.min';
      file.dirname = '';
    }))
    .pipe(dest(paths.global.scriptsDest));
}

function watchFiles() {
  watch('assets/styles/**/*.css', styles);
  watch('assets/scripts/**/*.js', scripts);
  watch('blocks/*/*.scss', blockStylesTask);
  watch('blocks/*/*.js', blockScriptsTask);
  watch(['**/*.php', 'blocks/*/*.json'], styles);
}

const build = parallel(styles, scripts, blockStylesTask, blockScriptsTask);

exports.styles = styles;
exports.scripts = scripts;
exports.blockStyles = blockStylesTask;
exports.blockScripts = blockScriptsTask;
exports.build = build;
exports.watch = watchFiles;
exports.default = series(build, watchFiles);
