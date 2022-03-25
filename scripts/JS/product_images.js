const loading_img = "<img src='/TechTronic/images/loading.svg' style='width: 180px;'>";
var gallery_modal = null
var selected_index = null
var selected_cv_id = null

function load_product_images(index, cv_id)
{
    document.getElementsByClassName("images-row")[index].innerHTML = loading_img

    let request = new XMLHttpRequest();
    request.open("POST", "/TechTronic/scripts/page_content/get_product_images.php?cv_id=" + cv_id+"&index="+index);
    request.onload = function ()
    {
        document.getElementsByClassName("images-row")[index].innerHTML = request.responseText
        get_images_gallery()
    }
    request.send();
}

function add_product_image(index, cv_id)
{
    clear_tooltips()
    clear_modals()
    if(gallery_modal != null) gallery_modal.hide()

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
            DisplayError('('+request.responseText+')')
        }
        load_product_images(index, cv_id);
    }
    request.send(formData);
}

function add_existing_product_image(filename)
{
    clear_tooltips()
    clear_modals()
    if(gallery_modal != null) gallery_modal.hide()

    let formData = new FormData();
    formData.append('cv_id', selected_cv_id);
    formData.append('filename', filename);

    let request = new XMLHttpRequest();
    request.open("POST", "/TechTronic/scripts/add_existing_product_image.php");
    request.onload = function ()
    {
        if(request.responseText)
        {
            DisplayError()
        }
        load_product_images(selected_index, selected_cv_id);
    }
    request.send(formData);
}

function delete_image(index, cv_id, filename, image_id)
{
    clear_tooltips()
    document.getElementsByClassName("images-row")[index].innerHTML = loading_img
    let formData = new FormData()
    formData.append("filename", filename)
    formData.append("image_id", image_id)

    let request = new XMLHttpRequest();
    request.open("POST", "/TechTronic/scripts/delete_product_image.php");
    request.onload = function ()
    {
        if(request.responseText)
        {
            DisplayError()
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
            DisplayError()
        }
        else load_product_images(index, cv_id);
    }
    request.send(formData);
}

function clear_tooltips()
{
    let tooltips = document.getElementsByClassName('tooltip')
    while (tooltips.length) tooltips[0].remove()
}

function initialize_tooltips()
{
    let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
}

function clear_modals()
{
    let backdrops = document.getElementsByClassName('modal-backdrop')
    while (backdrops.length) backdrops[0].remove()
}

function set_parameters(cv_id, index)
{
    selected_cv_id = cv_id
    selected_index = index
    document.getElementById(`upload_image_label`).setAttribute(`for`, `image_input_${cv_id}`)
}

function get_images_gallery()
{
    let request = new XMLHttpRequest()
    request.open("POST", "/TechTronic/scripts/page_content/images_from_gallery.php")
    request.onload = function ()
    {
        document.getElementById('gallery_modal_container').innerHTML = request.responseText
        gallery_modal = new bootstrap.Modal(document.getElementById('images_from_gallery'))

        initialize_tooltips()
    }
    request.send();
}

function DisplayError(msg = '')
{
    document.body.innerHTML = `<div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>An error occurred!</strong> ${msg}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div></div>` + document.body.innerHTML
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
