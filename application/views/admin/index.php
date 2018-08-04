<script>

    var BASE_URL = '<?php echo base_url(); ?>';
    var IMAGE_URL = '<?php echo base_url('index.php/admin/get_file/'); ?>';
    var IMAGE_TAGS = '<?php echo base_url('index.php/admin/get_img_tags/'); ?>';
    var IMAGE_DETAILS = '<?php echo base_url('index.php/admin/get_img_details/'); ?>';

    var treeData = <?php echo json_encode($files); ?>;

    function image_details(file) {
        $("#img_details").html('');
        $.getJSON(file, function (result) {
            $.each(result, function (i, field) {
                if (typeof field == 'object') {
                    $("#img_details").append("<p><strong class='d-label'>" + i + ":</strong></p>");
                    $.each(field, function (k, v) {
                        $("#img_details").append("<p><strong class='d-label'>" + k + ": </strong>" + v + "</p>");
                    });
                } else {
                    $("#img_details").append("<p><strong class='d-label'>" + i + ": </strong>" + field + "</p>");
                }
            });
        });
    }

    function image_tags(file) {
        $('#img_title').val('');
        
        var remove_tags = $('#img_tag').val().split(',');
        if(remove_tags.length > 0){
            $.each(remove_tags, function (k, tag) {
                $('#img_tag').removeTag(tag);
            });
        }
            
            
        $.getJSON(file, function (result) {
            $('#img_title').val(result.title);
            
            if(result.tags !== null){
                var add_tags = result.tags.split(',');
                if(add_tags.length > 0){
                    $.each(add_tags, function (k, tag) {
                        $('#img_tag').addTag(tag, {focus: true, unique: true});
                    });
                }
            }
            

        });
        
        $('#playground').show();
    }

    $(function () {

        // --- Initialize sample trees
        $("#tree").dynatree({
            //checkbox: true,
            // Override class name for checkbox icon:
            classNames: {checkbox: "dynatree-radio"},
            selectMode: 1,
            children: treeData,
            onActivate: function (node) {
                $('#playground').hide();
                var path = '';
                $(node._parentList()).each(function (i, e) {
                    path += e.data.title + "/";
                });
                var file = path + node.data.title;
                var img_path = IMAGE_URL + '?file=' + file + '&size=450X450';
                
                $('.node_data_title').html('');
                $('.node_data_title').html(node.data.title);
                $('#img_path').attr('src',img_path);
                $('#img_tag').data('img',file);
                
                image_tags(IMAGE_TAGS + '?file=' + file);
                
                image_details(IMAGE_DETAILS + '?file=' + file);
            },
            onSelect: function (select, node) {
                // Display list of selected nodes
                
                var s = node.tree.getSelectedNodes().join(", ");
                //$("#echoSelection1").text(s);
            },
            onDblClick: function (node, event) {
                node.toggleSelect();
            },
            onKeydown: function (node, event) {
                if (event.which == 32) {
                    node.toggleSelect();
                    return false;
                }
            },
            // The following options are only required, if we have more than one tree on one page:
            //			initId: "treeData",
            cookieId: "dynatree-Cb1",
            idPrefix: "dynatree-Cb1-"
        });
    });
</script>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">
        <?php echo $header; ?>
        <!-- Full Width Column -->
        <div class="content-wrapper">
            <div class="container">
                <section class="content-header">
                    <h1>
                        Documents
                        <small></small>
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content" id="main_container">
                    <div class="row">
                        <div class="col-md-3">
                            <div id="tree" style="resize: both;height: 550px;"></div>
                        </div>
                        <div class="col-md-9">
                            <div id="playground" style="display: none;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box box-widget">
                                            <div class="box-header with-border">
                                                <div class="user-block">
                                                    <span class="node_data_title">Loading...</span>
                                                </div>
                                                <div class="box-tools">
                                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="box-body">
                                                <img class="img-responsive pad" id="img_path" src="" alt="Photo">
                                                <button id="save_tag" type="button" class="btn btn-default btn-xs"><i class="fa fa-plus"></i> Save</button>
                                            </div>
                                            <div class="box-footer">
                                                <div class="img-push">
                                                    <input id="img_title" name="img_title" type="text" class="form-control input-sm" placeholder="Title of Image">
                                                </div>              
                                                <div class="img-push">
                                                    <input id="img_tag" name="img_tag" data-img="" type="text" class="form-control input-sm" placeholder="Press enter to post comment">
                                                </div>
                                            </div>
                                            <div class="box-footer">
                                                <p><strong>Details:</strong></p>
                                                <div class="img-push" id=img_details>

                                                </div>
                                                </di>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.container -->
        </div>
        <?php echo $footer; ?>
    </div>
    <!-- ./wrapper -->

    <!-- Bootstrap 3.3.6 -->
    <script src="<?php echo base_url('/assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <!-- SlimScroll -->
    <script src="<?php echo base_url('/assets/plugins/slimScroll/jquery.slimscroll.min.js'); ?>"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url('/assets/plugins/fastclick/fastclick.js'); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url('/assets/dist/js/app.min.js'); ?>"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url('/assets/dist/js/demo.js'); ?>"></script>
    <script src="<?php echo base_url('/assets/dist/js/tiff.js'); ?>"></script>
    <script>

    $(function () {
        //$('#playground').on('change', '#img_tag', function () {
            $('#img_tag').tagsInput({width: 'auto'});
        //});
    });
    $(document).ready(function () {
        $('#playground').on('click', '#save_tag', function () {
            var img = $('input[name="img_tag"]').data('img');
            var tags = $('input[name="img_tag"]').val();
            var title = $('#img_title').val();
            $.ajax({
                url: BASE_URL + 'index.php/admin/saveTag',
                data: {
                    'img': img,
                    'title': title,
                    'tags': tags
                },
                success: function (e) {
                    bootbox.alert(e);
                },
            });
        });
    });

    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
</body>
</html>