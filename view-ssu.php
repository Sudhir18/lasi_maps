<?php
		session_start();
		if(!isset($_SESSION)){
			var_dump($_SESSION);
			header('location:logout.php');
			exit();
		}
		include_once(dirname(__FILE__).'/config/config.php');
		include_once(dirname(__FILE__).'/view/header.php');
		include_once(dirname(__FILE__).'/view/usernavbar.php');
    include_once(dirname(__FILE__).'/model/MapModel.php');

    $id = trim($_GET['ssu']);
    $ssu_map = MapModel::getMapBySSU($id);
    $ssu = MapModel::getSSUById($id);
?>
<div class="container">
  <?php if($ssu) {?>
	<h3>SSU Details:</h3>
      <div class="row">
        <ul>
            <li><strong>SSU Name:</strong><?php echo $ssu['name'] ?></li>
            <li><strong>District:</strong><?php echo $ssu['region'] ?></li>
            <li><strong>State:</strong><?php echo $ssu['state'] ?></li>
        </ul>
      </div>
      <div class="row">
              <?php if(file_exists($ssu_map['filepath'])){?>
                  <img src="<?php echo base_url().'/map_images/'.$ssu_map['filename'] ?>" class="img-thumbnail" /> 
              <?php }?>
      </div>
  <?php}else{ ?>
    <div class="msg-box error-box alert alert-danger alert-dismissable fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <span class="error-msg">No ssu avaialble!</span>
    </div>
  <?php } ?>

</div>
<?php

	include_once(dirname(__FILE__).'/view/footer.php');
?>
