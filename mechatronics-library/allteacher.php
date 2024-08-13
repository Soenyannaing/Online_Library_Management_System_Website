<?php
session_start();

# If the admin is logged in
if (
    isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])
) {

    # Database Connection File
    include "db_conn.php";

    # Teacher helper function
    include "php/func-teacher.php";
    $teachers = get_all_teachers($conn);
    $teacherpages = get_all_teacher_pages($conn);

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ADMIN</title>

        <!-- bootstrap 5 CDN-->
        <link rel="stylesheet" href="./bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css">
        <!-- bootstrap 5 Js bundle CDN-->
        <script src="./bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

        <link rel="stylesheet" href="css/admin.css">
        <link rel="stylesheet" href="css/navbar.css">
        <link rel="stylesheet" href="css/background.css">
    </head>

    <body>
    <?php if (isset($_GET['error'])) { ?>
                    <main class="alert">
                        <div class="alert_error" role="alert">
                            <?=htmlspecialchars($_GET['error']); ?>
                        </div>
                    </main>
                <?php } ?>
                <?php if (isset($_GET['success'])) { ?>
                    <main class="alert">
                        <div class="alert_success" role="alert">
                            <?=htmlspecialchars($_GET['success']); ?>
                        </div>
                    </main>
                <?php } ?>
                <?php if ($teachers == 0) { ?>
        <div class="no_data" 
                    role="alert">
                    <img src="img/no_data.jpg" >
                    <br>
                There is no teacher info in the database
        </div>
    <?php }else {?>
        <div class="table_teacher">
            <section  class="table_teacher_header">
                <h4>Teachers Information</h4>
                <a href="allteacher.php">See All</a>
            </section>
            <section  class="table_teacher_body">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Role</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $b = 0;
                        foreach ($teachers as $teacher) {
                            $b++;
                        ?>
                        <tr class="table_teacher_text">
                            <td><?=$b?></td>
                            <td class="table_text_profile">
                                <img src="uploads/profile/<?=$teacher['profile']?>">
                                <?=$teacher['name']?>
                            </td>
                            <td>
                                <?=$teacher['age']?>
                            </td>
                            <td>
                                <?=$teacher['role']?>
                            </td>
                            <td><?=$teacher['description']?></td>
                            <td class="edit_delete">
                                <a href="edit-teacher.php?id=<?=$teacher['id']?>" class="btn_edit">Edit</a>
                                <a href="php/delete-teacher.php?id=<?=$teacher['id']?>" class="btn_delete">Delete</a>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </section>
        </div>
    <?php }?>
    </body>

    </html>
<?php } else {
    header("Location: login.php");
    exit;
} ?>