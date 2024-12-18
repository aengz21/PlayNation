document.addEventListener('DOMContentLoaded', function() {
    const checkoutButton = document.querySelector('.button-checkout-disable');
    const inputs = document.querySelectorAll('input[type="text"], input[type="number"], textarea, select');

    function checkInputs() {
        let allFilled = true;
        inputs.forEach(input => {
            if (input.value.trim() === '') {
                allFilled = false;
            }
        });
        return allFilled;
    }

    function toggleCheckoutButton() {
        const allFilled = checkInputs();
        console.log('All inputs filled:', allFilled);
        checkoutButton.disabled = !allFilled;
    }

    // Initial check
    toggleCheckoutButton();

    // Add event listeners to all inputs
    inputs.forEach(input => {
        input.addEventListener('input', toggleCheckoutButton);
        input.addEventListener('change', toggleCheckoutButton);
    });
});
