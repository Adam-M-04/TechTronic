document.body.innerHTML += `
    <div id="message_popup" class="toast bg-success" role="alert"
         aria-live="assertive" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; padding: 10px; z-index: 10 !important;">
        <div class="d-flex">
            <div class="toast-body" id="message_popup_text" style="font-size: 18px;"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
`

const toast_container = document.getElementById("message_popup")
const toast_message = document.getElementById("message_popup_text")
const toast = new bootstrap.Toast(toast_container)

function add_to_cart(id, count=1)
{
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            switch (xmlhttp.responseText)
            {
                case "1":
                    toast_message.innerHTML = "<a href='/TechTronic/cart/' style='text-decoration: none;' class='text-light'>" +
                        "Product added to your cart</a>"
                    toast_container.className = "toast bg-success text-white"
                    break;
                case "0":
                    toast_message.innerHTML = "Please login first"
                    toast_container.className = "toast bg-primary text-white"
                    break;
                case "-1":
                    toast_message.innerHTML = "Product is not available anymore"
                    toast_container.className = "toast bg-warning text-dark"
                    break;
                case "-2":
                    toast_message.innerHTML = "You have maximum available amount of this product in your cart"
                    toast_container.className = "toast bg-warning text-dark"
                    break;
                default:
                    toast_message.innerHTML = "An error occurred"
                    toast_container.className = "toast bg-danger text-white"
            }

            toast.show()
        }
    };
    xmlhttp.open("GET", "/TechTronic/scripts/add_to_cart.php?cv_id=" + id + "&count=" + count);
    xmlhttp.send();
}
