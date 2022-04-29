function reset_form(form_id)
{
    event.preventDefault()
    for(let input of
        document.querySelectorAll(`#${form_id} input[type='text'], #${form_id} input[type='number'], #${form_id} input[type='date']`)
        ) input.value = ''
    for(let select of document.querySelectorAll(`#${form_id} select`)) select.selectedIndex = 0
    for(let checkbox of document.querySelectorAll(`#${form_id} input[type='checkbox']`)) checkbox.checked = false
}