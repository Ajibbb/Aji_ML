<?php
  require 'libraries/Apriori.class.php';
  if($this->input->post("simpan")!==NULL){
    $this->session->set_userdata("support",$this->input->post("support"));
    $this->session->set_userdata("confidence",$this->input->post("confidence"));
    $this->session->set_userdata("recomendation",$this->input->post("recomendation"));
  }
?>
<div class="row">
    <!-- Right Sidebar -->
    <div class="col-12">
        <div class="card-box">
            <!-- Left sidebar -->
            <div class="inbox-leftbar">
                <a href="#" class="btn btn-warning btn-block waves-effect waves-light">Apriori</a>
                <div class="mail-list mt-4">
                    <a href="<?=base_url()?>apriori/process/dataset" class="list-group-item border-0 <?=$page=='dataset'?'font-weight-bold':'';?>">1. Dataset</a>
                    <a href="<?=base_url()?>apriori/process/init" class="list-group-item border-0 <?=$page=='init'?'font-weight-bold':'';?>">2. Initial Process</a>
                    <a href="<?=base_url()?>apriori/process/rule" class="list-group-item border-0 <?=$page=='rule'?'font-weight-bold':'';?>">3. Generate Rule</a>
                </div>
            </div>
            <!-- End Left sidebar -->
            <div class="inbox-rightbar">
              <?php
                $history = $this->db->query("select GROUP_CONCAT(product) as transaksi from dataset_aji group by invoice;")->result_array();
                $column = array();
                if(sizeof($history)>0){
                  $column = $history[0];
                  $column = array_keys($column);
                }
              ?>
            <?php
                //Dataset
                if($page == 'dataset' && sizeof($column)>0){
                ?>
                <div class="col-md-12">
                    <?php
                    $index = $column;
                    $dataset = $history;
                    ?>
                    <div class="card-box table-responsive">
                      <h4>Dataset Apriori</h4>
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <?php
                                foreach ($index as $key) {
                                  ?>
                                   <th><?=$key?></th>
                                  <?php
                                }
                            ?>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($dataset as $key) {
                                ?>
                                <tr>
                                    <?php
                                     foreach ($index as $keys) {
                                        ?>
                                            <td><?=$key[$keys]?></td>
                                        <?php
                                     }
                                    ?>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                <?php
                }
                if($page == 'init' && sizeof($column)>0){
                    ?>
                     <?php
                     $index = $column;
                     $dataset = $history;
                    ?>
                    <div class="card-box table-responsive">
                      <h4>Initial Process</h4>
                      <table class="table table-border">
                        <thead>
                          <tr>
                            <?php
                                foreach ($index as $key) {
                                  ?>
                                   <th><?=$key?></th>
                                  <?php
                                }
                            ?>
                          </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td align="center" style="border-right: 1px solid black;" colspan="<?=sizeof($index)-1?>"><b>--PERSIAPAN DATASET--</b></td>
                        </tr>
                            <?php
                            foreach ($dataset as $key) {
                                ?>

                                <tr>
                                    <?php
                                    $x=0;
                                     foreach ($index as $keys) {
                                        $x++;
                                        ?>
                                            <td class="<?=$x==sizeof($index)?'table-success':'table-warning';?>"><?=$key[$keys]?></td>
                                        <?php
                                     }
                                    ?>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                      </table>
                    </div>
                    <?php
                }
                if($page == 'rule' && sizeof($column)>0){
                  $index = $column;
                  $dataset = array_column($history,"transaksi");
                  ?>
                  <div class="card-box">
                       <div class="row">
                         <div class="col-md-6">
                         <h4>Generate Rule Apriori</h4>
                         <?=form_open("apriori/process/rule")?>
                           <div class="form-group">
                             <label>Minimal Support (dalam persen %)</label>
                             <input class="form-control" required type="number" value="<?=$this->session->userdata("support")?>" name="support">
                           </div>
                           <div class="form-group">
                             <label>Minimal Confidence (dalam persen %)</label>
                             <input class="form-control" required type="number" value="<?=$this->session->userdata("confidence")?>" name="confidence">
                           </div>
                           <div class="form-group">
                             <label>Recomendation</label>
                             <input class="form-control" required type="text" value="<?=$this->session->userdata("recomendation")?>" name="recomendation">
                           </div>
                           <div class="form-group">
                             <button class="btn btn-sm btn-warning" name="simpan" value="1" type="submit">Simpan</button>
                           </div>
                           <?=form_close()?>
                         </div>
                       </div>
                       <hr />
                       <div class="row">
                         <div class="col-md-12">
                           <?php
                           if($this->session->userdata("support")!==NULL){
                             try {
                                 $minSupp  = $this->session->userdata("support");                    //minimal support
                                 $minConf  = $this->session->userdata("confidence");                 //minimal confidence
                                 $type     = AprioriMethod::SRC_PLAIN; //data type
                                 $recomFor = $this->session->userdata("recomendation");             //recommendation for
                                 $dataFile = 'libraries/data.json';
                                 $apri = new AprioriMethod($type, $dataset, $minSupp, $minConf);
                                 $apri->solve()
                                      ->generateRules();
                                 $state = $apri->getState();
                                 ?>
                                 <h4>Object Frequently</h4>
                                 <div class="row">
                                   <?php
                                   foreach ($state[2] as $key => $value) {
                                     foreach ($value as $k => $v) {
                                       ?><button class="btn btn-sm btn-purple ml-1"><?=$k?> : <?=$v?></button><?php
                                     }
                                   }
                                   ?>
                                 </div>
                                 <br />
                                 <h4>Set Rules</h4>
                                 <table class="table table-border">
                                   <tr>
                                     <th>If</th>
                                     <th>Support</th>
                                     <th>Then</th>
                                     <th>Confidence</th>
                                   </tr>
                                   <?php
                                   foreach ($state[4] as $key => $val) {
                                     foreach ($val as $k) {
                                       ?>
                                       <tr>
                                         <td><?=$key?></td>
                                         <td><?=$k['supp']?>%</td>
                                         <td><?=$k['Y']?></td>
                                         <td><?=$k['conf']?>%</td>
                                       </tr>
                                       <?php
                                     }
                                   }
                                   ?>
                                 <table>
                                 <br />
                                 <h4>Recomendation for <?=$this->session->userdata("recomendation")?></h4>
                                 <table class="table table-border">
                                   <tr>
                                     <th>Support</th>
                                     <th>Confidence</th>
                                     <th>Result</th>
                                   </tr>
                                 <?php
                                 $rec = $apri->getRecommendations($recomFor);
                                 foreach ($rec as $key) {
                                   ?>
                                   <tr>
                                     <td><?=$key['supp']?>%</td>
                                     <td><?=$key['conf']?>%</td>
                                     <td><?=$key['Y']?></td>
                                  </tr>
                                   <?php
                                 }
                                 ?>
                                 <table>
                                 <?php
                             } catch (Exception $exc) {
                                 echo $exc->getMessage();
                             }
                           }
                           ?>
                         </div>
                       </div>
                     </div>
                   </div>
                 </div>
                  <?php
                }

            ?>


            </div>
            <div class="clearfix"></div>
        </div> <!-- end card-box -->
    </div> <!-- end Col -->
</div>
