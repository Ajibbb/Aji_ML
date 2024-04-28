<?php
$footer = array(
                    "copyright"=>APPNAME,
                    "aboutus"=>"#LinktoYour",
                    "contactus"=>"#LinktoContact",
                    "help"=>"#LinktoHelp"
                );
?>
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
               <b><?=isset($footer['copyright'])?$footer['copyright']:''?></b>
            </div>
            <div class="col-md-6">
                <div class="text-md-right footer-links d-none d-sm-block">
                    <a href="<?=isset($footer['aboutus'])?$footer['aboutus']:''?>">Aji Bayu Prasetyo</a>
                    <a href="<?=isset($footer['help'])?$footer['help']:''?>">05202040028</a>
                    <a href="<?=isset($footer['contactus'])?$footer['contactus']:''?>">R1 INFORMATIKA</a>
                </div>
            </div>
        </div>
    </div>
</footer>
