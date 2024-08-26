<?php
session_start();
if (!$_SESSION['isAdmin']) {
    header("Location: login.php");
}
include('database.php');

// menu show mysql 
$sql = "SELECT * FROM `nav-menu`";
$menuConnect = $connectionDB->query($sql);

// data add php to mysql 
if (isset($_POST['add'])) {
    $menuAdd = $_POST['menuAdd'];
    $addMysql = "INSERT INTO `nav-menu`(`id`, `name`) VALUES (null,'$menuAdd')";
    if ($connectionDB->query($addMysql) === TRUE) {
        $_SESSION['AddSucc'] = true;
        $menuConnect = $connectionDB->query($sql);
    }
}

if (isset($_POST['delete'])) {
    $delItem = $_POST['delete'];
    $delItemSql = "DELETE FROM `nav-menu` WHERE id=$delItem";
    if ($connectionDB->query($delItemSql) === true) {
        $_SESSION['delSucc'] = true;
        $menuConnect = $connectionDB->query($sql);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Items Added/Delete</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div x-data="{ open: false }" class="flex h-screen">

        <!-- sidebar  -->
        <?php include('sidebar.php') ?>

        <!-- Main Content -->
        <main class="flex-1 p-6 md:ml-[100%-256px]">
            <div class="container mx-auto">
                <!-- #menu item added successfull show text -->
                <p class="pl-1 p-1 ">
                    <?php
                    if (isset($_SESSION['AddSucc'])) {
                        echo "Menu item added successfull";
                        // add successfull session is unset 
                        if (isset($_SESSION['AddSucc'])) {
                            unset($_SESSION['AddSucc']);
                        }
                    } elseif (isset($_SESSION['delSucc'])) {
                        echo "Menu item delete successfull";
                        // add successfull session is unset 
                        if (isset($_SESSION['delSucc'])) {
                            unset($_SESSION['delSucc']);
                        }
                    }
                    ?>
                </p>

                <!-- menu added button  -->
                <form action="" method="post" class="flex items-center mb-4">
                    <input type="text" name="menuAdd" placeholder="Enter menu item" class="w-full px-4 py-2 border border-gray-300 rounded-l focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <button name="add" class="bg-blue-500 text-white px-4 py-2 rounded-r hover:bg-blue-600">Add</button>
                </form>

                <!-- menu bar listed item show -->
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 bg-gray-200 border-b">Menu</th>
                            <th class="py-2 px-4 bg-gray-200 border-b">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($menuConnect->num_rows > 0) {
                            while ($row = $menuConnect->fetch_assoc()) { ?>
                                <tr>
                                    <td class="py-2 px-4 border-b text-center"><?php echo $row['name']; ?></td>
                                    <td class="py-2 px-4 border-b  text-center">
                                        <form action="" method="post">
                                            <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" type="submit" name="delete" value="<?php echo $row['id'];?>">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                        <?php  }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- AlpineJS (for dropdown functionality) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.2.3/dist/cdn.min.js" defer></script>
</body>

</html>