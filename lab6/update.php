<?php
$db = require 'db.php';
$connect = mysqli_connect($db['host'], $db['username'], $db['password'], $db['database']);
if (mysqli_connect_errno()) print_r(mysqli_connect_error());

$selected_record_id = isset($_GET['id']) ? $_GET['id'] : null;

$sql_select_all = "SELECT `id`, `firstname`, `lastname` FROM `peoples` ORDER BY `lastname`, `firstname`";
$res = mysqli_query($connect, $sql_select_all);

echo "<div class='container mt-3'>";
while ($arr = mysqli_fetch_assoc($res)) {
    $selected_class = $selected_record_id == $arr['id'] ? 'selected' : '';
    echo '<a href="?p=update&id=' . $arr['id'] . '" class="' . $selected_class . '">' . $arr['firstname'] . ' ' . $arr['lastname'] . '</a><br>';
}
echo "</div>";

if ($selected_record_id !== null) {
    if (isset($_POST['edit_submit'])) {
        $id = $selected_record_id; 
        $new_firstname = $_POST['edit_firstname'];
        $new_lastname = $_POST['edit_lastname'];

        $update_query = "UPDATE `peoples` SET `firstname`='$new_firstname', `lastname`='$new_lastname' WHERE `id`='$id'";
        $result = mysqli_query($connect, $update_query);
        if ($result) {
            echo "<div class='alert alert-success' role='alert'>Успешное обновление данных!</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Была вызвана ошибка: " . mysqli_error($connect) . "</div>";
        }
    }

    $query = "SELECT * FROM peoples WHERE id = $selected_record_id";
    $result = mysqli_query($connect, $query);
    $record = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    echo "<div class='container mt-3'>";
    echo "<form action='' method='post'>";
    echo "<input type='hidden' name='edit_id' value='{$record['id']}'>";
    echo "<div class='form-group'>";
    echo "<label for='firstname'>First Name:</label>";
    echo "<input type='text' class='form-control' id='firstname' name='edit_firstname' value='{$record['firstname']}'>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='lastname'>Last Name:</label>";
    echo "<input type='text' class='form-control' id='lastname' name='edit_lastname' value='{$record['lastname']}'>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='gender'>Gender:</label>";
    echo "<select class='form-control' id='gender' name='gender'>";
    echo "<option " . ($record['gender'] == 'female' ? 'selected' : '') . ">female</option>";
    echo "<option " . ($record['gender'] == 'male' ? 'selected' : '') . ">male</option>";
    echo "</select>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='date'>Date:</label>";
    echo "<input type='date' class='form-control' id='date' name='date' value='{$record['date']}'>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='phone'>Phone:</label>";
    echo "<input type='tel' class='form-control' id='phone' name='phone' value='{$record['phone']}'>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='email'>Email:</label>";
    echo "<input type='email' class='form-control' id='email' name='email' value='{$record['email']}'>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='address'>Address:</label>";
    echo "<textarea class='form-control' id='address' name='adress'>{$record['adress']}</textarea>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='comment'>Comment:</label>";
    echo "<textarea class='form-control' id='comment' name='comment'>{$record['comment']}</textarea>";
    echo "</div>";
    echo "<button type='submit' class='btn btn-primary mb-3' name='edit_submit'>Обновить</button>";
    echo "</form>";
    echo "</div>";
}
?>
