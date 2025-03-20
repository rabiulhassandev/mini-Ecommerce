// Function to update the cart item count
// Function to update the cart item count
function CartItemCount() {
    let url = $('#desktopCartButton').data('url');  // Get URL from the anchor tag
    var count = 0;

    $.ajax({
        url: url,
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
        },
        success: function (response) {
            count = response.count; // Get the cart count from the response
            $("#cartIconBox").text(count); // Update the cart icon count
        },
        error: function(xhr) {
            toastr.error("Error loading cart count.");
        }
    });

    return count;
}


// Trigger CartItemCount on page load
$(document).ready(function () {
    CartItemCount(); // Call the function on page load
});


// Function to Add Product to Cart
function AddToCart(button, quantity = 1, color = null, size = null) {
    let url = $(button).data('url'); // Get URL from the button's data attribute

    $.ajax({
        url: url,
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'), // Get CSRF token dynamically
            color: color,
            size: size,
            quantity: quantity
        },
        success: function (response) {
            toastr.success(response.success); // Display success message
            CartItemCount(); // Update the cart item count
        },
        error: function (xhr) {
            toastr.error(xhr.responseJSON?.error || "An error occurred while adding the product.");
        }
    });
}