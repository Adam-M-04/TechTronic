const email_popup = new bootstrap.Modal(document.getElementById("email_alert"))

function check_if_email_exist(email)
{
    let data = new FormData()
    data.append("email", email)
    const xmlHttp  = new XMLHttpRequest()
    xmlHttp.onreadystatechange = function() {
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
        {
            if(xmlHttp.responseText === "true") document.getElementById('form').submit();
            else email_popup.show()
        }
    }
    xmlHttp.open("post", "/TechTronic/scripts/check_if_email_exist.php")
    xmlHttp.send(data)
}

document.getElementById('form').onsubmit = (event)=>
{
    let input2 = document.getElementById("password_2")
    event.preventDefault();
    if(document.getElementById("password_1").value === input2.value)
    {
        check_if_email_exist(document.getElementById("email").value)
    }
    else
    {
        input2.classList.add("is-invalid")
        input2.onchange = ()=>{
            if(document.getElementById("password_1").value === input2.value)
            {
                input2.classList.remove("is-invalid")
                input2.onchange = null
            }
        }
    }
}
