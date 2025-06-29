document.addEventListener('DOMContentLoaded', function() {
    // Testimonial Form Submission Logic
    const form = document.getElementById('new-testimonial');
    // Note: The previous HTML included a commented-out section for displaying new testimonials.
    // If you want to display them, uncomment the #testimonials-list section in HTML
    // and make sure `list` is defined. For now, this part is just handling form submission.
    // const list = document.getElementById('testimonials-list'); // Uncomment if you use this element

    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        const name = form.name.value.trim();
        const msg = form.message.value.trim();
        const satisfaction = form.satisfaction.value; // Get satisfaction rating

        if (!name || !msg) {
            alert('Please fill in both your name and testimonial!');
            return;
        }

        // --- You would typically send this data to a server here ---
        // Example: fetch('/api/submit-testimonial', { method: 'POST', body: JSON.stringify({ name, msg, satisfaction }) });
        console.log('New Testimonial Submitted:');
        console.log(`Name: ${name}`);
        console.log(`Testimonial: ${msg}`);
        console.log(`Satisfaction: ${satisfaction}/100`);
        alert('Thank you for your testimonial! We appreciate your feedback.');

        // Optionally, add the new testimonial to the slider dynamically
        // This is a simple client-side addition and won't persist if the page reloads.
        // For persistence, you'd need a backend.
        const newCard = document.createElement('div');
        newCard.classList.add('testimonial-card');
        // You might want to get a dynamic avatar based on the user or use a default
        newCard.innerHTML = `
            <img src="https://via.placeholder.com/80/f0f0f0?text=${name.charAt(0).toUpperCase()}" alt="${name}" class="testimonial-avatar">
            <p class="testimonial-text">"${msg}"</p>
            <p class="testimonial-author">- ${name}, Satisfaction: ${satisfaction}/100</p>
        `;

        const testimonialSlider = document.querySelector('.testimonial-slider');
        testimonialSlider.appendChild(newCard);

        // Update dots for the new testimonial
        const dotsContainer = document.querySelector('.dots-container');
        const newDot = document.createElement('span');
        newDot.classList.add('dot');
        newDot.dataset.slide = testimonialCards.length; // Assign new index
        dotsContainer.appendChild(newDot);

        // Re-query testimonial cards and dots to include the new ones
        testimonialCards = document.querySelectorAll('.testimonial-card');
        dots = document.querySelectorAll('.dot'); // Update dots NodeList

        // Show the newly added testimonial
        currentIndex = testimonialCards.length - 1;
        showTestimonial(currentIndex);

        form.reset(); // Clear the form
    });

    // Testimonial Slider Logic
    let testimonialCards = document.querySelectorAll('.testimonial-card'); // Use let as it might be reassigned
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    let dots = document.querySelectorAll('.dot'); // Use let as it might be reassigned
    let currentIndex = 0;
    let autoSlideInterval; // Declare it here to be accessible for clear/set interval

    function showTestimonial(index) {
        // Ensure index is within bounds after dynamic additions/removals
        if (index < 0) {
            index = testimonialCards.length - 1;
        } else if (index >= testimonialCards.length) {
            index = 0;
        }
        currentIndex = index; // Update current index

        // Hide all testimonials
        testimonialCards.forEach(card => {
            card.classList.remove('active');
        });

        // Deactivate all dots
        dots.forEach(dot => {
            dot.classList.remove('active');
        });

        // Show the selected testimonial
        testimonialCards[currentIndex].classList.add('active');
        // Activate the corresponding dot
        dots[currentIndex].classList.add('active');
    }

    function nextTestimonial() {
        currentIndex = (currentIndex + 1) % testimonialCards.length;
        showTestimonial(currentIndex);
    }

    function prevTestimonial() {
        currentIndex = (currentIndex - 1 + testimonialCards.length) % testimonialCards.length;
        showTestimonial(currentIndex);
    }

    // Event Listeners for buttons
    nextBtn.addEventListener('click', nextTestimonial);
    prevBtn.addEventListener('click', prevTestimonial);

    // Event Listeners for dots (needs to be attached to new dots too if added dynamically)
    // For dynamically added dots, you might need to re-attach listeners or use event delegation
    // For this example, we'll re-attach after adding a new card in the form submit.
    function attachDotListeners() {
        dots.forEach(dot => {
            // Remove previous listeners to avoid duplicates if re-attaching
            dot.removeEventListener('click', handleDotClick);
            dot.addEventListener('click', handleDotClick);
        });
    }

    function handleDotClick() {
        const slideIndex = parseInt(this.dataset.slide);
        currentIndex = slideIndex;
        showTestimonial(currentIndex);
    }


    // Initial display
    showTestimonial(currentIndex);
    attachDotListeners(); // Attach listeners initially

    // Auto-slide functionality
    function startAutoSlide() {
        clearInterval(autoSlideInterval); // Clear any existing interval
        autoSlideInterval = setInterval(nextTestimonial, 5000); // Change every 5 seconds
    }

    function stopAutoSlide() {
        clearInterval(autoSlideInterval);
    }

    startAutoSlide(); // Start auto-slide when page loads

    // Pause auto-slide on hover
    const sliderContainer = document.querySelector('.slider-container');
    sliderContainer.addEventListener('mouseenter', stopAutoSlide);
    sliderContainer.addEventListener('mouseleave', startAutoSlide);
});