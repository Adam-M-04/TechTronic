<?php

    $user_address = $conn->get_data(
        "SELECT a.*, s.state_name, CONCAT(u.first_name, ' ', u.last_name) as name 
                    FROM users u JOIN address a USING (address_id) JOIN us_states s USING (state_id)
                    WHERE user_id = {$_SESSION['user_id']}"
    );

    if($user_address != [])
    {
        $user_address = $user_address[0];
        echo "<h4>$user_address->name</h4>
                <p>$user_address->phone_number</p>
                <p>$user_address->street</p>
                <p>$user_address->city, $user_address->state_name, $user_address->zip</p>
                <a href='/TechTronic/settings.php?c=address' target='_blank'>
                    <img src='/TechTronic/images/edit-icon.svg' alt='edit' id='edit_address'
                        data-bs-toggle='tooltip' data-bs-placement='left' title='Edit your address'>
                </a>";
        echo "<script id='set_address_state'>
                const is_set_address = true
                const address_tooltip = new bootstrap.Tooltip(document.getElementById('edit_address'))
                document.getElementById('set_address_state').remove()
              </script>";
    }
    else
    {
        echo "<a href='/TechTronic/settings.php?c=address' target='_blank'>
                <button class='btn btn-lg btn-warning' style='margin-bottom: 10px;'>Add address</button>
              </a>
              <script id='set_address_state'>
                  const is_set_address = false
                  document.getElementById('set_address_state').remove()
              </script>";
    }
