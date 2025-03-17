let displayImg = document.getElementById("displayImg");
let paginationImg = document.querySelectorAll(".pagination-img");

paginationImg.forEach((img) => {
    img.onclick = () => {
        displayImg.classList.add("fade");
        setTimeout(() => {
            displayImg.src = img.src;
            displayImg.classList.remove("fade");
        }, 300);
    };
});

// Increment and Decrement Quantity Handling
const increment = document.getElementById("increment");
const decrement = document.getElementById("decrement");
const quantity = document.getElementById("quantity");

let count = 1;
quantity.innerText = count;
increment.addEventListener("click", () => {
    count++;
    quantity.innerText = count;
});
decrement.addEventListener("click", () => {
    if (count > 1) {
        count--;
        quantity.innerText = count;
    }
});

// Add to Cart functionality
$(document).ready(function () {
    $('#addToCartMain').click(function () {
        // Get the selected size, color, and quantity
        let size = $('input[name="size"]:checked').val() || null; // Get selected size
        let color = $('input[name="color"]:checked').val() || null; // Get selected color
        let quantity = $('#quantity').text() || null; // Get the quantity from the displayed value (not from the input)

        // Call AddToCart function with selected values
        AddToCart(this, quantity, color, size); // Pass `this` to get the button's data-url

        // reset the quantity to 1, reset count val
        count = 1;
        $('#quantity').text(count);

        // reset the selected size and color
        $('input[name="size"]').prop('checked', false);
        $('input[name="color"]').prop('checked', false);
    });
});