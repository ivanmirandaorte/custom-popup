<?php

/**
 * Frontend modal markup.
 *
 * @package WP_Popup
 */

if (! defined('ABSPATH')) {
  exit;
}

$image_rel_path = '/wp-popup/assets/AHF_Forbes_Web Banner_1000x1350.jpg';
$image_file     = get_stylesheet_directory() . $image_rel_path;
$image_url      = file_exists($image_file) ? (get_stylesheet_directory_uri() . $image_rel_path) : '';
?>
<div
  class="wp-popup-modal"
  id="wpPopupModal"
  aria-hidden="true"
  role="dialog"
  aria-modal="true"
  aria-labelledby="wpPopupTitle">
  <div class="wp-popup-modal__overlay" data-popup-close></div>

  <div class="wp-popup-modal__card" role="document">
    <button
      class="wp-popup-modal__close"
      type="button"
      aria-label="<?php esc_attr_e('Close popup', 'pro-child'); ?>"
      data-popup-close>
      &times;
    </button>

    <?php if (! empty($image_url)) : ?>
      <div class="wp-popup-modal__media">
        <img src="<?php echo esc_url($image_url); ?>" alt="<?php esc_attr_e('Popup visual', 'pro-child'); ?>" />
      </div>
    <?php endif; ?>

    <div class="wp-popup-modal__body">
      <!-- <h2 class="wp-popup-modal__title" id="wpPopupTitle"><?php esc_html_e('Important Update', 'pro-child'); ?></h2> -->
      <a href="https://www.desertsun.com/story/news/nation/california/2026/02/20/california-is-home-to-26-of-forbes-americas-best-companies-to-work-for/88777559007/" class="wp-popup-modal__action" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Learn More', 'pro-child'); ?></a>
    </div>
  </div>
</div>