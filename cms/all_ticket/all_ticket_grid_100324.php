<?php
include_once '../header.php';
include_once '../../Library/dbconnect.php';
include_once '../../Library/Library.php';
//print_r($_POST);
session_start();
$SUserName = $_SESSION['SUserName'];
$SUserID = $_SESSION['SUserID'];
$SDesignation = $_SESSION['SDesignation'];
$division = $_SESSION['Sdivision'];
$district = $_SESSION['Sdistrict'];
$upozela = $_SESSION['Supozela'];
$pen = pick('tbl_progressstatus', 'duration', 'tbl_progressstatus.id=1');
$due = pick('tbl_progressstatus', 'duration', 'tbl_progressstatus.id=2');
$overdue = pick('tbl_progressstatus', 'duration', 'tbl_progressstatus.id=3');
?>
<link rel="stylesheet" href="jQueryTab8e83.css">
<style>
  body {
    background-color: #fff;
  }

  .info-box-icon-info {
    font-size: 15px;
    margin-top: 8px;
    /* margin-left: 9px; */
    z-index: 111;
    color: rgba(255, 252, 252, 1.00);
    line-height: 29px;
  }

  .input-group {
    position: relative !important;
  }

  .select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 18px;
  }

  .info {
    position: absolute;
    z-index: 9999;
    color: red;
    top: -11px;
    font-size: 9px;
    left: 40%;
  }

  .form-group {
    margin-top: 13px;
  }

  .select2-container--default .select2-selection--single,
  .select2-selection .select2-selection--single {
    border: 1px solid #d2d6de;
    border-radius: 0;
    padding: 4px 12px;
    height: 28px;
  }

  .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 22px;
    right: 3px;
  }

  .tabs li a:hover,
  .tabs li a:focus {
    text-decoration: none;
  }
</style>
<style>
  /* Absolute Center Spinner */
  .loading {
    position: fixed;
    z-index: 999999;
    height: 2em;
    width: 2em;
    overflow: show;
    margin: auto;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
  }

  /* Transparent Overlay */
  .loading:before {
    content: '';
    display: block;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(232, 232, 232, 0.98);
  }

  /* :not(:required) hides these rules from IE9 and below */
  .loading:not(:required) {
    /* hide "loading..." text */
    font: 0/0 a;
    color: transparent;
    text-shadow: none;
    background-color: transparent;
    border: 0;
  }

  .loading:not(:required):after {
    content: '';
    display: block;
    font-size: 15px;
    width: 1em;
    height: 1em;
    margin-top: -0.5em;
    color: #fff;
    -webkit-animation: spinner 1500ms infinite linear;
    -moz-animation: spinner 1500ms infinite linear;
    -ms-animation: spinner 1500ms infinite linear;
    -o-animation: spinner 1500ms infinite linear;
    animation: spinner 1500ms infinite linear;
    border-radius: 0.5em;
    -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
    box-shadow: rgba(0, 56, 104, 1.00) 1.5em 0 0 0,
      rgba(0, 56, 104, 1.00) 1.1em 1.1em 0 0,
      rgba(0, 56, 104, 1.00) 0 1.5em 0 0, rgba(0, 56, 104, 1.00) -1.1em 1.1em 0 0, rgba(0, 56, 104, 1.00) -1.5em 0 0 0, rgba(0, 56, 104, 1.00) -1.1em -1.1em 0 0, rgba(0, 56, 104, 1.00) 0 -1.5em 0 0, rgba(0, 56, 104, 1.00) 1.1em -1.1em 0 0;
  }

  /* Animation */
  @-webkit-keyframes spinner {
    0% {
      -webkit-transform: rotate(0deg);
      -moz-transform: rotate(0deg);
      -ms-transform: rotate(0deg);
      -o-transform: rotate(0deg);
      transform: rotate(0deg);
    }

    100% {
      -webkit-transform: rotate(360deg);
      -moz-transform: rotate(360deg);
      -ms-transform: rotate(360deg);
      -o-transform: rotate(360deg);
      transform: rotate(360deg);
    }
  }

  @-moz-keyframes spinner {
    0% {
      -webkit-transform: rotate(0deg);
      -moz-transform: rotate(0deg);
      -ms-transform: rotate(0deg);
      -o-transform: rotate(0deg);
      transform: rotate(0deg);
    }

    100% {
      -webkit-transform: rotate(360deg);
      -moz-transform: rotate(360deg);
      -ms-transform: rotate(360deg);
      -o-transform: rotate(360deg);
      transform: rotate(360deg);
    }
  }

  @-o-keyframes spinner {
    0% {
      -webkit-transform: rotate(0deg);
      -moz-transform: rotate(0deg);
      -ms-transform: rotate(0deg);
      -o-transform: rotate(0deg);
      transform: rotate(0deg);
    }

    100% {
      -webkit-transform: rotate(360deg);
      -moz-transform: rotate(360deg);
      -ms-transform: rotate(360deg);
      -o-transform: rotate(360deg);
      transform: rotate(360deg);
    }
  }

  @keyframes spinner {
    0% {
      -webkit-transform: rotate(0deg);
      -moz-transform: rotate(0deg);
      -ms-transform: rotate(0deg);
      -o-transform: rotate(0deg);
      transform: rotate(0deg);
    }

    100% {
      -webkit-transform: rotate(360deg);
      -moz-transform: rotate(360deg);
      -ms-transform: rotate(360deg);
      -o-transform: rotate(360deg);
      transform: rotate(360deg);
    }
  }
