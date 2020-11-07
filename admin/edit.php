<?php
	session_start();
	 require '../config/config.php';
	if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
		header('Location: login.php');
	}

    if($_POST){
        $id=$_POST['id'];
        $title=$_POST['title'];
        $content=$_POST['content'];

        if($_FILES['image']['name'] != null){
 $file='images/'.($_FILES['image']['name']);
            $imageType=pathinfo($file,PATHINFO_EXTENSION);

        if($imageType !='png' && $imageType !='jpg' && $imageType !='jpeg'){
            echo "<script>alert('Image must be png,jpeg,jpg')</script>";
        }else{
            $image= $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $file);

            $statement= $pdo->prepare("UPDATE posts SET title='$title',content='$content',image='$image' WHERE id='$id'");
            $result= $statement->execute();
            if($result){
                  echo "<script>alert('Successfully updated');window.location.href='index.php';</script>";
                   header('Location: index.php');
            }
        }
        }
        else{
           
            $statement= $pdo->prepare("UPDATE posts SET title='$title',content='$content' WHERE id='$id'");
            $result= $statement->execute();
            if($result){
                  echo "<script>alert('Successfully updated');window.location.href='index.php';</script>";
                  header('Location: index.php');
            }
        }
    }
	
    $statement =$pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
    $statement->execute();

    $result= $statement->fetchAll();
?>
<?php 
include('header.html');
?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
           <div class="col-md-12">
            <div class="card">
             	<div class="card-body">
             		<form class="" action="" method="post" enctype="multipart/form-data">
             		<div class="form-group">
                        <input type="hidden" name="id" value="<?php echo $value[0]['id'] ?>"> 
             			<label for="">Title</label>
             			<input type="text" name="title" class="form-control" value="<?php echo $result[0]['title'] ?>" required="required">
             		</div>
             		<div class="form-group">
             			<label for="">Content</label><br>
             			<textarea name="Content" rows="8" cols="80" class="form-control"><?php echo $result[0]['content'] ?></textarea>
             		</div>
             		<div class="form-group">
             			<label for="">Image</label><br>
                        <img src="images/<?php echo $value[0]['image'] ?>" width="150" height="150" alt=""><br><br>
             			<input type="file" name="image" value="">
             		</div>
             		<div class="form-group">
             			<input type="submit" name="" value="Submit" class="btn btn-success">
             			<a href="index.php" class="btn btn-warning" >Back</a>
             		</div>
             	</form>
             	</div>
            </div>
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
 <?php 
include('footer.html');
 ?>