
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php title(); ?></title>
</head>
<link rel="stylesheet" href="<?=$header;?>/bootstrap.min.css"/>
<link rel="stylesheet" href="<?=$header;?>/font-awesome.min.css"/>
<link rel="stylesheet" href="<?=$header;?>/jquery-ui.css"/>
<link rel="stylesheet" href="<?=$header;?>/jquery.selectBoxIt.css"/>
<link rel="stylesheet" href="<?=$header;?>/jquery.tagsinput.css" />
<link rel="stylesheet" href="<?=$header;?>/frontend.css"/>
<body>

  <div class="upper-bar">
    <div class="container text-right">
      <?php   
      if (isset($_SESSION['user'])) {?>
        <img class=" my-img img-circle" src="layout/img/img.png" alt="" />
          <div class="btn-group my-info">
              <span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <?php echo $_SESSION['user']  ?>
                <span class="caret"></span>
              </span>
              <ul class="dropdown-menu">
                <li><a href="profile.php"> My Profile </a></li>
                <li><a href="newAds.php">  Add item</a></li>
                <li><a href="logout.php"> Logout</a></li>
              </ul>
          </div> 
        <?php
      }else{
      ?>
      <a href="login.php">
       <span class="pull-right">Login/SignUp</span> 
      </a>
    <?php };?>
  </div>
  </div>
	<nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#appnav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Home Page</a>
    </div>
    <div class="collapse navbar-collapse" id="appnav">
      <ul class="nav navbar-nav navbar-right">
       <?php
          $categories = getall('*','categories','WHERE Parent=0','','ID','ASC');
        foreach ($categories as $cat) {
            echo '<li><a href="categories.php?catid=' . $cat['ID'] . '">'.$cat['Name'].'</a></li>';
        }
       ?>
        
      </ul>
    
     
    </div>
  </div>
</nav>