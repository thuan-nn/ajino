// https://github.com/michael-ciniawsky/postcss-load-config

module.exports = {
  "plugins": {
    "postcss-import": {},
    "postcss-mixins": {},
    "postcss-for": {},
    "postcss-url": {},
    "postcss-cssnext": {
      browsers: ['iOS >= 10.0', 'Android >= 4.4']
    },
    "cssnano": {},
    "postcss-nested": {}
    // to edit target browsers: use "browserslist" field in program-second-confirm.json
    // "autoprefixer": {}
  }
}
