const list_elements = document.querySelectorAll('[product_name]')

function filter_products(query)
{
    query = query.toLowerCase()
    for(let li of list_elements)
    {
        li.classList.remove('d-flex')
        li.classList.remove('d-none')
        if(li.getAttribute('product_name').toLowerCase().includes(query))
        {
            li.classList.add('d-flex')
        }
        else
        {
            li.classList.add('d-none')
        }
    }
}

filter_products(document.getElementById('search_input').value)