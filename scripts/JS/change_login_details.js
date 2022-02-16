const change_email_button = document.getElementById(`change_email`)
const email_input = document.getElementById(`email`)
const new_password_input = document.getElementById(`new_password`)
const confirm_password_input = document.getElementById(`confirm_password2`)
const password_form = document.getElementById(`password_form`)

change_email_button.onclick = ()=>
{
    email_input.removeAttribute(`readonly`)
    email_input.classList.remove(`form-control-plaintext`)
    change_email_button.remove()
}

password_form.onsubmit = (event)=>
{
    event.preventDefault()
    if(new_password_input.value !== confirm_password_input.value)
    {
        new_password_input.classList.add('is-invalid')
        confirm_password_input.classList.add('is-invalid')
        return
    }
    password_form.submit()
}
