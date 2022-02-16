function remove_from_cart(id)
{
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = () => {location.reload()}
    xmlhttp.open("GET", "/TechTronic/scripts/remove_from_cart.php?cv_id=" + id);
    xmlhttp.send();
}

function update_amount_in_cart(id, new_amount)
{
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = () => {location.reload()}
    xmlhttp.open("GET", "/TechTronic/scripts/update_amount_in_cart.php?cv_id=" + id + "&amount=" + new_amount);
    xmlhttp.send();
}
