<?php
include '../JhhamesPhp/sessions.php';
include '../JhhamesPhp/database.php';

$connect = connect_db();
include '../JhhamesPhp/excologinaction.php';
include '../JhhamesPhp/addMember.php';

$memberList = membersList();
$permission = array('president', 'P.R.O');

include '../JhhamesPhp/addExco.php';
$excos = excosList();


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Space Club  </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../slick/slick.css">
    <link rel="stylesheet" href="../slick/slick-theme.css">
    <link rel="icon" href="../img/logo.png" >

</head>
<body> 
    <nav class="bg-light small">
        <div class="container">
            <div class="dropdown " >
                <a class="dropdown-toggle fa fa-user-circle text-dark" href="" style="text-decoration:none" data-toggle="dropdown">
                    <?= $_SESSION['excoDetails']['fname'] . " " . $_SESSION['excoDetails']['lname'] ?>
                </a>
                <div class="dropdown-menu" style="z-index:9999">
                    <a href="" class="dropdown-item" data-toggle="modal"> <span class="fa fa-pencil"></span> Details </a>
                    <a href="../JhhamesPhp/excologout.php" class="dropdown-item"> <span class="fa fa-sign-out"></span> Logout </a>
                </div>


            </div>
        </div>
    </nav>

    <nav class="navbar navbar-expand-sm sticky-top bg-dark text-light">
        <div class="container">
            <div class="navbar-brand mr-auto">
                <span class="fa fa-gear"></span> SpaceClub Exco Panel
            </div>
            <button class="navbar-toggler text-light" data-target="#nav-slant" data-toggle="collapse">
                <span class="fa fa-bars"></span>
            </button>
           
            <div class="collapse navbar-collapse text-light" id="nav-slant">
                <ul class="ml-auto nav nav-tabs nav-justified">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link  text-capitalize text-light">Members</a>
                    </li>
                    <li class="nav-item">
                        <a href="aspirants.php" class="nav-link text-capitalize text-light">Aspirants</a>
                    </li>
                    </li>
                    <li class="nav-item">
                        <a href="excos.php" class="nav-link text-capitalize active text-dark">Excos</a>
                    </li>
                </ul>
            </div>
        </div>

    </nav>
     <section id="error">
        <div class="container-fluid">
            <div class="row text-center">
                <?php
                echo error();
                echo success();
                ?>
            </div>
        </div>
    </section>
    <section class="mt-2">
        <div class="container">
            <div class="row">    
                <div class="clearfix border p-2 border-dark w-100">
                    <span class="float-left"> <h4 class="float-left"> <span class="fa fa-users"></span> Excos  </h4></span>
                    <span class="float-right"><input type="text" id="myInput" placeholder="search..." class="float-right form-control"></span>
                </div>
           
                <div class="table-responsive w-100">   
                    <table class="table table-striped border border-dark" >
                    
                    <thead class="thead-dark bg-dark text-white text-capitalize">
                        <tr>
                            <th>Name</th>
                            <th>Office</th>
                            <th>Phone </th>
                            <th>More </th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        <?php
                        if (isset($excos) && mysqli_num_rows($excos) > 0) :
                            while ($row = mysqli_fetch_array($excos)) :
                        ?>
                        <tr>
                            <td> <?= $row['firstname'] ?></td>
                            <td> <?= $row['office'] ?> </td>
                            <td> <?= $row['phone'] ?> </td>
                            <td>
                                <button data-toggle="modal" data-target="#mod<?= $row['id'] ?>" class="btn btn-secondary">
                                <span class="fa fa-pencil"></span> </button>
                            </td>
                        </tr>
                        <?php
                        endwhile;
                        else :
                            echo "<th colspan='4' class='text-center'> No Excos yet </th> ";
                        endif;
                        ?>

                    
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <section>
                        <?php
                            $class = "";
                            if(in_array($_SESSION['excoDetails']['office'],$permission)):
                                $class = '';
                            else:
                                $class= 'disabled';
                            endif;
                        ?>
        <div class="container">
            <div class="row">
             <button class="btn btn-lg btn-info px-3 mb-4 mx-1 fixed-bottom rounded-circle"
                style="transform:scale(1.1,1.3); left: 80vw; box-shadow:0px 3px 10px #666"
                data-toggle="modal"
                data-target="#addaspirant" <?=$class?>>
                <span class="fa fa-user-plus"></span>
            </button>
            </div>
        </div>
    </section>
                
    <section name="modals">
        <div class="modal fade" id="addaspirant">
            <div class="modal-dialog">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"> New Exco </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                         
                <form action="#" method="POST" class="bg-light p-4 ">
                    <div class="form-group">
                        <label for="memlist" class="font-weight-bold">Select a member</label>
                        <select name="member" id="memlist" class="form-control">
                            <?php
                                if (isset($memberList) && mysqli_num_rows($memberList) > 0) :
                                    while ($row = mysqli_fetch_array($memberList)) :
                            ?>
                                        <option value="<?= $row['id'] ?>"> <?= $row['name'] ?> </option>
                            <?php 
                                    endwhile;
                                else :

                                endif;
                
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="office" class="font-weight-bold"> Office </label>
                        <input type="text" name="office" id="office" placeholder="Enter Office for candidate" class="form-control">
                    </div>

                    <button class="btn btn-outline-primary" name="addExco" <?=$class ?>>Add</button>
                </form>   
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

                </div>
            </div>
        </div>


    </section>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../slick/slick.js"></script>
    <script src="../slick/slick.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        });
    </script>
</body>
</html>