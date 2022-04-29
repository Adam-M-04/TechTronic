function mouse_hover_handler()
{
    let caller = event.target
    if(event.type === "mouseenter")
    {
        caller.classList.add('list-group-item-dark')
        return
    }
    if(event.type === "mouseleave")
    {
        caller.classList.remove('list-group-item-dark')
    }
}