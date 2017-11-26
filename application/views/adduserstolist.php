 <?php include('header.php') ?>


<!-- page content -->
        <div class="right_col" role="main">
         <div>
            <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add Users To List <small>create your own lists in order to perform futher actions</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="form-id" class="form-horizontal form-label-left" method="post" action="#">
                      <div class="form-group">
                        <div class="errordiv alert alert-warning hide" style="color:white">
                           
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select List</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select id="select_list" name="list_id" class="form-control" required>
                            <option value="-1"></option>
                            <option value="0">New List</option>
                            <?php if (!empty($admin_lists)): ?>
                              <?php foreach ($admin_lists as $list): ?>
                                <?php if ($list->name != 'favorites' and $list->name != 'curated'): ?>
                                  <option value="<?= $list->id; ?>"><?= $list->name; ?></option>
                                <?php endif ?>
                              <?php endforeach ?>
                            <?php endif ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">List Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" id="list_name" name="list-name" class="form-control" placeholder="A unqiue name to remember your list" disabled<?php if(isset($success)) echo 'value="'.$post['list-name'].'" disabled'; ?>>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Data Source </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" name="list-source" class="form-control" disabled="disabled" placeholder="<?= $data_source; ?>">
                        </div>
                      </div>
                      
                      

                      <div class="control-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Input Usernames</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input name="list-users" id="tags_1" type="text" class="tags form-control" value="<?php 
                          
                          foreach ($users as $user) {
                            echo $user->username.',';
                          }

                          ?>" />
                          <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                        </div>
                      </div>

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <input type="hidden" id="prev_url" value="<?= $previous_url; ?>">
                          <?php if (isset($success)): ?>
                            <div class="alert alert-success">
                              <strong>Success!</strong> <?= $success; ?>
                              <a style="color:white" href="<?= $previous_url; ?>" class="pull-right">
                                Return to Previous Page
                              </a>
                            </div>
                          <?php else: ?>
                            <button type="button" onclick="cancelBtn();" class="btn btn-primary">Cancel</ button>
                            <button id="save_Btn" type="submit" class="btn btn-success">Save</button>
                          <?php endif ?>
                          
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
         </div>
        </div>
        <!-- /page content -->


 <?php include('footer.php') ?>
 <!-- jQuery Tags Input -->
    <script src="<?= base_url(); ?>public/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <script src="<?= base_url(); ?>public/vendors/switchery/dist/switchery.min.js"></script>


    <script type="text/javascript">
      function cancelBtn()
      {
        var check = confirm("Are You Sure ?");
        if(check == true)
        {
          var prev_url = $("#prev_url").val();
          window.location = prev_url;
        }
      }

      $("#select_list").change(function(){
        var value = $(this).val();

        if(value == 0)
        {
          $("#list_name").prop('disabled', false);
        }
        else
        {
          $("#list_name").prop('disabled', true);
          $("#list_name").val('');
        }
      });


      $("#save_Btn").click(function(e){

        $(".errordiv").addClass('hide');
        var value = $("#select_list").val();
        if(value == -1)
        {
          e.preventDefault();
          $(".errordiv").html('Please Select List First');
          $(".errordiv").removeClass('hide');
          // alert('Please Select List First');
        }
        if(value == 0)
        {
          var value = $("#list_name").val();
          if(value == '')
          {
            e.preventDefault();
            $(".errordiv").html('Please Enter a List Name');
            $(".errordiv").removeClass('hide');
            // alert('Please Enter a List Name');
          }
          else
          {
            e.preventDefault();
            var base_url = $("#base_url").val();
            var admin_id = $("#admin_id").val();
            var targetURL = base_url+'checklistname';
            $.ajax({
                url: targetURL,
                method: "POST",
                data: { admin: admin_id, list_name : value }, 
                success: function(result)
                {
                  if(result === 'false')
                  {
                    $(".errordiv").html('List name has already been used, please choose another name');
                    $(".errordiv").removeClass('hide');
                  }
                  else
                  {
                    // e.submit();
                    $("#form-id").submit();
                  }
                }
              });
          }
        }
        
      });
    </script>
