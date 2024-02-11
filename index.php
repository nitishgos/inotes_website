<?php
$servername="localhost";
$username="root";
$password="";
$database="notes";
$insert=false;
$update=false;
$delete=false;
$con=mysqli_connect($servername,$username,$password,$database);
if(!$con){
  die("Sorry failed to connect ".mysqli_connect_error());
}
if(isset($_GET['delete'])){
  $SlNo=$_GET['delete'];
  $delete=true;
  $sql=" DELETE FROM `notes` WHERE `Sl.No` = $SlNo";
  $result=mysqli_query($con,$sql);
}
if($_SERVER['REQUEST_METHOD']=='POST'){
  if(isset($_POST['SlNoEdit'])){
    $no=$_POST['SlNoEdit'];
    $Title=$_POST['TitleEdit'];
    $description=$_POST['descriptionEdit'];
    $sql="UPDATE `notes` SET `Title` = '$Title' , `description` = '$description'  WHERE `Sl.No` = $no";
    $result=mysqli_query($con,$sql);
    if($result){
      $update=true;
    }else{
      echo"The record does not insert " .mysqli_error($con); 
    }
  }else{
  $Title=$_POST['Title'];
  $description=$_POST['description'];
  $sql="INSERT INTO `notes` (`Title`, `description`) VALUES ('$Title', '$description')";
  $result=mysqli_query($con,$sql);
  if($result){
    $insert=true;
  }else{
    echo"The record does not insert " .mysqli_error($con); 
  }
  }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    
    <title>PHP CRUD</title>
  </head>
  <body>
    <!-- Button trigger modal -->
<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#EditModal">
  Edit modal
</button>-->

<!-- Modal -->
<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="EditModalLabel">Edit this note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>  
      <div class="modal-body">
      <form action="/CRUD/index.php" method="post">
        <input type="hidden" name="SlNoEdit" id="SlNoEdit">
            <div class="form-group">
              <label for="title">Note Title</label>
              <input type="title" class="form-control" id="TitleEdit" name="TitleEdit" aria-describedby="emailHelp" placeholder="Node title">
            </div>
            <div class="form-group">
                <label for="desc">Note description</label>
                <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Note</button>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">inotes</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" href="#">Contact Us</a>
            </li>
          </ul>
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>
      </nav>
      <?php
      if($insert){
        echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your notes successfully added.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
      }
      ?>
      <?php
      if($update){
        echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Update!</strong> Your notes updated successfully.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
      }
      ?>
      <?php
      if($delete){
        echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Delete!</strong> Your notes deleted successfully.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
      }
      ?>
      <div class="container my-4">
        <h2>Add Note</h2>
        <form action="/CRUD/index.php" method="post">
            <div class="form-group">
              <label for="title">Note Title</label>
              <input type="title" class="form-control" id="Title" name="Title" aria-describedby="emailHelp" placeholder="Node title">
            </div>
            <div class="form-group">
                <label for="desc">Note description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Note Add</button>
          </form>
      </div>
      <div class="container my-4">
        <table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">Sl.No</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php
        $sql="SELECT * FROM `notes`";
        $result=mysqli_query($con,$sql);
        $no=0;
        while($row=mysqli_fetch_assoc($result)){
          $no=$no+1;
          echo"<tr>
          <th scope='row'>".$no."</th>
          <td>".$row['Title']."</td>
          <td>".$row['description']."</td>
          <td> <button class='edit btn btn-sm btn-primary ' id=".$row['Sl.No'].">Edit</button>  <button class='delete btn btn-sm btn-primary ' id=d".$row['Sl.No'].">Delete</button>  </td>
        </tr>";
        }
        ?>
 </tbody>
</table>
      </div>
      <hr>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready( function () {
        $('#myTable').DataTable();
      });
      </script>
      <script>
        edits=document.getElementsByClassName('edit');
        Array.from(edits).forEach((element)=>{
          element.addEventListener("click",(e)=>{
            console.log("edit ", );
            tr=e.target.parentNode.parentNode;
            Title=tr.getElementsByTagName("td")[0].innerText;
            description=tr.getElementsByTagName("td")[1].innerText;
            console.log(Title,description);
            TitleEdit.value=Title;
            descriptionEdit.value=description;
            SlNoEdit.value=e.target.id;
            console.log(e.target.id);
            $('#EditModal').modal('toggle')
          })
        })
        deletes=document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element)=>{
          element.addEventListener("click",(e)=>{
            console.log("edit ", );
            tr=e.target.parentNode.parentNode;
            Title=tr.getElementsByTagName("td")[0].innerText;
            description=tr.getElementsByTagName("td")[1].innerText;
            SlNo=e.target.id.substr(1,);
            if(confirm("Are you sure you want to delete this note ! ")){
              console.log("yes");
              window.location=`/CRUD/index.php?delete=${SlNo}`;
            }else{
              console.log("no");
            }
          })
        })
      </script>
  </body>
</html>