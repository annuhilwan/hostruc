// =============================================
// OFFER SLIDER (Our Services)
// =============================================
(function () {
    const track  = document.getElementById('offerTrack');
    const prev   = document.getElementById('offerPrev');
    const next   = document.getElementById('offerNext');
    const dots   = document.querySelectorAll('.offer-dot');

    if (!track || !prev || !next) return;

    const VISIBLE = () => window.innerWidth < 700 ? 1 : window.innerWidth < 1024 ? 2 : 3;
    const totalCards = track.children.length;
    let current = 0;

    function cardWidth() {
        const card = track.children[0];
        return card ? card.offsetWidth + 4 : 0; // 4 = gap
    }

    function goTo(index) {
        const max = totalCards - VISIBLE();
        current = Math.max(0, Math.min(index, max));
        track.scrollTo({ left: current * cardWidth(), behavior: 'smooth' });
        dots.forEach((d, i) => d.classList.toggle('active', i === current));
    }

    prev.addEventListener('click', () => goTo(current - 1));
    next.addEventListener('click', () => goTo(current + 1));
    dots.forEach(d => d.addEventListener('click', () => goTo(+d.dataset.index)));

    // Sync dots on manual scroll
    track.addEventListener('scroll', () => {
        const cw = cardWidth();
        if (cw > 0) {
            const idx = Math.round(track.scrollLeft / cw);
            dots.forEach((d, i) => d.classList.toggle('active', i === idx));
            current = idx;
        }
    }, { passive: true });
})();

// =============================================
// HAMBURGER MENU TOGGLE
// =============================================
const hamburger   = document.getElementById('hamburger');
const navMenu     = document.getElementById('nav-menu');
const navBackdrop = document.getElementById('navBackdrop');
const navLinks    = document.querySelectorAll('.nav-link');

function openNav() {
    hamburger.classList.add('active');
    navMenu.classList.add('active');
    if (navBackdrop) navBackdrop.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeNav() {
    hamburger.classList.remove('active');
    navMenu.classList.remove('active');
    if (navBackdrop) navBackdrop.classList.remove('active');
    document.body.style.overflow = '';
}

if (hamburger && navMenu) {
    hamburger.addEventListener('click', () => {
        navMenu.classList.contains('active') ? closeNav() : openNav();
    });

    // Close when a nav link is clicked
    navLinks.forEach(link => link.addEventListener('click', closeNav));

    // Close when backdrop is clicked
    if (navBackdrop) navBackdrop.addEventListener('click', closeNav);
}

// =============================================
// NAVBAR SCROLL EFFECTS
// =============================================
const navbar = document.getElementById('navbar');
if (navbar) {
    window.addEventListener('scroll', () => {
        if (window.scrollY > 0) {
            navbar.style.boxShadow = '0 2px 12px rgba(26,47,74,0.1)';
        } else {
            navbar.style.boxShadow = 'none';
        }
    }, { passive: true });
}

// =============================================
// SCROLL REVEAL ANIMATIONS
// =============================================
const revealEls = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');

if (revealEls.length > 0) {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    revealEls.forEach(el => observer.observe(el));
}

// =============================================
// SMOOTH SCROLL FOR ANCHOR LINKS
// =============================================
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            e.preventDefault();
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// =============================================
// ACTIVE NAV LINK BASED ON SCROLL POSITION
// =============================================
function updateActiveNavLink() {
    const sections = document.querySelectorAll('section');
    const navLinks = document.querySelectorAll('.nav-link');
    
    let current = '';
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (scrollY >= (sectionTop - 200)) {
            current = section.getAttribute('id');
        }
    });
    
    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href').includes(current)) {
            link.classList.add('active');
        }
    });
}

window.addEventListener('scroll', updateActiveNavLink, { passive: true });

// =============================================
// FORM VALIDATION & SUBMISSION
// =============================================
function setupFormHandlers() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Basic validation
            const inputs = this.querySelectorAll('input[required], textarea[required], select[required]');
            let isValid = true;
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.style.borderColor = '#e07b2a';
                    isValid = false;
                } else {
                    input.style.borderColor = '';
                }
            });
            
            if (isValid) {
                const formData = new FormData(this);
                const data = Object.fromEntries(formData);
                
                // You can submit to server here if needed
                console.log('Form submitted:', data);
                alert('Terima kasih! Form Anda telah dikirim.');
                this.reset();
            } else {
                alert('Silakan isi semua field yang diperlukan');
            }
        });
    });
}

// Initialize form handlers when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', setupFormHandlers);
} else {
    setupFormHandlers();
}

// =============================================
// UTILITY FUNCTIONS
// =============================================

// Add elements to viewport trigger animation
function animateOnScroll() {
    const elements = document.querySelectorAll('[data-animate]');
    
    elements.forEach(el => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = entry.target.dataset.animate;
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        
        observer.observe(el);
    });
}

// Throttle function for performance
function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}
