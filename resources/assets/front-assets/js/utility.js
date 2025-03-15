// Dynamically load components (navbar, footer, offcanvas)
let basePath = window.location.pathname.includes("/pages/") ? "../" : "./";

const loadComponents = (id, fileName, callback) => {
    fetch(basePath + fileName)
        .then((response) => {
            if (!response.ok) throw new Error(`Failed to load: ${fileName}`);
            return response.text();
        })
        .then((data) => {
            document.getElementById(id).innerHTML = data;
            if (callback) callback();
        })
        .catch((err) => {
            console.error("Loading failed: " + fileName, err);
            document.getElementById(
                id,
            ).innerHTML = `<p>Error loading ${fileName}</p>`;
        });
};

// Load components on DOMContentLoaded
document.addEventListener("DOMContentLoaded", async () => {
    // Load Navbar First
    await loadComponents("header", "components/navbar.html", () => {
        highlightActiveLink(); // Ensure navbar links are highlighted

        // Wait for navbar to be fully loaded before loading carts
        setTimeout(() => {
            if (window.innerWidth < 992) {
                console.log("Loading mobile cart...");
                loadComponents("mobileCartOffcanvas", "pages/cart.html");
            } else {
                console.log("Loading desktop cart...");
                loadComponents("desktopCartOffcanvas", "pages/cart.html");
            }
        }, 100); // Small delay to ensure DOM updates
    });

    // Load Footer
    await loadComponents("footer", "components/footer.html");
});




// Highlight the active navigation link based on the current page
const highlightActiveLink = () => {
    let currentPage = window.location.pathname.split("/").filter(Boolean).pop();
    const navLinks = document.querySelectorAll("nav ul li a");

    navLinks.forEach((link) => {
        let pageLink = link
            .getAttribute("href")
            .split("/")
            .filter(Boolean)
            .pop();
        if (pageLink === currentPage) {
            link.classList.add("active");
        } else {
            link.classList.remove("active");
        }
    });
};
