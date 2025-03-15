// import { addToCart } from "./cart.js";

const displayItems = () => {
    const ProductsData = [
        {
            id: 1,
            productName: "Wireless Earbuds",
            category: "Electronics",
            price: 300,
            description:
                "Compact and ergonomic earbuds with superior sound quality and noise cancellation.",
            brandName: "SoundTech",
            productImg:
                "https://images.unsplash.com/photo-1603694681044-e71c5993d6cd?w=600&auto=format&fit=crop&q=60",
        },
        {
            id: 2,
            productName: "Running Shoes",
            category: "Footwear",
            price: 540,
            description:
                "Lightweight running shoes with breathable material and comfortable cushioning.",
            brandName: "StridePro",
            productImg:
                "https://images.unsplash.com/photo-1620856902651-ce18d6d31d42?w=600&auto=format&fit=crop&q=60",
        },
        {
            id: 3,
            productName: "Smartwatch",
            category: "Wearables",
            price: 680,
            description:
                "Feature-packed smartwatch with fitness tracking, notifications, and long battery life.",
            brandName: "TechGear",
            productImg:
                "https://plus.unsplash.com/premium_photo-1683120889995-b6a309252981?w=600&auto=format&fit=crop&q=60",
        },
        {
            id: 4,
            productName: "Gaming Laptop",
            category: "Computers",
            price: 340,
            description:
                "High-performance laptop with powerful graphics card, fast processor, and RGB keyboard.",
            brandName: "GameCore",
            productImg:
                "https://plus.unsplash.com/premium_photo-1661304671477-37c77d0c6930?w=600&auto=format&fit=crop&q=60",
        },
        {
            id: 5,
            productName: "Blender",
            category: "Home Appliances",
            price: 700,
            description:
                "Efficient blender with multiple speed settings, ideal for smoothies and soups.",
            brandName: "KitchenAid",
            productImg:
                "https://plus.unsplash.com/premium_photo-1683121716061-3faddf4dc504?w=600&auto=format&fit=crop&q=60",
        },
        {
            id: 6,
            productName: "Smart TV",
            category: "Electronics",
            price: 1200,
            description:
                "Ultra HD smart TV with built-in streaming apps and voice control.",
            brandName: "VisionView",
            productImg:
                "https://images.unsplash.com/photo-1604594849809-d4e05679d4b0?w=600&auto=format&fit=crop&q=60",
        },
        {
            id: 7,
            productName: "Yoga Mat",
            category: "Fitness",
            price: 50,
            description:
                "Non-slip yoga mat with durable material and easy-to-clean surface.",
            brandName: "FlexFit",
            productImg:
                "https://images.unsplash.com/photo-1599058917760-d1819ac44d1e?w=600&auto=format&fit=crop&q=60",
        },
        {
            id: 8,
            productName: "Coffee Maker",
            category: "Home Appliances",
            price: 200,
            description:
                "Automatic coffee maker with programmable settings and thermal carafe.",
            brandName: "BrewMaster",
            productImg:
                "https://images.unsplash.com/photo-1513896727217-8b6f5b060202?w=600&auto=format&fit=crop&q=60",
        },
        {
            id: 9,
            productName: "Fitness Tracker",
            category: "Wearables",
            price: 150,
            description:
                "Track your steps, heart rate, and calories with this lightweight tracker.",
            brandName: "TrackFit",
            productImg:
                "https://images.unsplash.com/photo-1565078513764-16e8c8c8e034?w=600&auto=format&fit=crop&q=60",
        },
        {
            id: 10,
            productName: "Office Chair",
            category: "Furniture",
            price: 400,
            description:
                "Ergonomic office chair with lumbar support and adjustable height.",
            brandName: "ComfortWork",
            productImg:
                "https://images.unsplash.com/photo-1519566335946-7d7a7a1e5f3b?w=600&auto=format&fit=crop&q=60",
        },
    ];

    const categoryContainer = document.getElementById("categoryContainer");
    const productList = document.getElementById("productList");

    const displayProducts = (products) => {
        productList.innerHTML = "";
        products.forEach((product) => {
            const productCard = document.createElement("div");
            productCard.classList.add(
                "col-lg-3",
                "col-md-4",
                "col-sm-6",
                "col-12",
                "mb-4",
            );
            productCard.innerHTML = `
                <a href="../pages/product_detail.html?id=${
                    product.id
                }" class="text-decoration-none text-dark">
                <div class="card mb-2">
                    <div class="img-container">
                        <img src="${
                            product.productImg ? product.productImg : ""
                        }" class="w-100 card-img-top card-image" />
                    </div>
                    <div class="card-body">
                        <h5 class="card-title mb-1 text-center">${
                            product.productName
                        }</h5>
                        <h6 class="mb-1 text-center">$${product.price}</h6>
                    </div>
                    <div class="pb-3 px-2 btn-group border-0 d-flex justify-content-center text-muted">
                        <a href="../pages/product_detail.html?id=${
                            product.id
                        }" role="button" class="productDetail btn rounded-1 btn rounded-end-0 border border-end-0">Details</a>
                        <button role="button" class="AddToCart text-nowrap overflow-hidden btn border rounded-start-0 rounded-1">
                            <i class="fa-solid fa-cart-plus"></i> Add to Cart
                        </button>
                    </div>
                </div>
                </a>
            `;

            // Add event listener to the "Add to Cart" button
            const addToCartButton = productCard.querySelector(".AddToCart");
            addToCartButton.addEventListener("click", () => {
                addToCart(product.productName, product.price);
            });

            productList.appendChild(productCard);
        });
    };

    // Create all category buttons and handle category
    const displayPostsByCategory = () => {
        const categories = [
            "All",
            ...new Set(ProductsData.map((c) => c.category)),
        ];
        categories.forEach((category) => {
            const categoryButton = document.createElement("button");
            categoryButton.textContent = category;
            categoryButton.classList.add("category-btn");

            // Handle category
            categoryButton.addEventListener("click", () => {
                // Remove "active" class from all buttons
                document
                    .querySelectorAll(".category-btn")
                    .forEach((btn) => btn.classList.remove("active"));

                // Add "active" class to the clicked button
                categoryButton.classList.add("active");

                // Filter products by category
                const filteredProducts =
                    category === "All"
                        ? ProductsData
                        : ProductsData.filter(
                              (item) => item.category === category,
                          );
                displayProducts(filteredProducts);
            });

            categoryContainer.appendChild(categoryButton);
        });

        // Display all products initially
        displayProducts(ProductsData);
    };

    displayPostsByCategory();
};

displayItems();
