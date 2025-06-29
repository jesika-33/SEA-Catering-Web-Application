// Data for meal plans (can be fetched from an API in a real application)
        const mealPlansData = {
            diet: {
                name: "Diet Plan",
                price: "Rp30.000,00 per meal",
                description: "Balanced and calorie-controlled meals to support your weight management goals.",
                details: "Includes expertly portioned meals focusing on lean proteins, fiber-rich vegetables, and complex carbohydrates to help you achieve and maintain a healthy weight. Customization options available for specific dietary needs.",
                image: "Images/diet meal.jpg"
            },
            protein: {
                name: "Protein Plan",
                price: "Rp40.000,00 per meal",
                description: "High-protein meals designed for muscle growth, repair, and sustained energy.",
                details: "Packed with premium protein sources like chicken breast, lean beef, and fish, alongside complex carbs and healthy fats. Ideal for fitness enthusiasts, athletes, or anyone looking to increase protein intake for satiety and muscle support.",
                image: "Images/protein.webp"
            },
            royal: {
                name: "Royal Plan",
                price: "Rp60.000,00 per meal",
                description: "Premium gourmet meals crafted with exquisite ingredients for a luxurious dining experience.",
                details: "Indulge in a culinary journey with our Royal Plan, featuring upscale ingredients, sophisticated flavor profiles, and artfully prepared dishes. Experience restaurant-quality meals delivered right to your door, perfect for special occasions or everyday luxury.",
                image: "Images/royal.webp"
            }
        };

        // Get elements
        const planModal = document.getElementById('planModal');
        const modalCloseBtn = document.querySelector('.modal-close-btn');
        const seeDetailsButtons = document.querySelectorAll('.see-details-btn');

        const modalPlanName = document.getElementById('modal-plan-name');
        const modalPlanPrice = document.getElementById('modal-plan-price');
        const modalPlanDescription = document.getElementById('modal-plan-description');
        const modalPlanDetails = document.getElementById('modal-plan-details');

        // Function to open the modal
        function openModal(planId) {
            const plan = mealPlansData[planId];
            if (plan) {
                modalPlanName.textContent = plan.name;
                modalPlanPrice.textContent = plan.price;
                modalPlanDescription.textContent = plan.description;
                modalPlanDetails.textContent = plan.details;
                planModal.style.display = 'flex'; // Show the modal
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
            }
        }

        // Function to close the modal
        function closeModal() {
            planModal.style.display = 'none'; // Hide the modal
            document.body.style.overflow = ''; // Restore background scrolling
        }

        // Add event listeners to "See More Details" buttons
        seeDetailsButtons.forEach(button => {
            button.addEventListener('click', () => {
                const planId = button.dataset.planId;
                openModal(planId);
            });
        });

        // Event listener for closing the modal (button click)
        modalCloseBtn.addEventListener('click', closeModal);

        // Event listener for closing the modal (clicking outside content)
        planModal.addEventListener('click', (event) => {
            if (event.target === planModal) {
                closeModal();
            }
        });