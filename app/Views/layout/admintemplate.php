<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/aedno.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/class.css" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <link href="public/DataTables/datatables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo base_url() ?>public/datatable/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>public/datatable/jquery.dataTables.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>public/datatable/select.dataTables.min.css">

    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Admin</title>
</head>

<body style="background-color: #E5E5FD; padding-top:20px;padding-bottom:20px">
    <div class="container">
        <div class="container-fluid">
            <div class="row flex-nowrap">
                <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0" style="background-color: #FFF;border-radius:10px; margin-right:10px">
                    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                        <a href="<?= base_url(); ?>" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto  text-decoration-none">
                            <span class="fs-5 d-none d-sm-inline"><img src="<?php echo base_url(); ?>public/aedno-long-nobg.png" style="width:90%"></span>
                        </a>
                        <ul class="nav nav-pills flex-column  mb-0 align-items-center align-items-sm-start" id="menu">
                            <!-- <li class="nav-item">
                        <a href="#" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                        </a>
                    </li> -->
                            <?php if ($session->get('role') != '5') {
                                echo '
                        <li class="menu-box">
                            <a href="' . base_url('admin/dashboard') . '" class="nav-link px-0 align-middle">
                                <i class="fa-solid icon fa-gauge"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                            </a>
                        </li>';
                            } ?>
                            <?php if ($session->get('role') != '3') {
                                echo '
                    <li class="menu-box">
                        <a href="#submenu32" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                        <i class="fa-solid fa-user-nurse icon"></i> <span class="ms-1 d-none d-sm-inline">Users</span> </a>
                        <ul class="collapse nav flex-column ms-1" id="submenu32" data-bs-parent="#menu">
                            <li class="w-100">
                                <a href="' . base_url('admin/users') . '" class="nav-link px-0"> <span class="d-none d-sm-inline">User List</span> <i class="fa-solid fa-list"></i> </a>
                            </li>
                            <li>
                                <a href="' . base_url('admin/create-users') . '" class="nav-link px-0"> <span class="d-none d-sm-inline">Create User</span> <i class="fa-solid fa-circle-plus"></i> </a>
                            </li>
                        </ul>
                    </li>';
                            } ?>
                            <?php if ($session->get('role') == '1') {
                                echo '<li class="menu-box">
                    <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                        <i class="fa-solid icon fa-building-columns"></i> <span class="ms-1 d-none d-sm-inline">Branch</span> </a>
                    <ul class="collapse nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                        <li class="w-100">
                            <a href="' . base_url('admin/branch') . '" class="nav-link px-0"> <span class="d-none d-sm-inline">Branch List</span> <i class="fa-solid fa-list"></i> </a>
                        </li>
                        <li>
                            <a href="' . base_url('admin/create-branch') . '" class="nav-link px-0"> <span class="d-none d-sm-inline">Create Branch</span> <i class="fa-solid fa-circle-plus"></i> </a>
                        </li>
                    </ul>
                </li>';
                            }elseif($session->get('role') == '2'){
                                echo '
                        <li class="menu-box">
                            <a href="' . base_url('admin/edit-branch/') .$session->get('branch_id') .'" class="nav-link px-0 align-middle">
                                <i class="fa-solid icon fa-building-columns"></i> <span class="ms-1 d-none d-sm-inline">Branch</span>
                            </a>
                        </li>';
                            }

                            ?>

                            <li class="menu-box">
                                <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                    <i class="fa-solid icon fa-people-roof"></i> <span class="ms-1 d-none d-sm-inline">Class</span> </a>
                                <ul class="collapse nav flex-column ms-1" id="submenu3" data-bs-parent="#menu">
                                    <li class="w-100">
                                        <a href="<?php echo base_url('admin/class'); ?>" class="nav-link px-0"> <span class="d-none d-sm-inline">Class List</span> <i class="fa-solid fa-list"></i> </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('admin/create-class') ?>" class="nav-link px-0"> <span class="d-none d-sm-inline">Create Class</span> <i class="fa-solid fa-circle-plus"></i> </a>
                                    </li>
                                </ul>
                            </li>
                            <?php if ($session->get('role') == '1') { ?>
                                <li class="menu-box">
                                    <a href="#submenu4" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                        <i class="fa-solid icon fa-money-bill"></i> <span class="ms-1 d-none d-sm-inline">Currency</span> </a>
                                    <ul class="collapse nav flex-column ms-1" id="submenu4" data-bs-parent="#menu">
                                        <li class="w-100">
                                            <a href="<?php echo base_url('admin/currency'); ?>" class="nav-link px-0"> <span class="d-none d-sm-inline">Currency List</span> <i class="fa-solid fa-list"></i> </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('admin/create-currency'); ?>" class="nav-link px-0"> <span class="d-none d-sm-inline">Create Currency</span> <i class="fa-solid fa-circle-plus"></i> </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php }
                            ?>

                            <li class="menu-box">
                                <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                    <i class="fa-solid icon fa-user"></i> <span class="ms-1 d-none d-sm-inline">Student</span> </a>
                                <ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                                    <li class="w-100">
                                        <a href="<?php echo base_url('admin/student'); ?>" class="nav-link px-0"> <span class="d-none d-sm-inline">Student List</span> <i class="fa-solid fa-list"></i> </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('admin/create-student'); ?>" class="nav-link px-0"> <span class="d-none d-sm-inline">Create Student</span> <i class="fa-solid fa-circle-plus"></i> </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-box">
                                <a href="#submenu7" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                    <i class="fa-solid icon fa-credit-card"></i> <span class="ms-1 d-none d-sm-inline">Payment</span> </a>
                                <ul class="collapse nav flex-column ms-1" id="submenu7" data-bs-parent="#menu">
                                    <li class="w-100">
                                        <a href="<?php echo base_url('admin/payment'); ?>" class="nav-link px-0"> <span class="d-none d-sm-inline">Payment List</span> <i class="fa-solid fa-list"></i> </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('admin/create-payment'); ?>" class="nav-link px-0"> <span class="d-none d-sm-inline">Add Payment</span> <i class="fa-solid fa-circle-plus"></i> </a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                        <hr>
                        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="<?= base_url() . "public/person.png" ?>" alt="hugenerd" width="30" height="30" class="rounded-circle" style="border: 1px #808080 solid;padding :2px">
                                <span class="d-none d-sm-inline mx-1" style="color:var(--bs-link-color)" data-toggle="tooltip" title="<?php echo htmlspecialchars($session->get('name')); ?>">
                                    <?php echo substr($session->get('name'), 0, 10); ?>
                                </span> </a>
                            <div class="dropdown">

                                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                                    <!-- <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li> -->
                                    <li><a class="dropdown-item" href="<?php echo base_url() . "auth/logout" ?>">Sign out</a></li>
                                </ul>
                            </div>
                        </ul>

                    </div>
                </div>
                <div class="col py-3" style="background-color: #FFF;border-radius:10px">
                    <?= $this->renderSection('content'); ?>
                </div>
            </div>
        </div>

    </div>
    <script src="<?php echo base_url() ?>/public/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/i18n/defaults-*.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</body>

</html>