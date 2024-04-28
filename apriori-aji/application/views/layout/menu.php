<?php
$menu = array(
  array(
      "name"=>"Home",
      "icon"=>"remixicon-dashboard-line",
      "link"=>base_url()."apriori"
  ),
  array(
      "name"=>"Apriori",
      "icon"=>"remixicon-honour-line",
      "link"=>base_url()."apriori/process"
  ),
  array(
      "name"=>"Proses Data",
      "icon"=>"remixicon-honour-line",
      "link"=>base_url()."apriori/dataset"
  ),
  array(
      "name"=>"Logout",
      "icon"=>"remixicon-honour-line",
      "link"=>base_url()."auth/logout"
  )
);
?>
<div class="topbar-menu">
    <div class="container-fluid">
        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu">
            <?php
                foreach ($menu as $key) {
                    ?>
                    <li class="has-submenu">
                        <a href="<?=$key['link']?>">
                            <i class="<?=$key['icon']?>"></i><?=$key['name']?>
                        </a>
                    </li>
                    <?php
                }
            ?>
            </ul>
            <!-- End navigation menu -->
            <div class="clearfix"></div>
        </div>
        <!-- end #navigation -->
    </div>
    <!-- end container -->
</div>
 