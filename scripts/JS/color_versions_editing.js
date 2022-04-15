function edit_color_version(cv_id)
{
    event.preventDefault()
    let form = new FormData(document.getElementById(`edit_form_` + cv_id))
    let error = validate_cv(form)

    if(!error)
    {
        document.getElementById(`edit_form_` + cv_id).submit()
    }
    else
    {
        DisplayError(error)
    }
}

function add_color_version()
{
    event.preventDefault()
    let form = new FormData(document.getElementById(`add_cv`))
    let error = validate_cv(form)

    if(!error)
    {
        document.getElementById(`add_cv`).submit()
    }
    else
    {
        DisplayError(error)
    }
}

function validate_cv(form)
{
    if(form.get('color').length == 0) return "Color input cannot be void"
    if(form.get('amount') < 0 || form.get('amount') == '') return "Amount cannot be negative"
    if(parseFloat(form.get('price')) <= 0 || form.get('price') == '') return "Price must be greater than $0"
    if(parseFloat(form.get('discount_price')) <= 0) return "Discount price must be greater than $0"
    if(parseFloat(form.get('price')) <= parseFloat(form.get('discount_price')) && form.get('discount_price') != '') return "Discount price must be lower than normal price"
    return false
}
