function load_specification()
{
    document.getElementById("specification").innerHTML = loading_img

    let request = new XMLHttpRequest();
    request.open("POST", "/TechTronic/scripts/page_content/get_product_specification_admin.php?id=" + product_id);
    request.onload = function ()
    {
        document.getElementById("specification").innerHTML = request.responseText
    }
    request.send();
}

function update_specification(sp_id)
{
    if(document.getElementById('sn_' + sp_id) == null || document.getElementById('sv_' + sp_id) == null)
    {
        DisplayError()
        return
    }

    let sp_name = document.getElementById('sn_' + sp_id).value
    let sp_value = document.getElementById('sv_' + sp_id).value

    if(sp_name == '' || sp_value == '')
    {
        DisplayError("Values cannot be empty")
        return
    }

    let formdata = new FormData()
    formdata.append('id', sp_id)
    formdata.append('specification_name', sp_name)
    formdata.append('specification_value', sp_value)

    let request = new XMLHttpRequest();
    request.open("POST", "/TechTronic/scripts/update_specification.php");
    request.onload = function ()
    {
        if(request.responseText)
        {
            DisplayError()
        }
        load_specification()
    }
    request.send(formdata);
}

function add_specification(product_id)
{
    if(document.getElementById('sn_new') == null || document.getElementById('sv_new') == null)
    {
        DisplayError()
        return
    }

    let sp_name = document.getElementById('sn_new').value
    let sp_value = document.getElementById('sv_new').value

    if(sp_name == '' || sp_value == '')
    {
        DisplayError("Values cannot be empty")
        return
    }

    let formdata = new FormData()
    formdata.append('product_id', product_id)
    formdata.append('specification_name', sp_name)
    formdata.append('specification_value', sp_value)

    let request = new XMLHttpRequest();
    request.open("POST", "/TechTronic/scripts/add_specification.php");
    request.onload = function ()
    {
        if(request.responseText)
        {
            DisplayError()
        }
        load_specification()
    }
    request.send(formdata);
}

function delete_specification(sp_id)
{
    let request = new XMLHttpRequest();
    request.open("POST", "/TechTronic/scripts/delete_specification.php?id=" + sp_id);
    request.onload = function ()
    {
        if(request.responseText)
        {
            DisplayError()
        }
        load_specification()
    }
    request.send();
}
