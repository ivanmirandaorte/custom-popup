# WP Popup

A lightweight, accessible modal popup for WordPress. Displays once per session with a 3-second delay after page load. Supports Cornerstone page builder and can be restricted to specific pages (e.g. home page only).

## Features

- Appears 3 seconds after page load, once per browser session
- Home-page only by default (configurable)
- Master on/off switch via a single constant
- Suppressed automatically in the Cornerstone editor and WordPress admin
- Accessible: ARIA roles, keyboard (Escape) dismiss, focus-trap-friendly
- Closes on overlay click, close button click, CTA click, or Escape key
- Responsive card layout (360px → 440px → 520px)
- CSS fade-in animation

## File Structure

```
wp-popup/
├── assets/
│   └── your-image.jpg          # Popup image
├── modal-popup-template.php    # HTML markup
├── modal-popup.css             # Styles
├── modal-popup.js              # Behaviour
└── theme-functions-snippet.php # Functions to add to functions.php
```

## Installation

### 1. Copy files into your child theme

Place the entire `wp-popup/` folder inside your child theme directory:

```
wp-content/themes/your-child-theme/
└── wp-popup/
    ├── assets/
    ├── modal-popup-template.php
    ├── modal-popup.css
    └── modal-popup.js
```

### 2. Add the PHP functions to your theme

Open your child theme's `functions.php` and paste in the contents of [theme-functions-snippet.php](theme-functions-snippet.php), **or** include the file directly:

```php
// In functions.php
require_once get_stylesheet_directory() . '/wp-popup/theme-functions-snippet.php';
```

The snippet registers three things:

| Function | Hook | Purpose |
|---|---|---|
| `wp_popup_enqueue_assets()` | `wp_enqueue_scripts` | Loads CSS and JS with cache-busting version |
| `wp_popup_render_template()` | `wp_footer` / `x_after_site_end` | Outputs the modal HTML in the footer |
| `wp_popup_is_cornerstone_editing()` | — | Guard to suppress popup in Cornerstone |

### 3. Add your image

Drop your popup image into `wp-popup/assets/` and update the path in [modal-popup-template.php](modal-popup-template.php):

```php
$image_rel_path = '/wp-popup/assets/your-image.jpg';
```

### 4. Update the CTA link

In [modal-popup-template.php](modal-popup-template.php), find the anchor tag and set your destination URL:

```php
<a href="https://your-url.com" class="wp-popup-modal__action" target="_blank" rel="noopener noreferrer">
    <?php esc_html_e('Learn More', 'your-text-domain'); ?>
</a>
```

Replace `'pro-child'` text domain references with your own theme's text domain.

## Configuration

### Enable / disable the popup site-wide

In [theme-functions-snippet.php](theme-functions-snippet.php), toggle the constant at the top:

```php
define('WP_POPUP_ENABLED', true);  // true = on, false = off
```

### Change which pages show the popup

By default the popup is restricted to the home page in [modal-popup.js](modal-popup.js) via the `isHomePage()` check. To show it on all pages, remove (or comment out) this block:

```js
// Only show popup on home page
if (!isHomePage()) {
  return;
}
```

To show it on a different page, update `isHomePage()` to match your condition — for example by checking a body class WordPress adds to every page:

```js
function isTargetPage() {
  return document.body.classList.contains('page-about');
}
```

### Change the delay

The popup opens 3 seconds after load. Edit the timeout value (in milliseconds) in [modal-popup.js](modal-popup.js):

```js
setTimeout(openModal, 3000); // change 3000 to your desired delay in ms
```

### Change session behaviour

The popup uses `sessionStorage` so it only shows once per browser tab session. To show it every page load (no session check), remove the `sessionStorage` guard in [modal-popup.js](modal-popup.js):

```js
// Remove or comment out this condition:
if (!sessionStorage.getItem(sessionKey)) {
  ...
}
// And call openModal() directly:
setTimeout(openModal, 3000);
```

## Customising the styles

All styles live in [modal-popup.css](modal-popup.css). Key variables to change:

| Selector | Property | What it controls |
|---|---|---|
| `.wp-popup-modal__card` | `width: min(100%, 360px)` | Card width on mobile |
| `.wp-popup-modal__overlay` | `background: rgba(0,0,0,0.6)` | Overlay darkness |
| `.wp-popup-modal__action` | `background: #942020` | CTA button colour |
| `.wp-popup-modal__close` | `background: rgba(0,0,0,0.55)` | Close button colour |

Breakpoints defined in the file: `768px` (tablet) and `1024px` (desktop).

## Adding a title or body text

The title is included in [modal-popup-template.php](modal-popup-template.php) but commented out. Uncomment it to use it:

```php
<h2 class="wp-popup-modal__title" id="wpPopupTitle">
    <?php esc_html_e('Your Headline', 'your-text-domain'); ?>
</h2>
```

A `.wp-popup-modal__text` class is also available in the CSS for a body paragraph:

```php
<p class="wp-popup-modal__text">
    <?php esc_html_e('Your message here.', 'your-text-domain'); ?>
</p>
```

## Cornerstone (Pro Theme) Compatibility

The popup is automatically suppressed whenever Cornerstone is detected, both server-side (PHP) and client-side (JS). No extra configuration is needed. If you are not using the Pro theme / Cornerstone, the guard functions are harmless and can be left in place.

## Requirements

- WordPress 5.0+
- A child theme (recommended) or any theme with a writable `functions.php`
- No JavaScript dependencies — vanilla JS only
