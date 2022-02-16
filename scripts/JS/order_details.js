class address_manager {
    #delivery_to_store_id;
    #address_box = document.getElementById('address_box')
    #message_box = document.getElementById('message_box')
    #address_title = document.getElementById('address_title')
    #user_address = this.#address_box.innerHTML
    #shop_input;

    constructor(shop_input, delivery_to_store_id)
    {
        this.#shop_input = shop_input
        this.#delivery_to_store_id = delivery_to_store_id
    }

    delivery_change_handler(id, old_id)
    {
        if(id === this.#delivery_to_store_id)
        {
            this.#address_title.innerText = "Selected Shop"
            this.shop_select_button()
        }
        else
        {
            if(old_id === this.#delivery_to_store_id)
            {
                this.#address_title.innerText = "Your Address"
                this.#address_box.innerHTML = this.#user_address
            }
        }
    }

    shop_change_handler(id)
    {
        shops_modal.hide()
        if(parseInt(this.#shop_input.value) == id) return;

        this.#address_box.innerHTML = `<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>`
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = () => {
            if (xmlhttp.responseText == '-1')
            {
                this.#message_box.innerHTML = `<div class="alert alert-danger message" role="alert">Shop Not Found</div>`
                this.shop_select_button()
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
            else
            {
                this.#address_box.innerHTML = xmlhttp.responseText;
                this.#shop_input.value = id
            }
        };
        xmlhttp.open("GET", "/TechTronic/scripts/page_content/get_shop_address.php?id=" + id);
        xmlhttp.send();
    }

    remove_selected_shop()
    {
        this.shop_select_button()
        this.#shop_input.value = -1
    }

    shop_select_button()
    {
        this.#address_box.innerHTML = `<button type="button" class="btn btn-lg btn-warning" data-bs-toggle="modal" 
                    data-bs-target="#shops_modal" style='margin-bottom: 10px;'>Select</button>`
    }

}

class delivery_manager {
    #delivery_elements = document.querySelectorAll(".delivery-option")
    #order_price_element = document.getElementById("order-value")
    #nf = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' });
    #delivery_input;
    #order_value;
    #delivery_prices;

    constructor(order_value, delivery_prices, delivery_input, shop_input, delivery_to_store_id)
    {
        this.#delivery_input = delivery_input
        this.#order_value = order_value
        this.#delivery_prices = delivery_prices
        this.address_manager = new address_manager(shop_input, delivery_to_store_id)
    }

    change_delivery(id)
    {
        let old_id = parseInt(this.#delivery_input.value)
        if(old_id === id) return
        if(old_id >= 1 && old_id <= this.#delivery_elements.length) this.#delivery_elements[old_id-1].classList.remove("active")
        this.#delivery_input.value = id;
        this.#delivery_elements[id-1].classList.add("active")
        this.#order_price_element.innerText = this.#nf.format(this.#order_value + this.#delivery_prices[id-1])
        this.address_manager.delivery_change_handler(id, old_id)
    }
}

class payment_manager {
    #payment_elements = document.querySelectorAll(".payment-option")
    #payment_input;

    constructor(payment_input)
    {
        this.#payment_input = payment_input
    }

    change_payment(id)
    {
        let old_id = this.#payment_input.value
        if(old_id >= 1 && old_id <= this.#payment_elements.length) this.#payment_elements[old_id-1].classList.remove("active")
        this.#payment_input.value = id;
        this.#payment_elements[id-1].classList.add("active")
    }
}

class form_manager {
    #delivery_to_store_id = 4;
    #form = document.getElementById('order_form')
    #message_box = document.getElementById('message_box')

    constructor(order_value, delivery_prices)
    {
        this.delivery_manager = new delivery_manager(order_value, delivery_prices, this.#form.elements[1],
                this.#form.elements[3], this.#delivery_to_store_id);
        this.payment_manager = new payment_manager(this.#form.elements[2]);
        this.#form.onsubmit = (event)=>{this.check_form(event)}
    }

    check_form(event)
    {
        event.preventDefault()
        if(this.#form.elements[1].value == -1)
        {
            this.#message_box.innerHTML = `<div class="alert alert-danger message" role="alert">
                Select delivery method
            </div>`
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return;
        }
        if(this.#form.elements[3].value == -1 && this.#form.elements[1].value == this.#delivery_to_store_id)
        {
            this.#message_box.innerHTML = `<div class="alert alert-danger message" role="alert">
                Select shop
            </div>`
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return;
        }
        if(this.#form.elements[1].value != this.#delivery_to_store_id && !is_set_address)
        {
            this.#message_box.innerHTML = `<div class="alert alert-danger message" role="alert">
                Provide address for delivery
            </div>`
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return;
        }
        if(this.#form.elements[2].value == -1)
        {
            this.#message_box.innerHTML = `<div class="alert alert-danger message" role="alert">
                Select payment method
            </div>`
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return;
        }
        this.#form.submit()
    }
}