</style>
<style>
  .affectedDiv {}

  .affectedDiv .nav-tabs {
    border-bottom: none;
    margin: 10px 0;
  }

  .affectedDiv .nav-tabs>li {
    float: left;
    margin-bottom: 0px;
  }

  .affectedDiv .nav-tabs>li>a {
    margin-right: 6px;
    line-height: 1.42857143;
    border: none;
    border-radius: 50px;
    border-bottom: 1px !important;
    background: #333;
    font-size: 15px;
    color: #fff;
  }

  .affectedDiv .nav-tabs>li.active>a,
  .nav-tabs>li.active>a:focus,
  .nav-tabs>li.active>a:hover {
    color: #fff;
    cursor: default;
    background-color: #4698de;
    border: none;
    border-bottom-color: none;
  }

  .affectedDiv .nav-tabs>li>a:hover {
    border-color: none;
    background: #4698de;
  }

  li.active {
    background: none;
  }
</style>
<div class="loading" id="loading" style="">??? ????? …</div>
<div class="row">
  <form id="search">
    <div class="col-sm-12">

      <div class="form-group col-xs-1  pr0 ">
        <input type="text" name="txtfromopen_date" id="txtfromopen_date" class="form-control datetimepicker  input-sm" placeholder="From Date" value="<?php echo date('m/d/Y'); ?>" />
      </div>
      <div class="form-group col-xs-1 pl0 pr0 ">
        <input type="text" name="txttoopen_date" id="txttoopen_date" class="form-control datetimepicker  input-sm" placeholder="To Date" value="<?php echo date('m/d/Y'); ?>" />
      </div>
      <div class=" form-group col-xs-2">
        <select class="form-control input-sm select2" name='service_type' id='service_type' style="width:100%">
          <?php
          createCombo("সমস্যার ধরন", "tbl_service_type", "prob_id", "prob_name", " Order by prob_id", '');
          ?>
        </select>
      </div>
      <div class=" form-group col-sm-1 pl0 pr0">
        <?php if ($division > 0 && ($SDesignation != 1 && $SDesignation != 2 && $SDesignation != 3 && $SDesignation != 4 && $SDesignation != 5 && $SDesignation != 25 && $SDesignation != 34 && $SDesignation != 35)) { ?>
          <select class="form-control input-sm option1" disabled>
            <?php
            createCombo("বিভাগ", "tbl_division", "id", "name", " ORDER BY name ", $division);
            ?>
          </select>
          <input type="hidden" name="division_id" id="division_id" value="<?php echo $division; ?>">
        <?php
        } else { ?>
          <select name="division_id" id="division_id" class="form-control input-sm option1">
            <?php
            createCombo("বিভাগ", "tbl_division", "id", "name", " ORDER BY name ", $division);
            ?>
          </select>
        <?php } ?>
      </div>
      <div class=" form-group col-sm-1 pl0 pr0">
        <?php if ($district > 0) { ?>
          <select class="form-control input-sm option1" disabled>
            <?php
            createCombo("জেলা", "tbl_district", "id", "name", " where division_id=" . $division . " ORDER BY name ", $district);
            ?>
          </select>
          <input type="hidden" name="district" id="district" value="<?php echo $district; ?>">
          <?php } else {

          if ($division > 0) { ?>
            <select class="form-control input-sm option1" name="district" id="district">
              <?php
              createCombo("জেলা", "tbl_district", "id", "name", " where division_id=" . $division . " ORDER BY name ", $district);
              ?>
            </select>
          <?php
          } else {
          ?>
            <select name="district" id="district" class="form-control input-sm option1">
              <option value="-1">প্রথমে বিভাগ নির্বাচন করুন</option>
            </select>
        <?php }
        } ?>
      </div>
      <div class=" form-group col-sm-1 pl0 pr0">
        <?php if ($upozela > 0) { ?>
          <select class="form-control input-sm option1" disabled>
            <?php
            createCombo("জেলা", "tbl_upozila", "id", "name", " where district=" . $district . " ORDER BY name ", $upozela);
            ?>
          </select>
          <input type="hidden" name="upozila" id="upozila" value="<?php echo $upozela; ?>">
          <?php } else {
          if ($district > 0) {
          ?>
            <select class="form-control input-sm option1" name="upozila" id="upozila">
              <?php
              createCombo("উপজেলার/সার্কেলের নাম", "tbl_upozila", "id", "name", " where district=" . $district . " ORDER BY name ", $upozela);
              ?>
            </select>
          <?php
          } else {
          ?>
            <select name="upozila" id="upozila" class="form-control input-sm option1">
              <option value="-1">প্রথমে জেলা নির্বাচন করুন</option>
            </select>

        <?php }
        }

        ?>
      </div>
      <div class="form-group col-xs-2 ">
        <input type="text" name="filter" id="filter" class="form-control input-sm" placeholder="Search" />
      </div>
      <div class="col-sm-2 form-group">
        <button type="button" class="btn btn-primary btn-sm" onclick="btn5()"><i class="fa fa-search" aria-hidden="true"></i> দেখুন</button>

      </div>
      <input type="hidden" name="cond" value="<?php echo $_POST['cond'] ?>">
      <input type="hidden" name="type" value="<?php echo $_POST['type'] ?>">
    </div>
  </form>
