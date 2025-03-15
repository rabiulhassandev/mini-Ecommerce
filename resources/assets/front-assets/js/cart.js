// Initialize cart functionality
const initCart = () => {
    let cart = JSON.parse(localStorage.getItem("cart")) || []; // Get cart data from localStorage
    const ShoppingBagCounters = document.querySelectorAll(".count-item");
    const cartDivs = document.querySelectorAll(".addedProducts");
    const subtotalElements = document.querySelectorAll(".subTotal");
    const totalElements = document.querySelectorAll(".total");

    // If cart elements are missing, exit
    if (!cartDivs.length) {
        console.warn("Cart elements not found, waiting...");
        return;
    }

    // Function to update cart counter
    const updateCartCounter = () => {
        let totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        ShoppingBagCounters.forEach((el) => (el.textContent = totalItems));
    };

    // Function to save cart to localStorage
    const saveCartToLocalStorage = () => {
        localStorage.setItem("cart", JSON.stringify(cart));
    };

    // Function to calculate total price
    const calculatePrice = () => {
        let subtotal = cart.reduce(
            (sum, item) => sum + item.price * item.quantity,
            0,
        );
        let total = subtotal; // Add shipping/discount if needed

        subtotalElements.forEach(
            (el) => (el.textContent = `${subtotal.toFixed(2)}`),
        );
        totalElements.forEach((el) => (el.textContent = `${total.toFixed(2)}`));
    };

    // Function to add an item to the cart
    const addToCart = (productName, price, productImg) => {
        const existItem = cart.find((i) => i.productName === productName);
        if (existItem) {
            existItem.quantity++;
        } else {
            cart.push({ productName, price, quantity: 1 });
        }
        updateCart();
    };

    // Function to update item quantity
    const updateQuantity = (index, change) => {
        if (index >= 0 && index < cart.length) {
            cart[index].quantity += change;
            if (cart[index].quantity <= 0) {
                removeFromCart(index);
            } else {
                updateCart();
            }
        }
    };

    // Function to remove an item from the cart
    const removeFromCart = (index) => {
        cart.splice(index, 1);
        updateCart();
    };

    // Function to update the cart UI
    const updateCart = () => {
        updateCartCounter();
        calculatePrice();
        saveCartToLocalStorage();

        cartDivs.forEach((cartDiv) => {
            cartDiv.innerHTML = ""; // Clear existing cart items

            if (cart.length === 0) {
                cartDiv.innerHTML = `<p class="text-center text-muted h2">Your cart is empty</p>`;
                return;
            }

            cart.forEach((item, index) => {
                const cartItem = document.createElement("div");
                cartItem.classList.add(
                    "cart-item",
                    "d-flex",
                    "align-items-center",
                    "bg-secondary-subtle",
                    "justify-content-between",
                    "mb-2",
                    "p-2",
                    "rounded-2",
                    "border",
                );

                cartItem.innerHTML = `
                    <span class="cart-item-name">${item.productName} ($${item.price})</span>
                    <div>
                        <div class="btn-group ms-1" role="group">
                            <button class="btn btn-sm btn-outline-secondary btn-decrease rounded-start">-</button>
                            <button class="btn border-secondary rounded-0">${item.quantity}</button>
                            <button class="btn btn-sm btn-outline-secondary btn-increase rounded-end">+</button>
                            <button class="ms-2 btn btn-sm text-danger btn-remove rounded"><i class="fa-solid fa-x"></i></button>
                        </div>
                    </div>
                `;

                // Event listeners for quantity and remove buttons
                cartItem
                    .querySelector(".btn-decrease")
                    .addEventListener("click", () => updateQuantity(index, -1));
                cartItem
                    .querySelector(".btn-increase")
                    .addEventListener("click", () => updateQuantity(index, 1));
                cartItem
                    .querySelector(".btn-remove")
                    .addEventListener("click", () => removeFromCart(index));

                cartDiv.appendChild(cartItem);
            });
        });
    };

    // Initialize cart UI
    updateCart();
    window.addToCart = addToCart;
};

// Observe changes in the cart offcanvas
const observeCartChanges = () => {
    const observer = new MutationObserver(() => {
        const cartDivs = document.querySelectorAll(".addedProducts");
        if (cartDivs.length) {
            observer.disconnect();
            initCart();
        }
    });

    observer.observe(document.body, { childList: true, subtree: true });
};

// Start observing cart changes when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
    observeCartChanges();
});
