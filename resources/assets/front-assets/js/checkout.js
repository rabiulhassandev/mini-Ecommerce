$(document).ready(function () {
    $("#cart_form").submit(function (event) {
        event.preventDefault(); // Prevent default form submission

        let formData = $(this).serialize(); // Serialize form data

        $.ajax({
            url: $(this).attr("action"),
            type: "POST",
            data: formData,
            success: function (response) {
                if (response.success) {
                    // hide form
                    $("#cart_form").hide();

                    // show order confired area
                    $("#order_confirmed").show();

                    // update cart item count
                    CartItemCount()
                } else {
                    toastr.error(response.error || "An error occurred while confirming the order.");
                }
            },
            error: function (xhr) {
                toastr.error(xhr.responseJSON?.error || "An error occurred while confirming the order.");
            }
        });
    });
});
