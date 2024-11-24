<style>
a:hover, a:focus {
  text-decoration: none;
  outline: none;
}
#accordion .panel {
  border: none;
  border-radius: 0;
  margin-bottom: 5px;
  box-shadow: none;
}
#accordion .panel-heading {
  padding: 0;
  border: none;
  border-radius: 0;
  position: relative;
}
#accordion .panel-title a {
  display: block;
  padding: 10px 10px;
  margin: 0;
  background: #0da25e;
  font-size: 17px;
  font-weight: bold;
  color: #fff;
  text-transform: uppercase;
  letter-spacing: 1px;
  position: relative;
}
#accordion .panel-title a:before, #accordion .panel-title a.collapsed:before {
  content: "";
  width: 20px;
  height: 2px;
  background: #fff;
  position: absolute;
  top: 18px;
  right: 30px;
}
#accordion .panel-title a:after, #accordion .panel-title a.collapsed:after {
  content: "";
  width: 2px;
  height: 20px;
  background: #fff;
  position: absolute;
  bottom: 9px;
  right: 39px;
  transition: all 0.3s ease 0s;
}
#accordion .panel-title a:after {
  height: 0;
}
#accordion .panel-body {
  padding: 10px 10px;
  background: #ffffff;
  border-bottom: 1px solid #0da25e;
  border-left: 1px solid #0da25e;
  border-right: 1px solid #0da25e;
  font-size: 15px;
  color: #333;
  line-height: 16px;
  letter-spacing: 1px;
}
</style>
<?php
ini_set('display_errors', 'Off');
error_reporting(E_ALL);
session_start();
$SUserID = $_SESSION['SUserID'];
include ('support_function.php');

header('Content-Type: text/html; charset=utf-8');

$info_type = $_REQUEST['service_type'];
$task_type = $_REQUEST['task_type'];
$txtcontact_person = $_REQUEST['txtcontact_person'];
$txtcontact_number = $_REQUEST['txtcontact_number'];
$division_id = $_REQUEST['division_id'];
$district = $_REQUEST['district'];
$upozila = $_REQUEST['upozila'];
$service_type = $_REQUEST['service_type'];

$txtcontact_person_no = $_REQUEST['txtcontact_person_no'];
$nid = $_REQUEST['nid'];
$dateOfBirth = $_REQUEST['dateOfBirth'];
$txtsubject = $_REQUEST['txtsubject'];
$txtdescription = $_REQUEST['txtdescription'];

$txtcontact_email = $_REQUEST['txtcontact_email'];

$txtaddress = $_REQUEST['txtaddress'];

$nid = $_REQUEST['nid'];
$date_of_birth = $_REQUEST['date_of_birth'];
$service_tag = $_REQUEST['service_tag'];

