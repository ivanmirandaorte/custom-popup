(function () {
  var modal = document.getElementById('wpPopupModal');
  if (!modal) return;

  // Detect if we're in Cornerstone editor
  function isCornerstoneEditor() {
    // Check if parent window has Cornerstone
    if (window.parent && window.parent.Cornerstone) {
      return true;
    }

    // Check if current window has Cornerstone
    if (window.Cornerstone) {
      return true;
    }

    // Check URL parameters
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('cornerstone') || urlParams.get('cs') || urlParams.get('cornerstone-edit') || urlParams.get('cornerstone-preview')) {
      return true;
    }

    // Check if we're in an iframe and parent is editing
    try {
      if (window.self !== window.top && window.top.Cornerstone) {
        return true;
      }
    } catch (e) {
      // Cross-origin check
    }

    return false;
  }

  // Detect if we're on the home page
  function isHomePage() {
    // Check for WordPress 'home' body class 
    if (document.body.classList.contains('home')) {
      return true;
    }

    // Check if pathname is root 
    if (window.location.pathname === '/') {
      return true;
    }

    return false;
  }

  // If in Cornerstone editor, don't proceed
  if (isCornerstoneEditor()) {
    return;
  }

  // Only show popup on home page 
  if (!isHomePage()) {
    return;
  }

  var closeTriggers = modal.querySelectorAll('[data-popup-close]');
  var actionButtons = modal.querySelectorAll('.wp-popup-modal__action');
  var sessionKey = 'wpPopupShown';

  function openModal() {
    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    // Mark popup as shown in this session
    sessionStorage.setItem(sessionKey, 'true');
  }

  function closeModal() {
    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }

  closeTriggers.forEach(function (trigger) {
    trigger.addEventListener('click', closeModal);
  });

  actionButtons.forEach(function (button) {
    button.addEventListener('click', closeModal);
  });

  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape' && modal.classList.contains('is-open')) {
      closeModal();
    }
  });

  // Show popup only once per session with 3 second delay
  if (!sessionStorage.getItem(sessionKey)) {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', function () {
        setTimeout(openModal, 3000);
      });
    } else {
      setTimeout(openModal, 3000);
    }
  }
})();
