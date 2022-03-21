<?php
    $msg = false;
    if(isset($_GET['error']))
    {
        $msg = '<div class="container">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>An error occurred!</strong> Please try again.
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div></div>';
    }
    if(isset($_GET['added']))
    {
        $msg = '<div class="container">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                      Color version of the product added successfully!
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div></div>';
    }
    if(isset($_GET['deleted']))
    {
        $msg = '<div class="container">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                      Color version of the product deleted successfully!
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div></div>';
    }
    if(isset($_GET['edited']))
    {
        $msg = '<div class="container">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                          Edited successfully!
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div></div>';
    }
    if($msg)
    {
        echo $msg;
    }