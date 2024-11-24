<?php
    include_once("../Library/dbconnect.php");
    include_once("../Library/Library.php");
    //include "../dbconnect.php";
?>
<?php

     //search Item name
              $structquery="select
                                mas_item,
                                sub_item
                            from
                                trn_product_setup
                            where
                                mas_product_id='".$mas_product_id."'";
                $rsstruct=mysqli_query($conn, $structquery)or die(mysqli_error());
                if(mysqli_num_rows($rsstruct)>0)
                {       $structure="<table><tr><td>";
                        while($rowstruct=mysqli_fetch_array($rsstruct))
                        {
                                extract($rowstruct);
                                $structure=$structure.pick("mas_item","itemdescription","itemcode='".$mas_item."'")."-".pick("mas_item","itemdescription","itemcode='".$sub_item."'")."<br>";
                        }
                        $structure=$structure."</td></tr></table>";
                        echo $structure;
                }

             /* if(mysqli_num_rows($resultItemName)>0)
                 {

                     while($rowItemName=mysqli_fetch_array($resultItemName))
                      {
                           extract($rowItemName);



                      }
                      echo $salary."-".$balance;
                 }*/

?>


