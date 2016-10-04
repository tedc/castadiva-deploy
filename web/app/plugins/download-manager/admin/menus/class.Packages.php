<?php


namespace WPDM\admin\menus;


class Packages
{

    function __construct()
    {

        add_action('wp_ajax_wpdm_admin_upload_file', array($this, 'uploadFile'));
        add_action('save_post', array($this, 'savePackage'));

        add_action('manage_wpdmpro_posts_columns', array($this, 'columnsTH'));
        add_action('manage_wpdmpro_posts_custom_column', array($this, 'columnsTD'), 10, 2);

        add_filter( 'request', array($this, 'orderbyDownloads') );
        add_filter( 'manage_edit-wpdmpro_sortable_columns', array($this, 'sortableDownloads') );

        add_filter('post_row_actions', array($this, 'rowActions'), 10, 2);

        add_action('post_submitbox_misc_actions', array($this, 'downloadPeriod'));


    }

    function savePackage($post)
    {
        if(!current_user_can('edit_posts', $post)) return;
        if (get_post_type() != 'wpdmpro' || !isset($_POST['file'])) return;

        check_license();

        // Deleted old zipped file
        $zipped = get_post_meta($post, "__wpdm_zipped_file", true);
        if($zipped!='' && file_exists($zipped)) { @unlink($zipped); }

        $cdata = get_post_custom($post);
        foreach ($cdata as $k => $v) {
            $tk = str_replace("__wpdm_", "", $k);
            if (!isset($_POST['file'][$tk]) && $tk !== $k)
                delete_post_meta($post, $k);

        }

        foreach ($_POST['file'] as $meta_key => $meta_value) {
            $key_name = "__wpdm_" . $meta_key;
            if($meta_key == 'package_dir' && $meta_value != '') { $meta_value = realpath($meta_value); }
            update_post_meta($post, $key_name, $meta_value);
        }

        if(get_post_meta($post, '__wpdm_masterkey', true) == '')
            update_post_meta($post, '__wpdm_masterkey', uniqid());

        if (isset($_POST['reset_key']) && $_POST['reset_key'] == 1)
            update_post_meta($post, '__wpdm_masterkey', uniqid());

        if(isset($_REQUEST['reset_udl'])) delete_post_meta($post, '__wpdmx_user_download_count');
        //do_action('after_update_package',$post, $_POST['file']);


    }


    function uploadFile(){
        check_ajax_referer('wpdm_admin_upload_file');
        if(!current_user_can('upload_files')) die('-2');
        if(file_exists(UPLOAD_DIR.$_FILES['package_file']['name']) && get_option('__wpdm_overwrrite_file',0)==1){
            @unlink(UPLOAD_DIR.$_FILES['package_file']['name']);
        }
        if(file_exists(UPLOAD_DIR.$_FILES['package_file']['name']))
            $filename = time().'wpdm_'.$_FILES['package_file']['name'];
        else
            $filename = $_FILES['package_file']['name'];
        move_uploaded_file($_FILES['package_file']['tmp_name'],UPLOAD_DIR.$filename);
        //@unlink($status['file']);
        echo $filename;
        exit;
    }


    function columnsTH($defaults) {
        if(get_post_type()!='wpdmpro') return $defaults;
        $img['image'] = "<span class='wpdm-th-icon ttip' style='font-size: 0.8em'><i  style='font-size: 80%' class='fa fa-image'></i></span>";
        wpdm_array_splice_assoc( $defaults, 1, 0, $img );
        $otf['download_count'] = "<span class='wpdm-th-icon ttip' style='font-size: 0.8em'><i  style='font-size: 80%' class='fa fa-download'></i></span>";
        $otf['wpdmshortcode'] = 'Short-code';
        wpdm_array_splice_assoc( $defaults, 3, 0, $otf );
        return $defaults;
    }


    function columnsTD($column_name, $post_ID) {
        if(get_post_type()!='wpdmpro') return;
        if ($column_name == 'download_count') {

            echo get_post_meta($post_ID, '__wpdm_download_count', true);

        }
        if ($column_name == 'wpdmshortcode') {

            echo "<input readonly=readonly class='wpdm-scode' onclick='this.select();' value=\"[wpdm_package id='$post_ID']\" />";

        }
        if ($column_name == 'image') {
            if(has_post_thumbnail($post_ID))
                echo get_the_post_thumbnail( $post_ID, 'thumbnail', array('class'=>'img60px') );
            else {
                $icon = get_post_meta($post_ID,'__wpdm_icon', true);
                if($icon!=''){
                    $icon = $icon;
                    echo "<img src='$icon' class='img60px' alt='Icon' />";
                }
            }
        }
    }


    function orderbyDownloads( $vars ) {

        if ( isset( $vars['orderby'] ) && 'download_count' == $vars['orderby'] ) {
            $vars = array_merge( $vars, array(
                'meta_key' => '__wpdm_download_count',
                'orderby' => 'meta_value_num'
            ) );
        }

        return $vars;
    }

    function sortableDownloads( $columns ) {

        if(get_post_type()!='wpdmpro') return $columns;

        $columns['download_count'] = 'download_count';

        return $columns;
    }


    function rowActions($actions, $post)
    {
        if($post->post_type == 'wpdmpro')
            $actions['view_stats'] = '<a title="'.__('Stats','wpdmpro').'" href="edit.php?post_type=wpdmpro&page=wpdm-stats&pid='.$post->ID.'" class="view_stats"><i class="fa fa-area-chart text-warning"></i></a>';
            $actions['download_link'] = '<a title="'.__('Direct Download','wpdmpro').'" href="'.\WPDM\Package::getMasterDownloadURL($post->ID).'" class="view_stats"><i class="fa fa-download text-success"></i></a>';

        return $actions;
    }

    function downloadPeriod() {

        if(get_post_type()!='wpdmpro') return;

        $xd = get_post_meta(get_the_ID(),'__wpdm_expire_date',true);
        $pd = get_post_meta(get_the_ID(),'__wpdm_publish_date',true);
        ?>
        <div class="w3eden">
        <div class="panel panel-default no-radius" style="margin: 10px">
            <div class="panel-heading no-radius" style="background-image: none;border-bottom: 1px solid #ddd !important"><?php _e('Download Availability Period', 'wpdmpro'); ?></div>
            <div class="panel-body dl-period">

                <div class="misc-pub-section curtime misc-pub-curtime">
                <span>
                <i class="fa fa-calendar-check-o text-success pull-right"></i><?php _e('Download Available From:', 'wpdmpro'); ?><Br/><input type="text" id="publish_date" autocomplete="off" size="30" value="<?php echo $pd; ?>" name="file[publish_date]" class="form-control input-sm">
                </span></div>
                    <div class="misc-pub-section curtime misc-pub-curtime">
                <span>
                <i class="fa fa-calendar-times-o text-danger pull-right"></i><?php _e('Download Expire on:', 'wpdmpro'); ?><br/><input type="text" id="expire_date" autocomplete="off" size="30" value="<?php echo $xd; ?>" name="file[expire_date]"  class="form-control input-sm">
                </span></div>
                </div>

            </div>
        </div>
        <script>
            jQuery(function(){
                jQuery('#expire_date,#publish_date').datetimepicker({dateFormat:"yy-mm-dd", timeFormat: "hh:mm tt"});
            });
        </script>
        <?php
    }






}