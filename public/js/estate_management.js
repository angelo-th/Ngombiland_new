// Example: Add JS functionalities later
// Could include filters, modal popups, confirmations, etc.
console.log("Property Management JS loaded");

// Optional: Confirmation before deleting a property
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        if(!confirm("Are you sure you want to delete this property?")) {
            e.preventDefault();
        }
    });
});
