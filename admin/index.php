<?php
  session_start();
   require '../config/config.php';
  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
    header('Location: login.php');
  }
?>
<?php 
include('header.html');
?>
    <!-- Main content -->
    <div class="contents">
      <div class="container-fluid">
        <div class="row">
           <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Blog Listings</h3>
              </div>
              <?php 
                if($_GET['pageno']){
                  $pageno=$_GET['pageno'];
                }
                else{
                  $pageno=1;
                }
                $numOfrecs=10;
                $offset= ($pageno-1)*numOfrecs;

                if(empty($_POST['search'])){
                   $statement = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
                $statement->execute();
                $rawResult= $statement->fetchAll();
                $total_pages=ceil(count($rawResult)/$numOfrecs);

                $statement = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$numOfrecs  ");
                $statement->execute();
                $result= $statement->fetchAll();
                }
                else{
                  $searchKey=$_POST['search'];
                   $statement = $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC");
                $statement->execute();
                $rawResult= $statement->fetchAll();
                $total_pages=ceil(count($rawResult)/$numOfrecs);

                $statement = $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs  ");
                $statement->execute();
                $result= $statement->fetchAll();
                }

              ?>
              <!-- /.card-header -->
              <div class="card-body">
                <div>
                  <a href="add.php" type="button" class="btn btn-success">New Blog Post</a>
                </div>
                 <br>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Title</th>
                      <th>Description</th>
                      <th style="width: 40px">Actions</th>
                    </tr>
                  </thead>
                  <tbody>                     
                    <?php 
                      if($result){
                        $i=1;
                        foreach ($result as $value) {
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['title']; ?></td>
                      <td><?php echo substr($value['content'],0,50); ?></td>
                      <td>
                        
                        <div class="btn-group">
                          <div class="container">
                             <a href="edit.php?id=<?php echo $value['id'] ?>" type="button" class="btn btn-warning">Edit</a>
                          </div>
                          <div class="container">
                            <a href="delete.php?id=<?php echo $value['id'] ?>" onclick="return confirm('Are you sure want to delete!')" type="button" class="btn btn-danger">Delete</a>
                          </div>
                       </div>
                      </td>
                    </tr>
                   
                    <?php
                       $i++;
                        }
                      }
                    ?>
                          
                       
                  </tbody>
                </table>
                <br>
                 <nav aria-label="Page navigation example" style="float: right">
              <ul class="pagination">
                <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                <li class="page-item <?php if($pageno<=1){echo 'disabled';} ?>">
                   <a class="page-link" href="<?php if($pageno <=1){echo '#';}else{echo "?pageno=".($pageno-1);}?>">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>

                <li class="page-item <?php if($pageno >= $total_pages){echo 'disabled';}?>">
                <a class="page-link" href="<?php if($pageno >=$total_pages){echo '#';}else{echo "?pageno=".($pageno+1);}?>">Next</a>
                </li>
                <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages?>">Last</a></li>
              </ul>
              </nav>
              </div>
             
                        <!-- /.card-body -->
             <!--  <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul>
              </div> -->
            </div>
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.contents -->
 <?php 
include('footer.html');
 ?>