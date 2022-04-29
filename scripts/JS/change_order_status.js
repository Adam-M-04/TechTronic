document.body.innerHTML += `
    <div id="message_popup" class="toast bg-success text-white" role="alert"
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

function change_order_status(order_id ,status_id)
{
    let xmlhttp = new XMLHttpRequest();
    let formdata = new FormData()
    formdata.append('order_id', order_id)
    formdata.append('status_id', status_id)
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText.length == 0)
            {
                toast_message.innerText = "Order status changed successfully"
                toast_container.classList.remove('bg-danger')
                toast_container.classList.add('bg-success')
                toast.show()
                return
            }
        }
        toast_message.innerText = "An error occurred"
        toast_container.classList.remove('bg-success')
        toast_container.classList.add('bg-danger')
        toast.show()
    };
    xmlhttp.open("POST", "/TechTronic/scripts/change_order_status.php");
    xmlhttp.send(formdata);
}