<?php echo view("dashboards/install_pwa"); ?>
<style>
    /* Custom CSS for dashboard cards and background */
    .dashboard-view {
        position: relative;
    }
    
    .dashboard-view::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4); /* Dark overlay for better text visibility */
        z-index: 0;
    }

    .bg-info, .bg-success, .bg-primary, .bg-coral {
    background-color: #252932 !important;
}
    
    .dashboard-view > * {
        position: relative;
        z-index: 1;
    }
    
    .card {
        background-color: rgb(255 255 255 / 17%) !important;
    backdrop-filter: blur(0.2px);
    border: unset !important;
    }
    
    .card-header {
        background-color: rgba(255, 255, 255, 0.8) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.3);
    }

    .widget-details h1 {
    color: #fff !important;
}
    
    .card-body {
        background-color: hwb(221.54deg 14.51% 80.39% / 29%) !important;
        backdrop-filter: blur(0.2px)!important;
        
        color: #fff !important; /* Ensuring text is dark enough to be readable */
    }
    
    /* Ensure text in other elements is visible */
    .dashboard-view h1, .dashboard-view h2, .dashboard-view h3, .dashboard-view h4, .dashboard-view h5, .dashboard-view h6, .dashboard-view p {
        color: #fff;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
    }
    
    /* Make alert messages more visible */
    .alert {
        background-color: rgba(255, 255, 255, 0.9) !important;
    }

    a {
    color: #ffff;
}
</style>
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

<div id="page-content" class="page-wrapper clearfix" style="background-image: url('<?php echo base_url("assets/images/dashboard-bg.png"); ?>'); background-size: cover; background-position: center;">
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