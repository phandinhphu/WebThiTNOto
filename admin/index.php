<?php
require_once '../db/dbhelpper.php';
require_once '../db/dbconnect.php';
require_once '../db/database.php';
require_once '../includes/function.php';
require_once '../includes/session.php';
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
        content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Ample lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Ample admin lite dashboard bootstrap 5 dashboard template">
    <meta name="description"
        content="Ample Admin Lite is powerful and clean admin dashboard template, inpired from Bootstrap Framework">
    <meta name="robots" content="noindex,nofollow">
    <title>Trang Quản Trị</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/ample-admin-lite/" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/plugins/images/favicon.png">
    <!-- Custom CSS -->
    <link href="./assets/plugins/bower_components/chartist/dist/chartist.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css">
    <!-- Custom CSS -->
    <link href="./assets/css/style.min.css" rel="stylesheet">
    <style>
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 14px;
        }
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin6">
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="#">
                        <!-- Logo icon -->
                        <b class="logo-icon">
                            <!-- Dark Logo icon -->
                            <img src="./assets/plugins/images/logo-icon.png" alt="homepage" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="logo-text">
                            <!-- dark Logo text -->
                            <img src="./assets/plugins/images/logo-text.png" alt="homepage" />
                        </span>
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <a class="nav-toggler waves-effect waves-light text-dark d-block d-md-none"
                        href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                   
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav ms-auto d-flex align-items-center">

                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <li class=" in">
                            <form role="search" class="app-search d-none d-md-block me-3">
                                <input type="text" placeholder="Search..." class="form-control mt-0">
                                <a href="" class="active">
                                    <i class="fa fa-search"></i>
                                </a>
                            </form>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li>
                            <a class="profile-pic" href="#">
                                <img src="./assets/plugins/images/users/varun.jpg" alt="user-img" width="36"
                                    class="img-circle"><span class="text-white font-medium">Steave</span></a>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <!-- User Profile-->
                        <li class="sidebar-item pt-2">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="../admin/index.php?layout=dashboard"
                                aria-expanded="false">
                                <i class="far fa-clock" aria-hidden="true"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-item pt-2">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="../admin/index.php?layout=exam"
                                aria-expanded="false">
                                <i class=" fas fa-bookmark" aria-hidden="true"></i>
                                <span class="hide-menu">Exam</span>
                            </a>
                        </li>
                    </ul>

                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title"><?= isset($_GET['layout']) ? $_GET['layout'] : 'Dashboard' ?></h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <div class="d-md-flex">
                            <ol class="breadcrumb ms-auto">
                                <li><a href="#" class="fw-normal"><?= isset($_GET['layout']) ? $_GET['layout'] : 'Dashboard' ?></a></li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <?php
                if (isset($_GET['layout'])) {
                    $layout = $_GET['layout'];
                    if ($layout == 'exam') {
                        require_once 'exam/exam.php';
                    } else {
                        require_once 'dashboard.php';
                    }
                } else {
                    require_once 'dashboard.php';
                }
            ?>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center"> 2021 © Ample Admin brought to you by <a
                    href="https://www.wrappixel.com/">wrappixel.com</a>
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->

    <!-- Modal Add Exam -->
    <div class="modal fade" id="addExamModal" tabindex="-1" role="dialog" aria-labelledby="addExamModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExamModalLabel">Add Exam</h5>
                    <button id="icon-close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="exam-name" class="col-form-label">Exam Name:</label>
                            <input type="text" class="form-control" id="exam-name" name="exam-name">
                        </div>
                        <div class="form-group">
                            <label for="exam-time" class="col-form-label">Exam Time:</label>
                            <input type="text" class="form-control" id="exam-time" name="exam-time">
                        </div>
                        <div class="form-group">
                            <label for="exam-status" class="col-form-label">Exam Status:</label>
                            <select name="exam-status" class="form-control" id="exam-status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button id="js-close" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="js-save" type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
 
    <!-- Modal Edit Exam -->
    <div class="modal fade" id="editExamModal" tabindex="-1" role="dialog" aria-labelledby="addExamModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExamModalLabel">Edit Exam</h5>
                    <button id="edit-icon-close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="edit-exam-name" class="col-form-label">Exam Name:</label>
                            <input type="text" class="form-control" id="edit-exam-name" name="edit-exam-name">
                        </div>
                        <div class="form-group">
                            <label for="edit-exam-time" class="col-form-label">Exam Time:</label>
                            <input type="text" class="form-control" id="edit-exam-time" name="edit-exam-time">
                        </div>
                        <div class="form-group">
                            <label for="edit-exam-status" class="col-form-label">Exam Status:</label>
                            <select name="edit-exam-status" class="form-control" id="edit-exam-status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button id="js-edit-close" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="js-edit-save" type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

	<!-- Add exam -->
	<script>
		$(document).ready(function() {
			$('#js-save').click(function() {
				var examName = $('#exam-name').val();
				var examTime = $('#exam-time').val();
				var examStatus = $('#exam-status').val();
				$.ajax({
					url: 'exam/add-exam.php',
					type: 'POST',
					data: {
						examName: examName,
						examTime: examTime,
						examStatus: examStatus
					},
					success: function(response) {
						if (response.status == 1) {
							alert('Add exam successfully');
							$('#addExamModal').modal('hide');
							location.reload();
						} else {
							alert('Add exam failed');
						}
					}
				});
			});
		});
	</script>
	<!-- Add exam -->

    <!-- Edit exam -->
    <script>
        $(document).ready(function() {
            $('#js-edit-close').click(() => {
                $('#editExamModal').modal('hide');
            });

            $('#edit-icon-close').click(() => {
                $('#editExamModal').modal('hide');
            });

            $('#js-edit-save').click(() => {
                var examName = $('#edit-exam-name').val();
                var examTime = $('#edit-exam-time').val();
                var examStatus = $('#edit-exam-status').val();
                $.ajax({
                    url: 'exam/edit-exam.php',
                    type: 'POST',
                    data: {
                        examName: examName,
                        examTime: examTime,
                        examStatus: examStatus
                    },
                    success: function(response) {
                        if (response.status == 1) {
                            alert(response.message);
                            $('#editExamModal').modal('hide');
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });

            const btns = document.querySelectorAll('.js-edit-exam');
            btns.forEach(item => {
                item.addEventListener('click', () => {
                    var examName = item.getAttribute('value');
                    $.ajax({
                        url: 'http://localhost/WebThiTN-Oto/api/exam/getExamByName.php',
                        type: 'POST',
                        data: {
                            examName: examName
                        },
                        success: function(response) {
                            $('#editExamModal').modal('show');
                            $('#edit-exam-name').val(response.examName);
                            $('#edit-exam-time').val(response.timeLimit);
                            $('#edit-exam-status').val((response.status == 1) ? "active" : "inactive");
                        }
                    });
                });
            });
        });
    </script>
    <!-- Edit exam -->

    <!-- Delete exam -->
    <script>
        $(document).ready(() => {
            const deleteBtns = document.querySelectorAll('.js-delete-exam');
            deleteBtns.forEach(item => {
                item.addEventListener('click', () => {
                    const option = confirm('Are you sure you want to delete this exam?');
                    if (!option) {
                        return;
                    }

                    var examName = item.getAttribute('value');
                    $.ajax({
                        url: 'exam/delete-exam.php',
                        type: 'POST',
                        data: {
                            examName: examName
                        },
                        success: (response) => {
                            if (response.status == 1) {
                                alert(response.message);
                                location.reload();
                            } else {
                                alert(response.message);
                            }
                        }
                    });
                });
            });
        });
    </script>
    <!-- Delete exam -->

	<!-- Open & Close modal -->
    <script>
        $(document).ready(function() {
            $('#add-exam').click(function() {
                $('#addExamModal').modal('show');
            });
            $('#js-close').click(function() {
                $('#addExamModal').modal('hide');
            });
            $('#icon-close').click(function() {
                $('#addExamModal').modal('hide');
            });
        });
    </script>
	<!-- Open & Close modal -->	

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="./assets/plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="./assets/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/app-style-switcher.js"></script>
    <script src="./assets/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    <!--Wave Effects -->
    <script src="./assets/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="./assets/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="./assets/js/custom.js"></script>
    <!--This page JavaScript -->
    <!--chartis chart-->
    <script src="./assets/plugins/bower_components/chartist/dist/chartist.min.js"></script>
    <script src="./assets/plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="./assets/js/pages/dashboards/dashboard1.js"></script>
    
</body>

</html>