</div>


<div id="view">

</div>




<div id="myModal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg large" role="document">
    <div class="modal-content">
      <!--MODAL CONTENT-->

    </div>
  </div>
</div>
<?php include_once '../footer.php'; ?>

<div class="col-sm-12">
  <div class="affectedDiv">
    <ul class="nav nav-tabs" id="myTab">
      <li class="active"><a data-toggle="tab" href="#tab40"><i class="fa fa-area-chart" aria-hidden="true"></i> &nbsp;নতুন </a></li>
      <li><a data-toggle="tab" href="#tab41"><i class="fa fa-area-chart" aria-hidden="true"></i> &nbsp;চলমান কল </a></li>
      <li><a data-toggle="tab" href="#tab42"><i class="fa fa-envira" aria-hidden="true"></i> &nbsp; নিষ্পন্ন</a></li>
      <li><a data-toggle="tab" href="#tab43"><i class="fa fa-filter " aria-hidden="true"></i> &nbsp; অভিযোগ</a></li>
    </ul>
    <div class="tab-content">
      <div id="tab40" class="tab-pane fade in active">

      </div>
      <div id="tab41" class="tab-pane fade">

      </div>
      <div id="tab42" class="tab-pane fade">

      </div>
      <div id="tab43" class="tab-pane fade">

      </div>
    </div>
  </div>
</div>


<div id="myModalsmall" style="width: 900px" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog " role="document" style="width: 900px">
    <div class="modal-content" id="small_modal" style="width: 900px">
      <!--MODAL CONTENT-->

    </div>
  </div>
</div>

<div id="note_success"></div>


<script>
  $(document).ready(function() {
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
      localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
      $('#myTab a[href="' + activeTab + '"]').tab('show');
    }
  });
</script>

<script>
  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip({
      placement: 'right'
    });
  });

  function priority_change(task_id) {
    //alert(task_id);
    $.ajax({
      type: "POST",
      url: "priority_modal.php",
      data: {
        task_id: task_id,
        shedule: 1,
        mode: 2
      },
      success: function(response) {
        $('#small_modal').html(response);
      }
    });
  }

  function status_modal(task_id) {
    //alert(task_id);
    $.ajax({
      type: "POST",
      url: "status_change_modal.php",
      data: {
        task_id: task_id,
        mode: 2
      },
      success: function(response) {
        $('#small_modal').html(response);
      }
    });
  }


  $(document).ready(function() {
    $('a.send').click(function() {
      var mid = $(this).data('id');
      var cid = $(this).data('client_id');
      // console.log(mid);
      // console.log(cid);
      $('body').append($('<form/>', {
        id: 'form',
        method: 'POST',
        action: 'ticket_details.php'
      }));

      $('#form').append($('<input/>', {
        type: 'hidden',
        name: 'id',
        value: mid
      }));

      $('#form').submit();
      return false;
    });
  });
