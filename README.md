# Tendo

Tendo is a clean and minimalist block theme built for the WordPress Site Editor. Monospaced body text is paired with bold sans-serif headings on a quiet, neutral canvas.

- Listed on WordPress.org: https://wordpress.org/themes/tendo/
- Built on the [WP-SETS](https://github.com/philhoyt/wp-site-editor-theme-scaffold) theme scaffold
- [Try it in WordPress Playground](https://playground.wordpress.net/?blueprint-url=https://raw.githubusercontent.com/philhoyt/tendo/master/.github/blueprint.json) (installs the latest release zip, so it works once 2.0.0 is published)

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
npm run lint:js
npm run lint:php
composer analyse
npm run format
```

Smoke test (boots WordPress Playground with the theme, visits the main templates, and fails on PHP or console errors):

```bash
npm run test:smoke
```

GitHub Actions runs the linters, the build, and the smoke test on every push and pull request.

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

## Releasing

1. Bump the version in `style.css`, `readme.txt` (Stable tag), and `package.json`, and add a changelog entry to `readme.txt`.
2. Commit, then tag and push the tag:

   ```bash
   git tag 2.0.0 && git push origin 2.0.0
   ```

The release workflow builds the theme, packages it with `wp dist-archive` (honouring `.distignore`), and attaches `tendo.zip` to a GitHub release. Upload that zip through the WordPress.org theme upload form.

To build the zip locally instead:

```bash
npm run build
wp package install "wp-cli/dist-archive-command:^3.1"
wp dist-archive . ../tendo.zip --plugin-dirname=tendo
```

## License

GNU General Public License v2 or later.
