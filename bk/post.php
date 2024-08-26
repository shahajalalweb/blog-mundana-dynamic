<?php
session_start();
if (!$_SESSION['isAdmin']) {
    header("Location: login.php");
}

include('database.php');

// show post mysql 
$sqlPost = "SELECT * FROM `blog-post`";
$postConnect = $connectionDB->query($sqlPost);

// Insert post 
if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $post = $_POST['post'];
    $buttonLink = $_POST['button-link'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $postInsert = "INSERT INTO `blog-post`(`id`, `title`, `paragraph`, `button-link`, `img-link`) 
                           VALUES (null, '$title', '$post', '$buttonLink', '$target_file')";
            if ($connectionDB->query($postInsert) === true) {
                $_SESSION['postAddSucc'] = true;
                $postConnect = $connectionDB->query($sqlPost);
            } else {
                echo "Error: " . $connectionDB->error;
            }
        } else {
            echo "Failed to upload image.";
        }
    } else {
        echo "No file was uploaded or there was an upload error.";
    }
}

// post delete sql
if (isset($_POST['delete'])) {
    $itemDelete = $_POST['delete'];
    $itemDeleteSql = "DELETE FROM `blog-post` WHERE id = $itemDelete";
    if ($connectionDB->query($itemDeleteSql) === true) {
        $_SESSION['delsuc'] = true;
        $postConnect = $connectionDB->query($sqlPost);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mundana | Post</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div x-data="{ open: false }" class="flex h-screen">
        <!-- sidebar include  -->
        <?php include('sidebar.php') ?>

        <!-- Main Content -->
        <main class="flex-1 p-6 md:ml-[100%-256px]">
            <div class="container mx-auto">
                <!-- #post added successfull massage -->
                <p class="pl-1 p-1 ">
                    <?php
                    if (isset($_SESSION['postAddSucc'])) {
                        echo "Post added successfull";
                        // add successfull session is unset 
                        if (isset($_SESSION['postAddSucc'])) {
                            unset($_SESSION['postAddSucc']);
                        }
                    } elseif (isset($_SESSION['delSucc'])) {
                        echo "Menu item delete successfull";
                        // add successfull session is unset 
                        if (isset($_SESSION['delSucc'])) {
                            unset($_SESSION['delSucc']);
                        }
                    } elseif (isset($_SESSION['editSuc'])) {
                        echo "Update Successfull!";
                        // add successfull session is unset 
                        if (isset($_SESSION['editSuc'])) {
                            unset($_SESSION['editSuc']);
                        }
                    }
                    ?>
                </p>

                <!-- menu added button  -->
                <form action="" method="post" class="flex items-center mb-4 gap-1" enctype="multipart/form-data">

                    <input type="text" name="title" placeholder="post title" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <input type="text" name="post" placeholder="type a post" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <input type="text" name="button-link" placeholder="Read more link" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <input type="file" name="image" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required />
                    <button name="add" class="bg-blue-500 text-white px-4 py-2 rounded-r hover:bg-blue-600">Add</button>
                </form>

                <!-- menu bar listed item show -->
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 bg-gray-200 border-b">#</th>
                            <th class="py-2 px-4 bg-gray-200 border-b">Title</th>
                            <th class="py-2 px-4 bg-gray-200 border-b">Post</th>
                            <!-- <th class="py-2 px-4 bg-gray-200 border-b">buttonName</th> -->
                            <th class="py-2 px-4 bg-gray-200 border-b">ButtonLink</th>
                            <th class="py-2 px-4 bg-gray-200 border-b">Image</th>
                            <th class="py-2 px-4 bg-gray-200 border-b">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($postConnect->num_rows > 0) {
                            $idCount = 1;
                            while ($postRow = $postConnect->fetch_assoc()) { ?>
                                <tr>
                                    <td class="py-2 px-4 border-b text-center"><?php echo $idCount; ?></td>
                                    <td class="py-2 px-4 border-b text-center"><?php echo $postRow['title'] ?></td>
                                    <td class="py-2 px-4 border-b text-center"><?php echo $postRow['paragraph'] ?></td>
                                    <!-- <td class="py-2 px-4 border-b text-center">Read more</td> -->
                                    <td class="py-2 px-4 border-b text-center"><?php echo $postRow['button-link'] ?></td>
                                    <td class="py-2 px-4  text-center items-center flex justify-center">
                                        <img class="w-20 h-10 " src="<?php echo $postRow['img-link'] ?>" alt="">
                                    </td>
                                    <td class="py-2 px-4 border-b  text-center ">
                                        <div class="flex flex-row items-center justify-center gap-1">
                                            <form action="postEdit.php?id=<?php echo $postRow['id']; ?>" method="post">
                                                <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-red-600" type="submit" name="edit" value="<?php echo $postRow['id']; ?>">
                                                    Edit
                                                </button>
                                            </form>
                                            <form action="" method="post">
                                                <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" type="submit" name="delete" value="<?php echo $postRow['id']; ?>">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                        <?php $idCount++;
                            }
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