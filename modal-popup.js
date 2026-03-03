(function () {
  var modal = document.getElementById('wpPopupModal');
  if (!modal) return;

  var closeTriggers = modal.querySelectorAll('[data-popup-close]');
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

  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape' && modal.classList.contains('is-open')) {
      closeModal();
    }
  });

  // Show popup only once per session
  if (!sessionStorage.getItem(sessionKey)) {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', openModal);
    } else {
      openModal();
    }
  }
})();