</script>


<script type="text/javascript">
  function solution(task_id) {
    //alert(task_id);
    $.ajax({
      type: "POST",
      url: "solution_modal.php",
      data: {
        task_id: task_id,
        shedule: 1
      },
      success: function(response) {
        //alert ('edit');
        $('#notemodal').html(response);
      }
    });
  }
  var $loading = $('#loading').hide();
  $('#loading').hide();

  function sendData(url, view, page) {
    $loading.show();
    $.ajax({
      type: "GET",
      url: url,
      data: $('#search').serialize() + "&actionfunction=showData&page=" + page,
    }).done(function(msg) {
      $(view).html(msg);
      $loading.fadeOut(1000);
    }).fail(function(jqXHR, textStatus) {
      alert("Request failed: " + textStatus);
      $loading.fadeOut(1000);
    });
  }
  $(document).ready(function() {
    sendData("all_new_ticket_get.php", '#tab40', 1);
    sendData("all_running_ticket_get.php", '#tab41', 1);
    sendData("all_complete_ticket_get.php", '#tab42', 1);
    sendData("all_gmt_ticket_get.php", '#tab43', 1);
  });

  function btn4(task_id) {
    //alert(task_id);
    $.ajax({
      type: "POST",
      url: "scheduling_modal.php",
      data: {
        task_id: task_id,
        shedule: 2
      },
      success: function(response) {
        //alert ('edit');
        $('.modal-content').html(response);
      }
    });
  }

  function validateContact(id) {
    var valid = true;
    //alert(id);
    $(".info").html('');

    // if (id == 1) {
    //  alert($("#scheduled_to").val());
    if ($("#scheduled_to").val() < 1) {
      $("#scheduled_to-info").html("???? ??? ???? ?????????? ???????? ???? *");
      $("#scheduled_to").css('border', '1px solid #F96666');
      valid = false;
    }
    // }


    return valid;
  }

  function taskview(val) {
    w = 700;
    h = 500;
    var left = (screen.width / 2) - (w / 2);
    var top = (screen.height / 2) - (h / 2);
    var popit = window.open("../rpttaskhistory.php?task_id=" + val + "", 'console', 'status,scrollbars,width=650,height=350,top=' + top + ',left=' + left);
  }
  $('.select2').select2()
  $('.datetimepicker').datetimepicker({
    format: 'm/d/Y',
    timepicker: false
  });

  function btn9(task_id1) {
    $.ajax({
      type: "POST",
      url: "note_modal.php",
      data: {
        task_id1: task_id1,
        shedule: 2
      },
      success: function(response) {
        //alert ('edit');
        $('#notemodal').html(response);
      }
    });

  }


  $('#division_id').on('change', function() {
    var division_id = $('#division_id').val();
    var mode = '1';
    //alert(txtclients_id);
    if (division_id > 0) {
      $.ajax({
        type: "POST",
        url: "../../AjaxCode/loadajaxcombo.php?options=1&valueColumns=id,name",
        data: {
          mode: mode,
          division_id: division_id,
          table: 'tbl_district ',
          conditions: 'where division_id=' + division_id,
          firstText: 'জেলা নির্বাচন করুন',
        },
        success: function(response) {
          $('#district').html(response);
        }
      });
    } else {
      $('#district').html('');
    }
  });
  $('#district').on('change', function() {
    var district = $('#district').val();
    var mode = '1';
    //alert(txtclients_id);
    if (district > 0) {
      $.ajax({
        type: "POST",
        url: "../../AjaxCode/loadajaxcombo.php?options=1&valueColumns=id,name",
        data: {
          mode: mode,
          district: district,
          table: 'tbl_upozila ',
          conditions: 'where district=' + district,
          firstText: 'উপজেলার/সার্কেলের নাম নির্বাচন করুন',
        },
        success: function(response) {
          $('#upozila').html(response);
        }
      });
    } else {
      $('#upozila').html('');
    }
  });

  function btn5() {
    sendData("all_new_ticket_get.php", '#tab40', 1);
    sendData("all_running_ticket_get.php", '#tab41', 1);
    sendData("all_complete_ticket_get.php", '#tab42', 1);
    sendData("all_gmt_ticket_get.php", '#tab43', 1);
  }
</script>