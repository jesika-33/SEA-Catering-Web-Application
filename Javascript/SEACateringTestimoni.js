document.addEventListener('DOMContentLoaded', function() {
  // Testimonial Form Submission Logic
  const form = document.getElementById('new-testimonial');
  form.addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent default form submission

    const name = form.name.value.trim();
    const msg = form.message.value.trim();
    const satisfaction = form.satisfaction.value; // Get satisfaction rating

    if (!name || !msg) {
      alert('Please fill in both your name and testimonial!');
      return;
    }

    // --- Optional : data can be send to a server ---
    // Eg. fetch('/api/submit-testimonial', { method: 'POST', body: JSON.stringify({ name, msg, satisfaction }) });
    console.log('New Testimonial Submitted:');
    console.log(`Name: ${name}`);
    console.log(`Testimonial: ${msg}`);
    console.log(`Satisfaction: ${satisfaction}/100`);
    alert('Thank you for your testimonial! We appreciate your feedback.');

    // This is a simple client-side addition and won't persist if the page reloads.        
    const newCard = document.createElement('div');
    newCard.classList.add('testimonial-card');
    // Default profile picture using anonymous profile
    newCard.innerHTML = `
    <img src="../Images/anonymous.jpg" alt="${name}" class="testimonial-avatar">
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

  // Event Listeners for dots 
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
    autoSlideInterval = setInterval(nextTestimonial, 1000); // Change every 5 seconds
  }

  function stopAutoSlide() {
    clearInterval(autoSlideInterval);
  }

  startAutoSlide(); // Start auto-slide when page loads (Initial)

  // Pause auto-slide on hover
  const sliderContainer = document.querySelector('.slider-container');
  sliderContainer.addEventListener('mouseenter', stopAutoSlide);
  sliderContainer.addEventListener('mouseleave', startAutoSlide);
});
