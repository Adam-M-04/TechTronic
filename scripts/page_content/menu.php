<?php
    if(isset($_SESSION["user_id"]) and isset($_SESSION["user_name"]))
    {
        # user logged in
        $user_name = strlen($_SESSION["user_name"]) > 20 ? substr($_SESSION["user_name"],0,20)."..." : $_SESSION["user_name"];
        $right_content = "<div class=\"text-end\">
            <div class=\"dropdown text-end\"><a href=\"#\" class=\"d-block link-light text-decoration-none
                dropdown-toggle\" id=\"dropdownUser1\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\" style='font-size: 20px;'>
                    <img src=\"/TechTronic/images/person-circle.svg\" alt=\"mdo\" width=\"36\" height=\"36\">
                    $user_name</a>
                    <ul class=\"dropdown-menu dropdown-menu-dark text-small\" aria-labelledby=\"dropdownUser1\">
                        <li><a class=\"dropdown-item\" href=\"/TechTronic/settings/details/\">Settings</a></li>
                        <li><a class=\"dropdown-item\" href=\"/TechTronic/your-orders/\">Orders</a></li>
                        <li><hr class=\"dropdown-divider\"></li>
                        <li><span class=\"dropdown-item\" onclick='log_out()' href='#' 
                            style='cursor: pointer;'>Sign out</span></li>
                    </ul>
            </div>
        </div>
        <div class=\"text-end\" style='margin-left: 20px;'>
            <a href=\"/TechTronic/cart/\" class=\"d-block link-light text-decoration-none\">
            <img src=\"/TechTronic/images/cart.svg\" style='width: 36px; height: 36px;'></a>
        </div>";
    }
    else
    {
        # user not logged in
        $right_content = "<div class=\"text-end\"><button data-bs-toggle=\"modal\" data-bs-target=\"#login_window\"
                            type=\"button\" class=\"btn btn-outline-light me-2\">Login</button><a href=\"/TechTronic/register/\"
                            ><button type=\"button\" class=\"btn btn-success\">Sign-up</button></a></div>";
        echo <<< login_window
            <div class="modal fade" id="login_window" tabindex="-1">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-body text-dark">
                            <h1 class="mb-3" id="header">Sign in</h1>
                            <div class="form-floating mb-3"  style="margin-top: 30px;">
                                <input type="email" class="form-control form-control-lg" name="email_login" id="email_login" 
                                    placeholder=" " maxlength="320" required onkeydown="submit_by_enter(event)">
                                <label for="email_login">Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control form-control-lg" name="password_login" id="password_login"
                                       placeholder=" " required onkeydown="submit_by_enter(event)">
                                <label for="password_login">Password</label>
                            </div>
                            <button class="btn btn-success" style="width: 100%; font-size: 20px;" onclick="login()" id="login_button">
                                Login
                            </button>
                            <div id="unsuccessful_login_message" style="display: none; margin-top: 15px; color: red;">
                                Invalid email adress or password
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="/TechTronic/scripts/JS/login_window.js"></script>
login_window;

    }

    echo <<< menu
        <script src="/TechTronic/scripts/JS/log_out_ajax.js"></script>
        <header class="p-3 bg-dark text-white" style="position: fixed;top:0px;width: 100%;z-index: 10;">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="/TechTronic" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                        <img src="/TechTronic/images/logo.png" width="150">
                    </a>
        
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="/TechTronic/categories/" class="nav-link px-2 text-white">Products</a></li>
                        <li><a href="#" class="nav-link px-2 text-white">Pricing</a></li>
                        <li><a href="#" class="nav-link px-2 text-white">FAQs</a></li>
                        <li><a href="#" class="nav-link px-2 text-white">About</a></li>
                    </ul>
        
                    <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                        <input type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">
                    </form>
                    $right_content
                </div>
            </div>
        </header>
menu;
