<?php
    include_once("../Library/dbconnect.php");
    //include "../dbconnect.php";
?>
<?php

     //search Item name
              $searchItemName="select
                                     account_object_id,
                                     account_no
                                from
                                     trn_bank
                                where
                                     bank_id='".$BANKID."'
                                order by
                                     account_no
                               ";
              $resultItemName=mysqli_query($conn, $searchItemName) or die(mysqli_error());

             echo"<select name='cboBanKAccount'>
                        <option value='-1'>select Account</option>
                   ";

              if(mysqli_num_rows($resultItemName)>0)
                 {

                     while($rowItemName=mysqli_fetch_array($resultItemName))
                      {
                           extract($rowItemName);
                           echo"<option value='".$account_no."'>$account_no</option>";


                      }

                 }
            echo"</select>";

?>


