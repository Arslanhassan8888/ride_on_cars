/* Main JavaScript for Ride On Cars
*/
/* 1. Header scroll effect*/
window.addEventListener("scroll", function() {

    const header = document.querySelector(".site-header");

    if (window.scrollY > 0) {
        header.classList.add("scrolled");
    } else {
        header.classList.remove("scrolled");
    }

});

// Confirm delete
document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function (e) {
        if (!confirm("Are you sure you want to remove this item?")) {
            e.preventDefault();
        }
    });
});

// Button click animation
document.querySelectorAll('.qty a, .btn-delete').forEach(btn => {
    btn.addEventListener('click', function () {
        btn.style.transform = "scale(0.9)";
        setTimeout(() => {
            btn.style.transform = "scale(1)";
        }, 150);
    });
});

// Disable minus if qty = 1
document.querySelectorAll('.btn-decrease').forEach(btn => {
    const qty = parseInt(btn.dataset.qty);

    if (qty <= 1) {
        btn.style.opacity = "0.5";
        btn.style.pointerEvents = "none";
    }
});

// Update cart count in header

function updateCartCount(newCount) {
    const cart = document.getElementById("cart-count");
    if (cart) {
        cart.textContent = "Cart (" + newCount + ")";
    }
}

// Confirm delete (for reviews)
document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function (e) {
        if (!confirm("Are you sure you want to remove this item?")) {
            e.preventDefault();
        }
    });
});