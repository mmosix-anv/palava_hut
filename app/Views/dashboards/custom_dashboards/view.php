<?php echo view("dashboards/install_pwa"); ?>


<!-- <style>
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
    
    .dashboard-view > * {
        position: relative;
        z-index: 1;
    }
    
    .card {
        /* background-color: rgb(255 255 255 / 17%) !important; */
    backdrop-filter: blur(0.2px);
    border: unset !important;
    }
    
    .card-header {
        background-color: rgba(255, 255, 255, 0.8) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.3);
    }

    .widget-details h1 {
    color: #000 !important;
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
</style> -->

<div id="page-content" class="page-wrapper clearfix dashboard-view">

    <?php
    if (count($dashboards)) {
        echo view("dashboards/dashboard_header");
    }
    ?>

    <div class="clearfix row">
        <div class="col-md-12 widget-container">
            <?php
            echo announcements_alert_widget();

            app_hooks()->do_action('app_hook_dashboard_announcement_extension');
    
            $project_inquiry_model = model("App\Models\Project_inquiry_model");
            $has_inquiries = $project_inquiry_model->get_details(array("user_id" => $login_user->id, "email" => $login_user->email))->getResult();
            
            if (!$has_inquiries && $login_user->user_type === "client") {
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
        </div>
    </div>

    <?php
    if ($widget_columns) {
        echo $widget_columns;
    } else {
        echo view("dashboards/custom_dashboards/no_widgets");
    }

    $dashboard_id = isset($dashboard_id) ? $dashboard_id : 0;
    ?>

</div>

<?php echo view("dashboards/helper_js"); ?>

<script>
    $(document).ready(function() {
        //we have to reload the same page when editting title
        $("#dashboard-edit-title-button").click(function() {
            window.dashboardTitleEditMode = true;
        });

        //update dashboard link
        $(".dashboard-menu, .dashboard-image").closest("a").attr("href", window.location.href);

        onDashboardDeleteSuccess = function(result, $selector) {
            window.location.href = "<?php echo get_uri("dashboard"); ?>";
        };

        if (!isMobile()) {
            initScrollbar('#project-timeline-container', {
                setHeight: 728
            });

            initScrollbar('#upcoming-event-container', {
                setHeight: 330
            });

            initScrollbar('#client-projects-list', {
                setHeight: 316
            });
        }

        <?php if ($dashboard_id && $dashboard_id === get_setting("staff_default_dashboard") && $login_user->user_type === "staff") { ?>
            $(".dashboards-row").each(function() { //each widgets row
                var $rowInstance = $(this),
                    totalColumns = $rowInstance.find(".widget-container").length,
                    invalidWidgetRemoved = false;

                //remove invalid widgets and columns
                $rowInstance.find(".widget-container").each(function() { //each widgets column
                    var invalidWidget = $(this).find(".dashboard-invalid-widget");

                    if (invalidWidget) { //has invalid widget in this column
                        invalidWidget.remove(); //remove invalid widget
                        if ($(this).text() === '') { //if there is nothing else in this column the remove the column
                            $(this).remove();
                            invalidWidgetRemoved = true; //flag an invalid widget removed, to prevent extra operations
                        }
                    }
                });

                if (invalidWidgetRemoved) {
                    var totalNewColumns = $rowInstance.find(".widget-container").length,
                        columnsArray = {
                            1: 12,
                            2: 6,
                            3: 4,
                            4: 3
                        };

                    if (totalColumns !== totalNewColumns) { //any column has been totally removed in this row
                        $rowInstance.find(".widget-container").each(function() {
                            $(this).addClass("col-md-" + columnsArray[totalNewColumns]); //apply the appropriate column class
                        });
                    }
                }
            });
        <?php } ?>

    });
</script>
