// Navigation functionality
const navLinks = document.querySelectorAll(".nav-link");
const pages = document.querySelectorAll(".page");
const mobileMenuBtn = document.getElementById("mobileMenuBtn");
const navLinksContainer = document.getElementById("navLinks");

// Handle page navigation
navLinks.forEach((link) => {
    link.addEventListener("click", (e) => {
        e.preventDefault();
        const targetPage = link.getAttribute("data-page");

        // Update active nav link
        navLinks.forEach((l) => l.classList.remove("active"));
        link.classList.add("active");

        // Show target page
        pages.forEach((page) => page.classList.remove("active"));
        document.getElementById(targetPage).classList.add("active");

        // Close mobile menu
        navLinksContainer.classList.remove("active");
    });
});

// Mobile menu toggle
mobileMenuBtn.addEventListener("click", () => {
    navLinksContainer.classList.toggle("active");
});

// Contact form submission
document.getElementById("contactForm").addEventListener("submit", (e) => {
    e.preventDefault();
    alert("Thank you for your message! We will get back to you soon.");
    e.target.reset();
});

// Smooth scrolling for internal links
// document.addEventListener('click', (e) => {
//     if (e.target.classList.contains('cta-btn') || e.target.classList.contains('btn-secondary')) {
//         e.preventDefault();
//         // Add your campaign creation or browsing logic here
//         alert('Campaign functionality will be implemented in the backend.');
//     }
// });
const observers = document.querySelectorAll(".animate");

const options = {
    threshold: 0.2,
};

const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add("visible");
            observer.unobserve(entry.target);
        }
    });
}, options);

observers.forEach((el) => observer.observe(el));

document.querySelectorAll(".accordion-header").forEach((button) => {
    button.addEventListener("click", () => {
        const item = button.parentElement;
        const allItems = document.querySelectorAll(".accordion-item");

        // Close all
        allItems.forEach((i) => {
            if (i !== item) i.classList.remove("active");
        });

        // Toggle current
        item.classList.toggle("active");
    });
});

// Auto-open the first
window.addEventListener("DOMContentLoaded", () => {
    const first = document.querySelector(".accordion-item");
    if (first) first.classList.add("active");
});

document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("testimonialContainer");
    const slides = document.querySelectorAll(".testimonial-slide");
    const dots = document.querySelectorAll(".slider-dot");
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");

    let currentIndex = 0;
    const slideCount = slides.length;

    function updateSlider() {
        const slideWidth = slides[0].offsetWidth;
        container.style.transform = `translateX(-${
            currentIndex * slideWidth
        }px)`;

        dots.forEach((dot) => dot.classList.remove("active"));
        dots[currentIndex].classList.add("active");
    }

    function goToNextSlide() {
        currentIndex = (currentIndex + 1) % slideCount;
        updateSlider();
    }

    nextBtn.addEventListener("click", () => {
        goToNextSlide();
    });

    prevBtn.addEventListener("click", () => {
        currentIndex = (currentIndex - 1 + slideCount) % slideCount;
        updateSlider();
    });

    dots.forEach((dot, index) => {
        dot.addEventListener("click", () => {
            currentIndex = index;
            updateSlider();
        });
    });

    // Auto-scroll every 5 seconds
    setInterval(goToNextSlide, 5000);

    updateSlider(); // Initial render
});
