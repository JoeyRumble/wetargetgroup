import './bootstrap.js';
import './styles/app.css';  // je Tailwind CSS bestand
import 'taos/dist/taos.js';

// Sticky Navigation Functionality

function removeStickyNavListeners(listeners) {
  if (!listeners) return;
  window.removeEventListener('scroll', listeners.scroll);
  window.removeEventListener('resize', listeners.resize);
  listeners.navLinks && listeners.navLinks.forEach(({link, handler}) => {
    link.removeEventListener('click', handler);
  });
}

let stickyNavListeners = null;

function initStickyNav() {
  // Remove old listeners if any
  removeStickyNavListeners(stickyNavListeners);

  const stickyNav = document.getElementById('sticky-nav');
  const stickyNavContainer = document.getElementById('sticky-nav-container');
  const navLinks = document.querySelectorAll('.nav-link');
  const sections = document.querySelectorAll('[id^="section-"]');

  // Only initialize if elements exist (for people page)
  if (!stickyNav || !stickyNavContainer) return;

  let stickyNavOffset = 0;
  let containerBottom = 0;
  let isSticky = false;

  // Calculate the initial position of the nav and container bounds
  function calculateStickyOffset() {
    if (stickyNavContainer) {
      const containerRect = stickyNavContainer.getBoundingClientRect();
      stickyNavOffset = containerRect.top + window.pageYOffset;

      // Find the parent container that holds all the content sections
      const parentContainer = stickyNavContainer.closest('.max-w-\\[1180px\\]');
      if (parentContainer) {
        const parentRect = parentContainer.getBoundingClientRect();
        containerBottom = parentRect.bottom + window.pageYOffset;
      }
    }
  }

  // Handle sticky navigation
  function handleStickyNav() {
    const scrollTop = window.pageYOffset;
    const shouldBeSticky = scrollTop >= (stickyNavOffset - 100);
    const stickyNavHeight = stickyNav.offsetHeight;
    const shouldStopSticky = scrollTop + 100 + stickyNavHeight >= containerBottom;

    if (shouldBeSticky && !shouldStopSticky && !isSticky) {
      stickyNav.classList.add('fixed', 'top-[100px]', 'z-50', 'bg-white', 'w-[245px]');
      isSticky = true;
    } else if ((!shouldBeSticky || shouldStopSticky) && isSticky) {
      stickyNav.classList.remove('fixed', 'top-[100px]', 'z-50', 'bg-white', 'w-[245px]');
      isSticky = false;
    }
  }

  // Handle active section highlighting
  function handleActiveSection() {
    const scrollTop = window.pageYOffset + 150; // offset for better UX

    let activeSection = '';

    sections.forEach(section => {
      const rect = section.getBoundingClientRect();
      const sectionTop = rect.top + window.pageYOffset;
      const sectionBottom = sectionTop + rect.height;

      if (scrollTop >= sectionTop && scrollTop < sectionBottom) {
        activeSection = section.id;
      }
    });

    // Update active nav link
    navLinks.forEach(link => {
      const href = link.getAttribute('href');
      if (href === '#' + activeSection) {
        link.classList.remove('opacity-50');
        link.classList.add('opacity-100');
      } else {
        link.classList.remove('opacity-100');
        link.classList.add('opacity-50');
      }
    });
  }

  // Initialize
  calculateStickyOffset();
  handleActiveSection();

  // Listen for scroll events
  const scrollHandler = function() {
    handleStickyNav();
    handleActiveSection();
  };
  window.addEventListener('scroll', scrollHandler);

  // Recalculate on resize
  const resizeHandler = function() {
    if (!isSticky) {
      calculateStickyOffset();
    }
  };
  window.addEventListener('resize', resizeHandler);

  // Smooth scrolling for navigation links
  const navLinkListeners = [];
  navLinks.forEach(link => {
    const handler = function(e) {
      e.preventDefault();
      const targetId = this.getAttribute('href');
      const targetElement = document.querySelector(targetId);

      if (targetElement) {
        const offsetTop = targetElement.offsetTop - 120; // offset for sticky nav
        window.scrollTo({
          top: offsetTop,
          behavior: 'smooth'
        });
      }
    };
    link.addEventListener('click', handler);
    navLinkListeners.push({link, handler});
  });

  // Save listeners for cleanup
  stickyNavListeners = {
    scroll: scrollHandler,
    resize: resizeHandler,
    navLinks: navLinkListeners
  };
}





// Remove listeners before Turbo renders new content (before-render)
document.addEventListener('turbo:before-render', function(e) {
  removeStickyNavListeners(stickyNavListeners);
  stickyNavListeners = null;
});

// Remove listeners before Turbo caches the page (before-cache)
document.addEventListener('turbo:before-cache', function(e) {
  removeStickyNavListeners(stickyNavListeners);
  stickyNavListeners = null;
});


// Always re-init on turbo:load (after new content is rendered)
document.addEventListener('turbo:load', function() {
  setTimeout(initStickyNav, 0);
});

// For first page load (non-turbo)
document.addEventListener('DOMContentLoaded', function() {
  setTimeout(initStickyNav, 0);
});