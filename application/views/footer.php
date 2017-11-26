 <!-- footer content -->
        <footer>
          <div class="pull-right">
            InstaDevHouse <a href="http://skydevhouse.com"> SkyDevHouse</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="<?= base_url(); ?>public/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?= base_url(); ?>public/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?= base_url(); ?>public/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?= base_url(); ?>public/vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="<?= base_url(); ?>public/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="<?= base_url(); ?>public/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?= base_url(); ?>public/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="<?= base_url(); ?>public/vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="<?= base_url(); ?>public/vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="<?= base_url(); ?>public/vendors/Flot/jquery.flot.js"></script>
    <script src="<?= base_url(); ?>public/vendors/Flot/jquery.flot.pie.js"></script>
    <script src="<?= base_url(); ?>public/vendors/Flot/jquery.flot.time.js"></script>
    <script src="<?= base_url(); ?>public/vendors/Flot/jquery.flot.stack.js"></script>
    <script src="<?= base_url(); ?>public/vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="<?= base_url(); ?>public/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="<?= base_url(); ?>public/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="<?= base_url(); ?>public/vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="<?= base_url(); ?>public/vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="<?= base_url(); ?>public/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="<?= base_url(); ?>public/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="<?= base_url(); ?>public/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?= base_url(); ?>public/vendors/moment/min/moment.min.js"></script>
    <script src="<?= base_url(); ?>public/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>


     <!-- Datatables -->
    <script src="<?= base_url(); ?>public/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>public/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>public/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url(); ?>public/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>public/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?= base_url(); ?>public/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= base_url(); ?>public/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?= base_url(); ?>public/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="<?= base_url(); ?>public/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?= base_url(); ?>public/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url(); ?>public/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="<?= base_url(); ?>public/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="<?= base_url(); ?>public/vendors/jszip/dist/jszip.min.js"></script>
    <script src="<?= base_url(); ?>public/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?= base_url(); ?>public/vendors/pdfmake/build/vfs_fonts.js"></script>


    <script src="<?= base_url(); ?>public/vendors/iCheck/icheck.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?= base_url(); ?>public/build/js/custom.min.js"></script>
    
    <script type="text/javascript">
        
        $("#checkall").change(function(){
            
            if($(this).is(":checked"))
            {
                $(".check-item").each(function(){
                    // $(this).attr("checked", '1');
                    $(this).prop('checked', true);
                });
            }
            else
            {
                $(".check-item").each(function(){
                    // $(this).attr("checked", '1');
                    $(this).prop('checked', false);
                });
            }

        })


        function addUsersToList()
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
                var target_url = base_url+'adduserstolist?current='+current_url+"&ids="+list+"&type="+data_source;
                
                window.location = target_url;
            }
            else
                alert('Please Select Users First');

        }
    </script>

  </body>
</html>
