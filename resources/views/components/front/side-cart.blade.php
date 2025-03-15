<div class="offcanvas-header">
    <h4 class="offcanvas-title text-primary-emphasis" id="offcanvasWithBothOptionsLabel">Your Cart</h4>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
 </div>
 <div class="offcanvas-body addedProducts"></div>
 <div class="offcanvas-footer bg-info-subtle border p-2 rounded-3" id="cartAmount">
    <p class="text-muted fw-semibold">Subtotal : <span class="subTotal"></span>{{ setting('site.currency') }}</p>
    <p class="text-muted fw-bold">Total : <span class="total"></span>{{ setting('site.currency') }}</p>
    <a href="./checkout.html" id="checkoutBtn" class="btn w-100 mb-3">Proced to checkout</a>
 </div>