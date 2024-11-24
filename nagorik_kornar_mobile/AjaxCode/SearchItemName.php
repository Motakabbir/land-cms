<?php
    include_once("../Library/dbconnect.php");
    //include "../dbconnect.php";
?>
<?php

     //search Item name
              $searchItemName="select
                                     itemcode,
                                     itemdescription
                                from
                                     mas_item
                               where
                                    parent_itemcode='".$GLID."'
                              order by itemdescription
                               ";

              $resultItemName=mysqli_query($conn, $searchItemName) or die(mysqli_error());

             echo"<select name='cboItem'>
                        <option value='-1'>select Sub-Item</option>
                   ";

              if(mysqli_num_rows($resultItemName)>0)
                 {

                     while($rowItemName=mysqli_fetch_array($resultItemName))
                      {
                           extract($rowItemName);
                           echo"<option value='".$itemcode."'>$itemdescription</option>";


                      }

                 }
            echo"</select>";

?>


