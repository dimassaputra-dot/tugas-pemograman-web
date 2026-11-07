let currentSlide = 0;
const slides = document.querySelectorAll('.slide');

function showSlide(index) {
    if (slides.length === 0) return;
    
    slides.forEach((slide) => slide.classList.remove('active'));
    currentSlide = (index + slides.length) % slides.length;
    slides[currentSlide].classList.add('active');
}

function changeSlide(direction) {
    showSlide(currentSlide + direction);
}

// Jalankan otomatis setiap 4 detik
setInterval(() => {
    changeSlide(1);
}, 4000);