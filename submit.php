<?php
//Project Submission Page

//Session begins
session_start();

//Checking user role
$role = $_SESSION['sess_userrole'];
    if(!isset($_SESSION['sess_username']) && $role!="user"){
      header('Location: login.php?err=2');
    }

    //File Upload Processing
    $target_dir = "projects/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $file_type=$_FILES['fileToUpload']['type'];

    //assiging form content to variables
    $author = test_input($_POST['author']);
    $title = test_input($_POST['title']);
    $school = test_input($_POST['school']);
    $type = test_input($_POST['type']);
    $country = test_input($_POST['country']);
    $class = test_input($_POST['class']);
    $category = test_input($_POST['category']);
    $keyords = test_input($_POST['keywords']);
    $url = test_input($_POST['url']);
    $description = test_input($_POST['description']);

    // Check if file is a actual file or fake file
    if(isset($_POST["submit"])) {

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $check = finfo_file($finfo, $_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "Document Accepted - " . $check. ".<br />";
            $uploadOk = 1;
        } else {
            echo "File is not a Document.[E1] <br />";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, a file already exists with the same name. Kindly, rename.[E2] <br />";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 10000000) {
            echo "Sorry, your file is too large. [E3]";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($file_type != "application/pdf"  ) {
            echo "Sorry, only pdf files are allowed. [E4]";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded. [E5]";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

                    //Database Connection
                    $servername = "localhost";
                    $username = "sellit12_root";
                    $password = "Ba0548797248";

                  //Begin Connection
                  $conn = new PDO("mysql:host=$servername;dbname=sellit12_searchengine", $username, $password);

                //query the database
                $sqlinsert = "INSERT INTO projects (author, title, school,type,country,class,category,keywords,url,
                description)
                VALUES ('$author', '$title', '$school', '$type', '$country', '$class', '$category','$keyords',
                 '$url', '$description ')";

                  //Using prepared Statements
                  $conn->exec($sqlinsert);
                  $last_id = $conn->lastInsertId();

                  echo "New Submission sent succesfully. Last insert ID is:  " . $last_id;

                  echo ". <br />The file ". basename( $_FILES["fileToUpload"]["name"]). " was succesfully uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.[E6]";
            }
        }
    }

    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    //Disconnect from Database
    $conn = null;

//End of Submission Script
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
  <!--Meta, Javascript Head Tags & Title-->
  <title> Submission Form - Dzella</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <!--End of Meta, Javascript Head Tags & Title-->
</head>
<body style="background: url(http://cssdeck.com/uploads/media/items/7/7AF2Qzt.png)">

  <nav id="topbar"class="navbar navbar-default " style="height: 65px;">
    <div class="container-fluid">
      <div class="navbar-header">
        <h3 class="navbar-brand" style="margin-top: 10px;"><a href="submit.php"> Dzella</a></h3>
      </div>
      <h3 class="navbar-brand" style="margin-top: 10px;float:right;"><a href="logout.php"> Logout</a></h3>
    </div>
  </nav>

  <!--Submission Form-->
    <form action="" method="post" enctype="multipart/form-data" >
      <center><table border="10" cellpadding="5" cellspacing="0" style="Padding-top:20px;background-color:grey; width:500px;">

        <h2>Submission Form</h2>

          <tr> <td colspan="2">
          <label for="author"><b>Author / Writer's Name:  *</b></label><br />
          <input name="author" placeholder="Eg.: Samuel Adu Opoku" type="text" style="width: 535px" required autofocus/>
          </td></tr>

          <tr> <td colspan="2">
          <label for="title"><b>Title Of Project / Book:  *</b></label><br />
          <input name="title" type="text" placeholder="Eg.: Design and Implementation of A church Management System" style="width: 535px" required />
          </td> </tr>

          <tr> <td colspan="2">
          <label for="school"><b>Institution / Publisher City: *</b></label><br />
          <input name="school" type="text" placeholder="Eg.: Knutsford University College / London" style="width: 535px" required/>
          </td> </tr>

          <tr> <td>
          <label for="type"><b>Category: *</b></label><br />
          <input name="type" type="text" placeholder="Project, Book, Research Paper or Journal"  style="width: 260px"  required/>
          </td>
           <td>
          <label for="country"><b>Country: </b></label><br />
          <input name="country" type="text" placeholder="Eg.: Ghana"  style="width: 250px" required/>
          </td> </tr>

          <tr> <td>
          <label for="class"><b>Class Of Completion / Year Published: *</b></label><br />
          <input name="class" type="text" placeholder="Eg.;Class of 2018"  style="width: 260px" required/>
          </td>
          <td>
          <label for="category"><b>Programme Of Study: *</b></label><br />
          <input name="category" type="text" placeholder="Bsc. Computer Science" style="width: 250px" required/>
          </td> </tr>

          <tr> <td colspan="2">
          <label for="keywords"><b>Keywords for searching database: (NB: seperating each with a space no symbols)*</b></label><br />
          <input name="keywords" type="text" placeholder="church management system knutsford project computer science php"  style="width: 535px" required/>
          </td> </tr>

          <tr> <td colspan="2">
          <label for="url"><b>File Name: (NB: Always include "projects/" before file name)*</b></label><br />
          <input name="url" type="text" placeholder="projects/filename.pdf" style="width: 535px" required/>
          </td> </tr>

          <tr> <td colspan="2">
          <label for="description"><b>Project / Book Summary (Description): *</b></label><br />
          <textarea name="description" placeholder="This is a complete church management system which allows both church members and administrators to login and enjoy latest news in Church. It is built with php."rows="7" cols="40" maxlength="290" style="width: 535px" required></textarea>
          </td> </tr>

          <tr> <td colspan="2" style="text-align: center;"><br />
          Select Document to upload: *<br /><br />
          <center><input type="file" name="fileToUpload" id="fileToUpload" required></center><br /><br /><br />
          </td> </tr>

         <tr><td colspan="2" style="text-align: center;">
         <input type="submit" value="Submit" name="submit"  id="button1">
         </tr><td>
      </table></center>
    </form>
    <!--End of Submission Form-->

</body>
</html>
<!--End of Submission Page-->
