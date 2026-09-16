# Tendo

Tendo is a clean and minimalist block theme built for the WordPress Site Editor. Monospaced body text is paired with bold sans-serif headings on a quiet, neutral canvas.

- Listed on WordPress.org: https://wordpress.org/themes/tendo/
- Built on the [WP-SETS](https://github.com/philhoyt/wp-site-editor-theme-scaffold) theme scaffold

## Requirements

- WordPress 6.6 or later
- PHP 7.4 or later
- Node.js 20 or later and Composer for development

## Development

```bash
npm install
composer install
npm run start     # watch and rebuild src/ into dist/
npm run build     # production build
```

Linting and formatting:

```bash
npm run lint:scss
npm run lint:php
composer analyse
npm run format
```

## Structure

| Path                      | Purpose                                                    |
| ------------------------- | ---------------------------------------------------------- |
| `theme.json`              | Palette, typography, spacing, layout, and block styles     |
| `styles/colors/`          | Color presets: Tangerine, Chill, Lavender, Moss            |
| `styles/block/`           | Block style variations, such as the striped separator      |
| `templates/` and `parts/` | Thin block shells that compose patterns                    |
| `patterns/`               | Translatable PHP patterns holding the theme's block markup |
| `src/styles/`             | SCSS source compiled to `dist/css/`                        |
| `inc/setup.php`           | Theme supports, pattern category, and asset loading        |

## Translations

Regenerate the POT file after changing user-facing strings:

```bash
wp i18n make-pot . languages/tendo.pot --include="templates,parts,patterns,inc,functions.php,style.css,theme.json,styles"
```

## Packaging

`.distignore` excludes development files. Build a release zip with:

```bash
npm run build
wp dist-archive . ../tendo.zip
```

## License

GNU General Public License v2 or later.
