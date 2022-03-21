const loading_img = "<img src='/TechTronic/images/loading.svg' style='width: 180px;'>"

function load_product_images(index, cv_id)
{
    document.getElementsByClassName("images-row")[index].innerHTML = loading_img

    let request = new XMLHttpRequest();
    request.open("POST", "/TechTronic/scripts/page_content/get_product_images.php?cv_id=" + cv_id+"&index="+index);
    request.onload = function ()
    {
        document.getElementsByClassName("images-row")[index].innerHTML = request.responseText

        let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    }
    request.send();
}

function add_product_image(index, cv_id)
{
    clear_tooltips()
    const file = document.getElementById('image_input_' + cv_id).files[0];
    let formData = new FormData();
    formData.append('image', file);
    formData.append('cv_id', cv_id);

    let request = new XMLHttpRequest();
    request.open("POST", "/TechTronic/scripts/add_product_image.php");
    request.onload = function ()
    {
        if(request.responseText)
        {
            document.body.innerHTML = `<div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>An error occurred!</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div></div>` + document.body.innerHTML
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        load_product_images(index, cv_id);
    }
    request.send(formData);
}

function delete_image(index, cv_id, filename)
{
    clear_tooltips()
    document.getElementsByClassName("images-row")[index].innerHTML = loading_img
    let formData = new FormData()
    formData.append("filename", filename)

    let request = new XMLHttpRequest();
    request.open("POST", "/TechTronic/scripts/delete_product_image.php");
    request.onload = function ()
    {
        if(request.responseText)
        {
            document.body.innerHTML = `<div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>An error occurred!</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div></div>` + document.body.innerHTML
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        else load_product_images(index, cv_id);
    }
    request.send(formData);
}

function select_main_image(index, cv_id, image_id)
{
    clear_tooltips()
    document.getElementsByClassName("images-row")[index].innerHTML = loading_img

    let formData = new FormData()
    formData.append("image_id", image_id)
    formData.append("cv_id", cv_id)
    let request = new XMLHttpRequest();
    request.open("POST", "/TechTronic/scripts/set_main_image.php");
    request.onload = function ()
    {
        if(request.responseText)
        {
            document.body.innerHTML = `<div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>An error occurred!</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div></div>` + document.body.innerHTML
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        else load_product_images(index, cv_id);
    }
    request.send(formData);
}

function clear_tooltips()
{
    for(let tooltip of document.getElementsByClassName('tooltip')) tooltip.remove()
}
