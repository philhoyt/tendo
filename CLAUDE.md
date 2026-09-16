# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
# Development
npm run start          # Dev server with hot reload
npm run build          # Production build

# Linting
npm run lint:js        # ESLint
npm run lint:scss      # Stylelint (SCSS)
npm run lint:scss:fix  # Auto-fix SCSS lint issues
npm run lint:php       # PHP CodeSniffer (composer lint)
npm run lint:php:fix   # Auto-fix PHP lint issues (composer lint-fix)
composer analyse       # PHPStan static analysis (level 5, WordPress stubs)

# Formatting
npm run format         # Format JS/JSON/MD via wp-scripts
npm run format:check   # Check formatting without writing

# Utilities
npm run screenshot     # Capture screenshot.png of the local site (Puppeteer)
npm run test:smoke     # Boot WordPress Playground and check the main templates render cleanly
npm run packages-update # Update @wordpress/* packages
```

## Architecture

Tendo is a **WordPress block theme** built on the WP-SETS scaffold. There are no PHP page templates — `templates/` and `parts/` hold thin block-based `.html` shells, while the meaningful block markup lives in PHP patterns under `patterns/` (see [Patterns](#patterns)).

### Build Pipeline

`src/` → webpack (`@wordpress/scripts`) → `dist/`

- `src/styles/style.scss` → `dist/css/style.css` (front-end)
- `src/styles/editor.scss` → `dist/css/editor.css` (editor-only)

Webpack (`webpack.config.js`) extends the default `@wordpress/scripts` config, separating CSS into a `css/` subdirectory and generating `*.asset.php` manifest files used by `inc/setup.php` for versioned asset enqueueing. `src/scripts/` is reserved as the entry point for theme JS — add an entry to `webpack.config.js` when the first script lands.

Blocks live under `src/blocks/<name>/` and are discovered automatically: `wp-scripts` globs `src/` for `block.json` and builds an entry point per script field, so no manual entry is needed. `webpack.config.js` **merges** its two CSS entries into that discovered set rather than replacing it — replacing `entry` silently disables block discovery.

`start` and `build` pass `--experimental-modules`, which is required for the `block.json` `viewScriptModule` field (i.e. any Interactivity API block). That flag makes `@wordpress/scripts` export an **array** of two configs — `[scripts, modules]` — instead of one object, which is why `webpack.config.js` destructures both and customises them separately. The `splitChunks` override is deliberately applied only to the scripts config; the Interactivity router arrives via a dynamic `import()` and needs chunking left alone.

`wp-scripts` copies only PHP files referenced directly from `block.json`, so `webpack.config.js` adds a `CopyWebpackPlugin` pattern for `**/parts/*.php`. Put a block's sub-partials in `src/blocks/<name>/parts/` and they will be copied to `dist/` alongside `render.php`.

### SCSS Structure

```
src/styles/
├── tools/_context.scss     # front/editor separation mixin
├── base/global/            # global resets/base styles
└── modules/                # feature-specific partials
```

The `_context.scss` mixin controls whether styles apply on the front-end or in the editor:

```scss
@use "../tools/context";
@include context.is(front) {
	/* front-end only */
}
@include context.is(editor) {
	/* editor only */
}
```

### Theme Identity

- **Text domain / namespace prefix**: `tendo`
- **PHP namespace**: `Tendo\Setup`
- **Colors/spacing/typography**: defined in `theme.json` (not hardcoded CSS)
- **WordPress CSS custom properties**: `--wp--preset--color--*`, `--wp--preset--spacing--*`, `--wp--custom--*`

### Key Files

| File                | Purpose                                                                             |
| ------------------- | ----------------------------------------------------------------------------------- |
| `style.css`         | Theme header — name, version, text domain, `Requires`/`Tested up to` metadata       |
| `theme.json`        | All theme settings: color palette, typography, layout widths, spacing, border radii |
| `inc/setup.php`     | Theme setup hooks, asset enqueueing using `*.asset.php` manifests                   |
| `functions.php`     | Minimal entry point — includes `inc/setup.php`                                      |
| `patterns/`         | PHP patterns holding the theme's block markup (the pattern paradigm)                |
| `webpack.config.js` | Build config extending `@wordpress/scripts` defaults                                |
| `phpcs.xml`         | PHP CodeSniffer ruleset (WordPress standard + PHPCompatibilityWP)                   |
| `phpstan.neon`      | PHPStan config (level 5, WordPress stubs)                                           |

### Conventions

- Tabs for indentation (PHP, JS, SCSS, HTML); spaces for JSON/YAML
- Theme layout uses CSS Grid on `.wp-site-blocks` (header/main/footer)
- Core block patterns are disabled; custom patterns go in `patterns/`
- Admin bar height is exposed as a CSS custom property for layout offset calculations

### Patterns

This scaffold follows the **pattern-paradigm** used by Twenty Twenty-Five: templates and template-parts under `templates/` and `parts/` are thin shells; the meaningful block markup lives in PHP patterns under `patterns/` and is composed via `<!-- wp:pattern {"slug":"tendo/…"} -->`.

**Why patterns instead of inline block markup in templates?**

- **i18n works.** Pattern files are PHP, so user-facing strings can use `esc_html__()`, `esc_html_e()`, `esc_attr_x()` directly — even inside block JSON attributes like `label` or `ariaLabel`. `make-pot` extracts them with no special handling.
- **Reuse.** The same query-loop / comments / post-nav pattern is referenced from multiple templates instead of duplicated.
- **Inserter UX.** Patterns with `Block Types:` headers surface as starter options when a user inserts the matching block.

**Pattern header conventions used here**

| Header         | Purpose                                                                            |
| -------------- | ---------------------------------------------------------------------------------- |
| `Title:`       | Display name in the inserter                                                       |
| `Slug:`        | `tendo/{name}` — must match the namespace                                          |
| `Categories:`  | Inserter grouping (`header`, `footer`, `query`, `text`)                            |
| `Block Types:` | Marks the pattern as a starter for that block (e.g. `core/query`, `core/comments`) |
| `Inserter: no` | Suppresses the pattern from the inserter UI                                        |

**Naming conventions**

- `header.php` / `footer.php` — site-wide template-part patterns
- `template-*.php` — full-page or major-region patterns that compose a template (`template-query-loop`)
- `hidden-*.php` — internal building blocks referenced only from templates or other patterns; not shown in the inserter
- Other names (`comments.php`, `post-navigation.php`) — reusable building blocks that may also surface in the inserter

### Translations

User-facing strings live in `patterns/*.php` wrapped in `esc_html__()`, `esc_html_e()`, `esc_html_x()`, or `esc_attr_x()` with the `tendo` text domain. To regenerate `languages/tendo.pot`:

```bash
wp i18n make-pot . languages/tendo.pot --include="templates,parts,patterns,inc"
```

The `--include` paths cover both PHP source and any patterns/templates that might pick up additional strings as the theme grows.

### Tendo specifics

- Default palette is neutral (gray/charcoal on white). The theme's original orange look ships as the **Tangerine** color preset in `styles/colors/`, alongside Chill, Lavender, and Moss. Presets set only colors, so they surface under Styles → Colors. Every preset uses `tertiary` as the page background (as 1.x did); without that, a preset is nearly indistinguishable from the default because nothing else in the theme uses `primary` or `tertiary`.
- Body text is Courier New (`courier-new`); headings, site title, navigation, and buttons are Arial (`arial-helvetica`). Both are system stacks; no font files are bundled. `styles/typography/` holds Serif, Sans, and Mono presets that also use system stacks only; a preset must redeclare every family it references because a typography preset replaces the theme's `fontFamilies` list.
- Block style variations in `styles/block/`: `tendo-striped` (separator; the 1.x class name, kept so old content keeps its stripes), `section-contrast` (group/columns dark band with matching heading, link, and button colors; Info Card uses it), and `post-terms-badge`.
- Spacing slugs are `20`–`60`; font-size slugs are `small`, `base`, `medium`, `large`, `x-large`, `xx-large`.
- `--wp--custom--rule` and `--wp--custom--wash` are palette-agnostic `color-mix()` tokens for hairlines and light fills. Use them instead of a palette color where the element must work on every preset.
- Block style variations live in `styles/block/*.json` (WordPress 6.6+), not in `register_block_style()` calls.
- `.github/blueprint.json` powers the Playground demo link in the README; it installs the `tendo.zip` asset from the GitHub release, because the repo itself has no built `dist/`.
- Releases: push a `MAJOR.MINOR.PATCH` tag; `.github/workflows/release.yml` builds and attaches the zip. WordPress.org themes are uploaded manually from that zip. `.github/workflows/ci.yml` lints, builds, and smoke-tests every push.
- `templates/blank.html` and `templates/page-no-title.html` are custom templates registered in `theme.json`. There is deliberately no `front-page.html` so a "latest posts" front page falls through to `index.html`.
