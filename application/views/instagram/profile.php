<?php $this->load->view('header'); ?>

<style type="text/css">
  .right_col{
    min-height: 0px !important;
  }
</style>
        
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <!-- <div class="title_left">
                <h3>User Profile</h3>
              </div> -->

              <!-- <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div> -->
            </div>
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>User Report <small>Activity report</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li>
                        <h2 class="favorites_success" style="margin-right:20px;display: none;"><i class="fa fa-check-square-o" aria-hidden="true"></i> Favorites</h2>
                        <?php if (isset($user->favorites)): ?>
                          <h2 style="margin-right:20px;"><i class="fa fa-check-square-o" aria-hidden="true"></i> Favorites</h2>
                        <?php else: ?>
                          <button onclick="addUserToFavorites('<?= $user->username; ?>','favorites');" class="myBtn btn btn-default favorites_btn">Add To Favorites List</button>
                        <?php endif ?>
                        
                      </li>
                      <li>
                        <h2 class="curated_success" style="margin-right:20px;display: none;"><i class="fa fa-check-square-o" aria-hidden="true"></i> Curated</h2>
                        <?php if (isset($user->curated)): ?>
                          <h2 style="margin-right:20px;"><i class="fa fa-check-square-o" aria-hidden="true"></i> Curated</h2>
                        <?php else: ?>
                          <button onclick="addUserToFavorites('<?= $user->username; ?>','curated');" class="myBtn btn btn-default curated_btn">Add To Curated List</button>
                        <?php endif ?>
                      </li>
                      <li>
                        <button onclick="addUserToList(<?= $user->id; ?>);" class="myBtn btn btn-default">Add To Custom List</button>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                      <div class="profile_img">
                        <div id="crop-avatar">
                          <!-- Current avatar -->
                          <img style="width:100%;" class="img-responsive img-thumbnail" src="<?= $user->profilePicUrl ?>" alt="Avatar" title="Change the avatar">
                        </div>
                      </div>
                      <h3><?= $user->fullName; ?></h3>

                      <ul class="list-unstyled user_data">
                        <li><i class="fa fa-map-marker user-profile-icon"></i>
                        <?php if (!empty($location)): ?>
                          <?= $location->country.' '.$location->city ?>
                        <?php else: ?>
                          Not Available
                        <?php endif ?>
                        </li>

                        <li>
                          <i class="fa fa-briefcase user-profile-icon"></i>
                          <?= $user->hashtag ?>
                        </li>

                        <li class="m-top-xs">
                          <i class="fa fa-external-link user-profile-icon"></i>
                          <a href="http://www.kimlabs.com/profile/" target="_blank">
                            <?php if ($user->externalUrl != ""): ?>
                              <?= $user->externalUrl ?>
                            <?php else: ?>
                              <?= $user->url; ?>
                            <?php endif ?>
                            
                          </a>
                        </li>
                      </ul>

                      <!-- <a class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Update Profile</a> -->
                      <br />

                      <!-- start skills -->
                      <p>
                              <?= $user->biography; ?>
                            </p>
                      
                      <!-- end of skills -->



                    </div>
                    <div class="col-md-9 col-xs-12 widget_tally_box">
                        <div class="x_panel">
                          <div class="x_content">
                            <h1 class="name"><?= $user->username; ?></h1>

                            <div class="flex">
                              <ul class="list-inline count2">
                                <li>
                                  <h3><?= $user->mediaCount ?></h3>
                                  <span>Posts</span>
                                </li>
                                <li>
                                  <h3><?= $user->followers ?></h3>
                                  <span>Followers</span>
                                </li>
                                <li>
                                  <h3><?= $user->followsCount ?></h3>
                                  <span>Following</span>
                                </li>
                              </ul>
                            </div>

                            
                          </div>
                        </div>
                      </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">

                      <div class="profile_title">
                        
                          <div class="col-md-12">
                            <div class="">
                              <div class="x_content">
                                <div class="row">
                                  <div class="animated flipInY col-lg-4 col-md-3 col-sm-6 col-xs-12">
                                    <div class="tile-stats">
                                      <div class="icon"><i class="fa fa-caret-square-o-right"></i>
                                      </div>
                                      <div class="count"><?= ceil($engagement_rate); ?> %</div>

                                      <h3>Engagement Rate</h3>
                                      <p>(avg.likes+avg.comments)/followers</p>
                                    </div>
                                  </div>
                                  <div class="animated flipInY col-lg-4 col-md-3 col-sm-6 col-xs-12">
                                    <div class="tile-stats">
                                      <div class="icon"><i class="fa fa-comments-o"></i>
                                      </div>
                                      <div class="count"><?= $total_comments ?></div>

                                      <h3>Total Comments</h3>
                                      <p>based on recent posts.</p>
                                    </div>
                                  </div>
                                  <div class="animated flipInY col-lg-4 col-md-3 col-sm-6 col-xs-12">
                                    <div class="tile-stats">
                                      <div class="icon"><i class="fa fa-thumbs-o-up"></i>
                                      </div>
                                      <div class="count"><?= $total_likes; ?></div>

                                      <h3>Total Likes</h3>
                                      <p>based on recent posts.</p>
                                    </div>
                                  </div>
                                </div>

                              </div>
                            </div>
                          </div>
                      </div>

                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                          <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Recent Posts</a>
                          </li>
                          <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Hashtags</a>
                          </li>
                          <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Profile</a>
                          </li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                          <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                            <!-- start recent activity -->
                            <ul class="messages">
                              <?php foreach ($user_posts as $post): ?>
                                <li>
                                <img src="<?= $post->image_low_url ?>" class="avatar" alt="Avatar">
                                <div class="message_date">
                                  <h3 class="date text-info"><?=  date('j', $post->created_time_instagram); ?></h3>
                                  <p class="month"><?=  date('M', $post->created_time_instagram); ?></p>
                                </div>
                                <div class="message_wrapper">
                                  <h4 class="heading"><?= $post->caption_only; ?></h4>
                                  <blockquote class="message">
                                    <?php if (is_array($post->caption_hashtags)): ?>
                                    <?php foreach ($post->caption_hashtags as $x): ?>
                                      #<?= $x  ?> 
                                    <?php endforeach ?>
                                    <?php endif ?>
                                  </blockquote>
                                  <br />
                                  <p class="url">
                                    <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
                                    <a target="_blank" href="https://www.instagram.com/p/<?= $post->code; ?>/"><i class="fa fa-instagram"></i> Check post on Instagram </a>
                                  </p>
                                </div>
                              </li>
                              <?php endforeach ?>
                            </ul>
                            <!-- end recent activity -->

                          </div>
                          <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                            <input name="list-users" id="tags_1" type="text" class="tags form-control" value="<?php 

                            foreach ($hashtags as $x) {
                              echo $x->text.',';
                            }

                           ?>" />

                          </div>
                          <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                            <div class="col-md-12 col-sm-6 col-xs-12">
                              <?php 
                                printme($user);

                               ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
        <input type="hidden" id="data_source" value="Instagram">
<style type="text/css">
  #tags_1_tagsinput{
    height: auto !important;
    min-height: 0px !important;
  }
  .tagsinput{
    border:none;
  }
</style>
 <?php $this->load->view('footer'); ?>


<script type="text/javascript">
  function addUserToList(id)
  {   

      var list = id+",";
      var base_url = $("#base_url").val();
      var current_url = $("#current_url").val();
      var data_source = $("#data_source").val();
      var target_url = base_url+'adduserstolist?current='+current_url+"&ids="+list+"&type="+data_source;
      
      window.location = target_url;
      

  }

  function addUserToFavorites(id,name)
  {
    var r = confirm("User will be added to your "+name+" list, Confirm?");
    if (r == true) {
      var base_url = $("#base_url").val();
      targetURL = base_url+'instagram/addusertofavorites';
      $.ajax({
      url: targetURL,
      method: "POST",
      data: { user: id, list:name }, 
      success: function(result)
          {
            $("."+name+"_btn").hide();
            $("."+name+"_success").css('display','');
          }
      });
    } 
  }
</script>


 <script src="<?= base_url(); ?>public/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
<!-- <script src="<?= base_url(); ?>public/vendors/switchery/dist/switchery.min.js"></script> -->

 