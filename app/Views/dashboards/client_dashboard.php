<?php echo view("dashboards/install_pwa"); ?>
<?php 
$project_inquiry_model = model("App\Models\Project_inquiry_model");
$has_inquiries = $project_inquiry_model->get_details(array("user_id" => $login_user->id, "email" => $login_user->email))->getResult();

if (!$has_inquiries) {
    ?>
    <div class="alert alert-warning m20">
        <i class="fa fa-warning"></i> 
        <?php echo app_lang("you_havent_submitted_project_inquiry"); ?> 

        <div class="title-button-group">
            <?php echo modal_anchor(get_uri("project_inquiry/modal_form"), "<i class='fa fa-plus-circle'></i> " . app_lang('add_project_inquiry'), array("class" => "btn btn-warning ml15", "title" => app_lang('submit_project_inquiry'))); ?>
        </div>
    </div>
    <?php
}
 ?>

<div id="page-content" class="page-wrapper clearfix">
    <?php
    if (count($dashboards) && !get_setting("disable_dashboard_customization_by_clients")) {
        echo view("dashboards/dashboard_header");
    }

    echo announcements_alert_widget();

    app_hooks()->do_action('app_hook_dashboard_announcement_extension');
    ?>
    <div class="">
        <?php echo view("clients/info_widgets/index"); ?>
    </div>

    <?php if ($show_project_info) { ?>
        <div class="">
            <?php echo view("clients/projects/index"); ?>
        </div>
    <?php } ?>

</div>