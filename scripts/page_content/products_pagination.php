<?php
    $starting_page = 1;
    if($page == $last_page)
    {
        $starting_page = max(1, $page - 2);
    }
    elseif($page > 1)
    {
        $starting_page = $page - 1;
    }

    $page_items = "";
    for ($i = $starting_page; $i < $starting_page + 3 and $i <= $last_page; ++$i)
    {
        $is_active = $i == $page ? ' active' : '';
        $page_items .= "<li class='page-item$is_active'><a class='page-link' href='$pagination_link&page=$i'>$i</a></li>";
    }
?>

<nav aria-label="Page navigation example">
    <ul class="pagination pagination-lg justify-content-center">
        <li class="page-item<?php if($page-1<1)echo ' disabled'; ?>">
            <a class="page-link" href="<?php echo $pagination_link.'&page=1'; ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <?php echo $page_items; ?>
        <li class="page-item<?php if($page+1>$last_page)echo ' disabled'; ?>">
            <a class="page-link" href="<?php echo $pagination_link.'&page='.$last_page; ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>
<h5><?php echo $result_count; ?> product<?php if($result_count>1)echo 's'; ?>, <?php echo $last_page; ?> page<?php if($last_page>1)echo 's'; ?></h5>
