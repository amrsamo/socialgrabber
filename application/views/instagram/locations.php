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
                    <input type="text" id="q" class="form-control" placeholder="Location/Keyword" <?= (isset($_GET['username']))? "value='".$_GET['username']."'" : '' ; ?>>
                    <span class="input-group-btn">
                      <button onclick="searchBtn();" class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            </form>

            <div class="clearfix"></div>

             <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Instagram Top Locations
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
                    <!-- <p class="text-muted font-13 m-b-30">
                     
                      <div class="alert alert-info">
                        <strong>Info!</strong> Select users and add them to list for further actions
                        <button onclick="addUsersToList();" class="btn btn-default pull-right" style="margin-top: -0.5%;">Add Users</button>
                      </div>
                     Select users and create lists for exporting data  
                    </p> -->
                    
                    <table id="datatable-responsive" class="table table-striped table-bordered bulk_action" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Location</th>
                          <th>Number of Posts</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (is_array($top_locations)): ?>
                          <?php $counter = 1; ?>
                          <?php foreach ($top_locations as $location): ?>
                          <tr>
                            <td><?= $counter; ?></td>
                            <td><?= $location->text ?></td>
                            <td><?= $location->count ?></td>
                            <td><a href=" <?= base_url(); ?>instagram/geolocation/<?= $location->id; ?> ">
                              <button>Browse</button>
                            </a></td>
                        </tr>
                        <?php $counter++; ?>
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