//Print_r($_REQUEST);
// exit;
if ($task_type > 0 && $txtcontact_person != '' && $txtcontact_number != '' && $division_id > 0 && $district > 0 && $upozila > 0 && $service_type > 0 && $service_tag > 0 )
{
  //echo 'sdsadad';

    if ($info_type == '20')
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_URL, 'https://ldtax.gov.bd/api/faq');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_ENCODING, "UTF-8");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"username":"hotline","password":"hotline16122"}');

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        $result = curl_exec($ch);

        if ($result === false)
        {

            echo 'Curl error: ' . curl_error($ch);
        }
        else
        {
            // $result = iconv("Windows-1251", "UTF-8", $result);
            // print_r( $result );
            $stories = json_decode($result, true);
            echo '<div class="panel-group" id="accordion">';
            $i = 0;
            foreach ($stories as $key => $story)
            {
                if (is_array($story))
                {
                    foreach ($story as $subkey => $subvalue)
                    {
                        if (is_array($subvalue))
                        {

                            foreach ($subvalue as $key => $subsubvalue)
                            {
                                if ($i == 0)
                                {
                                    $colus = '';
                                }
                                else
                                {
                                    $colus = 'collapsed';
                                }
                                if ($key == 'question')
                                {
                                    echo '<div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#con' . $i . '" class="' . $colus . '">' . $subsubvalue . '</a> </h4>
              </div>';

                                }
                                else
                                {
                                    if ($i == 0)
                                    {
                                        $ser = 'in';
                                    }
                                    else
                                    {
                                        $ser = '';
                                    }
                                    echo '<div id="con' . $i . '" class="panel-collapse collapse ' . $ser . '">
                <div class="panel-body">' . $subsubvalue . '</div>
              </div>
              </div>';
                                    $i++;
                                }

                                //echo $key . $subsubvalue . "<br />";
                                
                            }
                        }
                        else
                        {
                            //echo $subvalue . "<br />";
                            
                        }
                    }
                }
                else
                {
                    //echo $story . "<br />";
                    
                }

            }
            echo '</div>';
        }
        curl_close($ch);
        call_success( $SUserID, $txtcontact_number, $txtcontact_person, $service_type, $txtsubject, $txtdescription, $txtcontact_email, $txtaddress, $division_id, $district, $upozila, "", $txtcontact_person_no, $nid, $dateOfBirth,$service_tag );
        
    }
    elseif ($info_type == '21')
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_URL, 'https://www.eporcha.gov.bd/api/v1/faq/list');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_ENCODING, "UTF-8");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, 1);
        $result = curl_exec($ch);

        if ($result === false)
        {

            echo 'Curl error: ' . curl_error($ch);
        }
        else
        {
            // $result = iconv("Windows-1251", "UTF-8", $result);
            //print_r( $result );
            $stories = json_decode($result, true);
            echo '<div class="panel-group" id="accordion">';
            foreach ($stories as $key => $story)
            {
                if (is_array($story))
                {
                    foreach ($story as $subkey => $subvalue)
                    {
                        if (is_array($subvalue))
                        {
                            foreach ($subvalue as $key => $subsubvalue)
                            {
                                if ($i == 0)
                                {
                                    $colus = '';
                                }
                                else
                                {
                                    $colus = 'collapsed';
                                }
                                if ($key == 'question')
                                {
                                    echo '<div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#con' . $i . '" class="' . $colus . '">' . $subsubvalue . '</a> </h4>
              </div>';

                                }
                                else
                                {
                                    if ($i == 0)
                                    {
                                        $ser = 'in';
                                    }
                                    else
                                    {
                                        $ser = '';
                                    }
                                    echo '<div id="con' . $i . '" class="panel-collapse collapse ' . $ser . '">
                <div class="panel-body">' . $subsubvalue . '</div>
              </div>
              </div>';
                                    $i++;
                                }
                            }
                        }
                        else
                        {
                        }
                    }
                }
                else
                {
                }

            }
            echo '</div>';
        }
        curl_close($ch);
         call_success( $SUserID, $txtcontact_number, $txtcontact_person, $service_type, $txtsubject, $txtdescription, $txtcontact_email, $txtaddress, $division_id, $district, $upozila, "" , $txtcontact_person_no, $nid, $dateOfBirth,$service_tag );
        
    }
    elseif ($info_type == '19')
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://mutation-api-stage.land.gov.bd/api/getToken',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'username=mutation_api&password=a2i%40myGov&clientid=myGov',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ) ,
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $r = json_decode($response, true);

        $r['token'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://mutation-api-stage.land.gov.bd/api/get-fag',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'APIAuthorization: ' . $r['token'],
                'Content-Type: application/json'
            ) ,
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $stories = json_decode($response, true);

        echo '<div class="panel-group" id="accordion">';
        foreach ($stories as $key => $story)
        {
            if (is_array($story))
            {
                foreach ($story as $subkey => $subvalue)
                {
                    if (is_array($subvalue))
                    {
                        foreach ($subvalue as $key => $subsubvalue)
                        {
                            if ($i == 0)
                            {
                                $colus = '';
                            }
                            else
                            {
                                $colus = 'collapsed';
                            }
                            if ($key == 'question')
                            {
                                echo '<div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#con' . $i . '" class="' . $colus . '">' . $subsubvalue . '</a> </h4>
              </div>';

                            }
                            else
                            {
                                if ($i == 0)
                                {
                                    $ser = 'in';
                                }
                                else
                                {
                                    $ser = '';
                                }
                                echo '<div id="con' . $i . '" class="panel-collapse collapse ' . $ser . '">
                <div class="panel-body">' . $subsubvalue['0'] . '</div>
              </div>
              </div>';
                                $i++;
                            }
                        }
                    }
                    else
                    {
                    }
                }
            }
            else
            {
            }

        }
        echo '</div>';
        call_success( $SUserID, $txtcontact_number, $txtcontact_person, $service_type, $txtsubject, $txtdescription, $txtcontact_email, $txtaddress, $division_id, $district, $upozila, "", $txtcontact_person_no, $nid, $dateOfBirth ,$service_tag );
        
    }

    elseif ($info_type == '22')
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://prottoyon.olivineltd.com/api/faq',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => '{
  "userName": "SsoOL&",
  "password": "SsO@Olivine"
  }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ) ,
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        //echo $response;
        $stories = json_decode($response, true);
        /*echo '<pre>';
        print_r($stories);
        echo '</pre>';  */
        echo '<div class="panel-group" id="accordion">';
        foreach ($stories as $key => $story)
        {
            if (is_array($story))
            {
                foreach ($story as $subkey => $subvalue)
                {
                    if (is_array($subvalue))
                    {
                        foreach ($subvalue as $key => $subsubvalue)
                        {
                            if ($i == 0)
                            {
                                $colus = '';
                            }
                            else
                            {
                                $colus = 'collapsed';
                            }
                            if ($key == 'question')
                            {
                                echo '<div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#con' . $i . '" class="' . $colus . '">' . $subsubvalue . '</a> </h4>
            </div>';

                            }
                            else
                            {
                                if ($i == 0)
                                {
                                    $ser = 'in';
                                }
                                else
                                {
                                    $ser = '';
                                }
                                echo '<div id="con' . $i . '" class="panel-collapse collapse ' . $ser . '">
                <div class="panel-body">' . $subsubvalue . '</div>
              </div>
              </div>';
                                $i++;
                            }
                        }
                    }
                    else
                    {
                    }
                }
            }
            else
            {
            }

        }
        echo '</div>';
        call_success($SUserID, $txtcontact_number, $txtcontact_person, $service_type, $txtsubject, $txtdescription, $txtcontact_email, $txtaddress, $division_id, $district, $upozila, "", $txtcontact_person_no, $nid, $dateOfBirth, $service_tag);

    }
    else
    {
        echo "<h1 class='text-center'>কোন তথ্য পাওয়া যায়নি</h1>";
    }
}
else
{
    echo "<h1 class='text-center'> সকল তথ্য প্রয়োজনীয়</h1>";
}

?>
