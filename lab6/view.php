<?php
    $limit = 5;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    $offset = ($page - 1) * $limit;

    if (isset($_GET['o'])){
        $sql = 'SELECT * FROM `peoples` ORDER BY `'.$_GET['o'].'` LIMIT '.$limit.' OFFSET '.$offset;
    } else {
        $sql = 'SELECT * FROM `peoples` LIMIT '.$limit.' OFFSET '.$offset;
    }

    $res = mysqli_query($connect, $sql);

    if (mysqli_errno($connect)) {
        print_r(mysqli_stmt_error($connect));
    }

    $total_records = mysqli_num_rows(mysqli_query($connect, 'SELECT COUNT(*) FROM `peoples`'));

    $total_pages = ceil($total_records / $limit);

    if ($total_records >= $limit) {
        echo '<div class="pagination">';
        if ($page > 1) {
            echo '<a href="?page='.($page - 1).'">&laquo; Previous</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo '<span class="current">'.$i.'</span>';
            } else {
                echo '<a href="?page='.$i.'">'.$i.'</a>';
            }
        }
        if ($page < $total_pages) {
            echo '<a href="?page='.($page + 1).'">Next &raquo;</a>';
        }
        echo '</div>';
    }
?>


<table class="table">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">FirstName</th>
            <th scope="col">Name</th>
            <th scope="col">Lastname</th>
            <th scope="col">Gender</th>
            <th scope="col">Date</th>
            <th scope="col">Phone</th>
            <th scope="col">Email</th>
            <th scope="col">Adress</th>
            <th scope="col">Comment</th>
        </tr>
    </thead>
    <tbody>
    <?php while($row = mysqli_fetch_assoc($res)):?>
        <tr>
            <th scope="row"><?=$row['id'];?></th>
            <td><?=$row['firstname'];?></td>
            <td><?=$row['name'];?></td>
            <td><?=$row['lastname'];?></td>
            <td><?=$row['gender'];?></td>
            <td><?=$row['date'];?></td>
            <td><?=$row['phone'];?></td>
            <td><?=$row['email'];?></td>
            <td><?=$row['adress'];?></td>
            <td><?=$row['comment'];?></td>
        </tr>
        <?php endwhile;?>
    </tbody>
</table>