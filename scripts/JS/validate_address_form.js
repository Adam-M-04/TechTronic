const form = document.getElementById('address_form')
const state_input = document.getElementById('state')

form.onsubmit = (event)=>{
    event.preventDefault()
    validate()
}

function validate()
{
    if(states_array.includes(state_input.value))
    {
        form.submit()
    }
    else
    {
        state_input.classList.add('is-invalid')
    }
}