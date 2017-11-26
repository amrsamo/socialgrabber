       <?php $this->load->view('header'); ?>

        <input type="hidden" id="data_source" value="Instagram">
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">

              </div>

             

            <div class="clearfix"></div>

             <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>
                      <?= ucfirst($this->data['list'][0]->name); ?>
                    </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <!-- <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li> -->
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                      <?php if (isset($users) and is_array($users)): ?>
                      <div class="alert alert-info">
                        <strong>Info!</strong> Select users and perform actions
                        <button onclick="exportUnexportedUsers();" class="btn btn-default pull-right" style="margin-top: -0.5%;">Select Un-Exported Users</button>
                        <button onclick="exportAllUsers();" class="btn btn-default pull-right" style="margin-top: -0.5%;">Export All Users</button>
                        <button onclick="exportSelectedUsers();" class="btn btn-default pull-right" style="margin-top: -0.5%;">Export Selected Users</button>
                      </div>
                      <?php endif ?>
                    </p>
                    
                    <table id="datatable-responsive" class="table table-striped table-bordered bulk_action" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th><input type="checkbox" id="checkall" class=""></th>
                          <th>Username</th>
                          <th>Exported Before</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (isset($users) and is_array($users)): ?>
                          <?php foreach ($users as $user): ?>
                          <tr>
                            <td><input type="checkbox" class="check-item" value="<?= $user->username ?>" data-export="<?php 
                            if($user->export == 0)
                              echo '0';
                            else
                              echo '1';
                            ?>"></td>
                            <td><?= $user->username ?></td>
                            <td><?php if ($user->export == 0): ?>
                            <i style="color:red" class="fa fa-times" aria-hidden="true"></i>
                            <?php else: ?>
                              <i style="color:green" class="fa fa-check" aria-hidden="true"></i>
                            <?php endif ?>
                            </td>
                            <td><a target="_blank" href=" <?= base_url(); ?>instagram/user/<?= $user->username ?> ">
                              <button>Profile</button>
                            </a></td>
                        </tr>
                        <?php endforeach ?>
                        <?php else: ?>
                          <tr>
                            <td colspan="4" class="text-center">
                              No Results Found
                            </td>
                          </tr>
                        <?php endif ?>
                        
                      </tbody>
                    </table>
                    
                    
                  </div>
                </div>
              </div>
            
          </div>
        </div>
        <!-- page content -->




 <?php $this->load->view('footer'); ?>

 <script type="text/javascript">
   

 function searchBtn()
 {
    
    var q = $("#q").val();

    if(q == '')
      window.location = $("#base_url").val()+'instagram/users';
    else
    {
      var base_url = $("#base_url").val();
      window.location = base_url+'instagram/users?username='+q;
    }
 }


 function exportSelectedUsers()
  {
      var list = "";
      var flag = false;
      $(".check-item").each(function(){
          if($(this).is(":checked"))
          {   
              value = $(this).val();
              list += value+",";
              flag = true;
          }
      });

      if(flag)
      {   
          var base_url = $("#base_url").val();
          var current_url = $("#current_url").val();
          var data_source = $("#data_source").val();
          var target_url = base_url+'exportusers?current='+current_url+"&ids="+list+"&type="+data_source;
          
          window.location = target_url;
      }
      else
          alert('Please Select Users First');

  }


  function exportAllUsers()
  {   
      var table = $('#datatable-responsive').DataTable();

      var cells = table
          .cells( ":checkbox" )
          .nodes();



      $(cells).prop('checked', true);
      return;
      if (confirm("Export All Users in List?") == true)
      {
        var list = "";
        $(".check-item").each(function(){
                value = $(this).val();
                list += value+",";
        });
        var base_url = $("#base_url").val();
        var current_url = $("#current_url").val();
        var data_source = $("#data_source").val();
        var target_url = base_url+'exportusers?current='+current_url+"&ids="+list+"&type="+data_source;
        
        window.location = target_url;
      } 
      else
      {
        return false;
      }
      

  }


  function exportUnexportedUsers()
  {
      var list = "";
      var flag = false;
      $(".check-item").each(function(){
          var export_value = $(this).attr('data-export');
          if(export_value == '0')
          {   
              value = $(this).val();
              list += value+",";
              flag = true;
          }
      });

      if(flag)
      {   
          var base_url = $("#base_url").val();
          var current_url = $("#current_url").val();
          var data_source = $("#data_source").val();
          var target_url = base_url+'exportusers?current='+current_url+"&ids="+list+"&type="+data_source;
          
          window.location = target_url;
      }
      else
          alert('No Un-Exported Values Available');
  }

 </script>
