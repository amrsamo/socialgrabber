       <?php $this->load->view('header'); ?>

        <input type="hidden" id="data_source" value="Instagram">
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">

              </div>

              <form id="search_form" method="get" action="<?= base_url() ?>instagram/users">
              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    
                  </div>
                </div>
              </div>
            </div>
            </form>

            <div class="clearfix"></div>

             <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Instagram Location ( <?= $location->text ?> )
                    </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                     
                      <div class="alert alert-info">
                        <strong>Info!</strong> Select users and add them to list for further actions
                        <button onclick="addUsersToList();" class="btn btn-default pull-right" style="margin-top: -0.5%;">Add Users</button>
                      </div>
                     Select users and create lists for exporting data  
                    </p>
                    
                    <table id="datatable-responsive" class="table table-striped table-bordered bulk_action" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th><input type="checkbox" id="checkall" class=""></th>
                          <th>Username</th>
                          <th>Followers</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (is_array($users)): ?>
                          <?php foreach ($users as $user): ?>
                          <tr>
                            <td><input type="checkbox" class="check-item" value="<?= $user->user_id; ?>"></td>
                            <td><?= $user->username ?></td>
                            <td><?= $user->followers ?></td>
                            <td><a href=" <?= base_url(); ?>instagram/user/<?= $user->username; ?> ">
                              <button>Profile</button>
                            </a></td>
                        </tr>
                        <?php endforeach ?>
                        <?php else: ?>
                          <tr>
                            <td span="4">
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

 </script>
