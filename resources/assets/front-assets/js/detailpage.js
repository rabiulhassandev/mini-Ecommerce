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

//increment or decriment quantity of product

const increment = document.getElementById("increment");
const decrement = document.getElementById("decrement");
const quantity = document.getElementById("quantity");
const addToCart = document.getElementById("addToCartMain");

// console.log(increment, decrement, quantity, addToCart);
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
addToCart.addEventListener("click", () => {
    alert("Hey Developer! you have to implement this feature.");
    // addToCart(productName, price, productImg);
});
