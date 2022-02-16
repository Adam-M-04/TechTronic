const login_button = document.getElementById("login_button")

function login()
{
    let email_input = document.getElementById("email_login")
    let password_input = document.getElementById("password_login")

    if(email_input.value.length === 0)
    {
        email_input.classList.add("is-invalid")
        return
    }
    else email_input.classList.remove("is-invalid")
    if(password_input.value.length === 0)
    {
        password_input.classList.add("is-invalid")
        return
    }
    else password_input.classList.remove("is-invalid")
    login_button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span>'
    login_button.setAttribute("disabled", "true")

    let data = new FormData()
    data.append("email", email_input.value)
    data.append("password", password_input.value)
    const xmlHttp  = new XMLHttpRequest()
    xmlHttp.onreadystatechange = function() {
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
        {
            if(xmlHttp.responseText === "1")
            {
                location.reload()
            }
            else
            {
                document.getElementById("unsuccessful_login_message").style.display = "block"
                login_button.innerHTML = "Login"
                login_button.removeAttribute("disabled")
            }
        }
    }
    xmlHttp.open("post", "/TechTronic/scripts/login.php")
    xmlHttp.send(data)
}

function submit_by_enter(e)
{
    if (e.key === 'Enter') {
        login()
    }
}
