<?php
//Remain 2 Err 


session_start();

include_once "../models/reviews.php";
include_once "../models/register.php";
include_once "../neon/models/book.php";
include_once "../controllers/registercontroller.php";
include_once('latestBook.php');

$userEmail = $_SESSION['user_email'];
$reviews_model = new Reviews();
$register_model = new CreateUser();
$book_model = new Book();

$userId = $register_model->getUserId($userEmail);
if (isset($_SESSION['bookList']) && isset($_GET['id'])) {
    $ReviewBookList_id = $_SESSION['bookList'];
    $ReviewBookList_id[] = (int) $_GET['id'];
    $_SESSION['bookList'] = $ReviewBookList_id;
} else if (isset($_SESSION['bookList']) && isset($_GET['del'])) {
    $ReviewBookList_id = $_SESSION['bookList'];
    unset($ReviewBookList_id[$_GET['del']]);
    $_SESSION['bookList'] = $ReviewBookList_id;
} else {
    $_SESSION['bookList'] = [];
}
if (isset($_POST['review-content'])) {
    $_SESSION["content"] = $_POST["review-content"];
}
if (isset($_POST['submit']) && isset($_POST['review-content']) && count($ReviewBookList_id) != 0) {
    // echo "true"."<br>";
    // echo "id :".$userId[0]['id']."<br>";
    // echo "content :".$_SESSION['content']."<br>";
    // var_dump($ReviewBookList_id);
    if (
        $reviews_model->upload_review($userId[0]['id'], $_SESSION['content'], $ReviewBookList_id)
    ) {
        header("location:Review.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Book Review System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="Post.css" />
    <link rel="stylesheet" href="Review.css">
</head>

<body>
    <!-- Navigation bar -->
    <?php
    include_once "nav.php";
    ?>

    <div class="container mt-4">
        <h1>Upload Review</h1>
        <form id="upload-form" method="Post">
            <div class="form-group">
                <label for="review-content">Review</label>
                <textarea id="review-content" name="review-content" rows="8" required>
                    </textarea>
            </div>
            <div class="container">
                <div class="d-flex flex-wrap">
                    <?php
                    if (isset($ReviewBookList_id)) {
                        foreach ($ReviewBookList_id as $key => $ReviewBook_id) {
                            $book = $book_model->getBookInfo($ReviewBook_id);





                            ?>
                            <a href="Post.php?del=<?php echo $key ?>">
                                <div class="book-details">
                                    <img src="<?php echo $book["image"] ?>" alt="<?php echo $book["image"] ?>" />
                                    <div class="book-info">
                                        <h2>
                                            <?php echo $book["name"] ?>
                                        </h2>
                                        <?php
                                        $author = $reviews_model->get_author_by_id($book["auther_id"]);
                                        ?>
                                        <p>by
                                            <?php echo $author["name"] ?>
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <?php
                        }
                    } else {
                        echo "<h1>Pleawe Choice Books</h1>";
                    }
                    ?>
                </div>
            </div>
            <div class="container mt-4">
                <div class="book-card-list">
                    <!-- Search Bar -->
                    <div class="search-bar">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search..." />
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="book-card-grid">
                        <?php

                        foreach ($book_list as $book) {
                            ?>
                            <div class="book-card">
                                <div class="book-card-image">
                                    <img src="../image/photos/<?php echo $book['image'] ?>"
                                        alt="<?php echo $book['name'] ?>" />
                                    <div class="book-card-overlay">
                                        <a href="Post.php?id=<?php echo $book['id'] ?>" class="book-card-button">Add
                                            Book</a>
                                    </div>
                                </div>
                                <div class="book-card-info">
                                    <h3 class="book-card-title">
                                        <?php echo $book['name'] ?>
                                    </h3>
                                    <p class="book-card-author">
                                        <?php echo $book['auther_name'] ?>
                                    </p>
                                    <p class="book-card-genre">
                                        <?php echo $book['category_name'] ?>
                                    </p>
                                </div>
                            </div>
                            <?php
                        }
                        ?>

                    </div>
                    <div class="mt-4" style="display: flex; justify-content: center; width: 100%">
                        <a href="" class="btn btn-primary m-auto">Load More</a>
                    </div>
                </div>
            </div>
            <button type="submit" name="submit" class="mt-4">Upload</button>
        </form>
    </div>

    <!-- Footer -->
    <footer class="footer mt-4">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4 class="text-center">About Us</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec
                        aliquet semper sapien, ut sodales lectus tincidunt et.
                    </p>
                </div>
                <div class="footer-section">
                    <h4 class="text-center">Quit Link</h4>
                    <div class="Quick-Link">
                        <ul>
                            <li class="">
                                <a href="#" class="">FAQ</a>
                            </li>
                            <li class="">
                                <a href="#" class="">Support</a>
                            </li>

                            <li class="">
                                <a href="#" class="">Contact Us</a>
                            </li>
                        </ul>
                        <ul>
                            <li class="">
                                <a href="#" class="">About us</a>
                            </li>
                            <li class="">
                                <a href="#" class="">BookMark</a>
                            </li>

                            <li class="">
                                <a href="#" class="">Profile</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="footer-section">
                    <h4 class="text-center">Follow Us</h4>
                    <ul class="social-links">
                        <li>
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <p class="text-center mt-4">
                © 2023 Book Review System. All rights reserved.
            </p>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="app.js"></script>
    <script src="Post.js"></script>
</body>

</html>