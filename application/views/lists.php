 <?php include('header.php') ?>     
        <div class="right_col" role="main">
          <div class="">
            <!-- <div class="page-title">
              <div class="title_left">

              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search All Users">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>
              
            </div> -->

            <div class="clearfix"></div>

             <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>My Lists
                      <small> 
                      Your created custom lists for further actions 
                      </small>
                    </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     <!--  <li class="dropdown">
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
                    
                    
                    <table id="datatable-responsive" class="table table-striped table-bordered bulk_action" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>List Name</th>
                          <th>Data Source</th>
                          <th>Users Count</th>
                          <th>Creation Date</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($lists as $list): ?>
                          <tr>
                            <td><?= $list->name ?></td>
                            <td><?= $list->source ?></td>
                            <td><?= $list->count ?></td>
                            <td><?= $list->creation_date ?></td>
                            <td><a href=" <?= base_url(); ?>instagram/customlist/<?= $list->id; ?> ">
                              <button>Go To List</button>
                            </a></td>
                        </tr>
                        <?php endforeach ?>
                      </tbody>
                    </table>
                    
                    
                  </div>
                </div>
              </div>
            
          </div>
        </div>
        <!-- page content -->





<?php include('footer.php') ?>