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
      <a class="navbar-brand" href="dashbord.php"><?= lang('ADMIN'); ?></a>
    </div>
    <div class="collapse navbar-collapse" id="appnav">
      <ul class="nav navbar-nav">
        <li><a href="categories.php"><?=lang('CATEGORIES');?></a></li>
         <li><a href="item.php"><?=lang('ITEMS');?></a></li>
          <li><a href="member.php"><?=lang('MEMBERS');?></a></li>
           <li><a href="comment.php"><?=lang('COMMENTS');?></a></li>
        
      </ul>
    
      <ul class="nav navbar-nav navbar-right">
     
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Samer <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="../index.php">Visit Shop</a></li>
            <li><a href= "member.php?action=Edit&userid=<?=$_SESSION['id']?>"><?=lang('EDITPROFILE');?></a></li>
            <li><a href=""><?=lang('SETTINGS');?></a></li>
            <li><a href="logout.php"><?=lang('LOGOUT');?></a></li>
       
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>