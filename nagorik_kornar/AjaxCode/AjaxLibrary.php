<?php
session_start();
    include "../dbconnect.php";
?>

<?php
function SearchMasAO($PartyID)
        {

             echo"<select size='1' name='cmbAONo' onChange='SearchAmount(this)'>
                  <option value='-1'>Select...</option>";
                        $SAO="select
                                     AONO,
                                     AONO
                               from
                                     mas_ao
                               where
                                     PARTYID='".$PartyID."'
                              ";
                    // echo $SAO;
                    $resultAO=mysqli_query($conn, $SAO)or die(mysqli_error());
                    //$ss=mysqli_num_rows($resultAO);
                    //echo"<script language='javascript'>alert(\"".$ss."\");</script>";
                    while($rowAO=mysqli_fetch_array($resultAO))
                        {
                          extract($rowAO);
                          echo "<option value='$AONO'>$AONO</option>";
                        }
                        
             echo"</select>";

       }

function SearchAmount($AONo)
        {

                      $SAmount="select
                                     TOTALAMNT
                               from
                                     mas_ao
                               where
                                     AONO='".$AONo."'
                              ";
                    // echo $SAO;
                    $resultAmount=mysqli_query($conn, $SAmount)or die(mysqli_error());
                    //$ss=mysqli_num_rows($resultAO);
                    //echo"<script language='javascript'>alert(\"".$ss."\");</script>";
                    while($rowAmount=mysqli_fetch_array($resultAmount))
                        {
                          extract($rowAmount);
                          echo $TOTALAMNT;
                        }

      }
      
function SearchAccountNo($BID)
        {

             echo"<select size='1' name='cboAccountNo'>
                  <option value='-1'>Select...</option>";
                   $AccountNo="select
                                     AccessNo,
                                     AccessNo
                               from
                                     trn_bank
                               where
                                     BankID='".$BID."'
                              ";
                    // echo $SAO;
                    $resultAccountNo=mysqli_query($conn, $AccountNo)or die(mysqli_error());
                    //$ss=mysqli_num_rows($resultAO);
                    //echo"<script language='javascript'>alert(\"".$ss."\");</script>";
                    while($rowAccount=mysqli_fetch_array($resultAccountNo))
                        {
                          extract($rowAccount);
                          echo "<option value='$AccessNo'>$AccessNo</option>";
                        }

             echo"</select>";

       }
//call_user_func ($functionName,$UserID);
call_user_func_array($functionName,array($ID));

?>


