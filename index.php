<?php
require_once(__DIR__ . "/api/classes.php");
CookieCheck::Check();
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista della spesa</title>

    <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
    <script src="js/script.js"></script>
    <style>
        td {
            font-weight: 600;
        }
    </style>
</head>

<body>
    <header class="p-3 bg-dark text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <form class="col-12 col-lg-4 mb-3 mb-lg-0 me-lg-3">
                    <input type="search" class="form-control form-control-dark" placeholder="Type in an item..." aria-label="Search" id="adding">
                </form>

                <div class="text-end">
                    <!-- <button type="button" class="btn btn-outline-light me-2">Login</button> -->
                    <button type="button" class="btn btn-warning" onclick="AddItem()">Add to purchase list <i class="bi bi-cart-plus"></i></button>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-2">
                <table class="table table-striped" id="toptable">
                    <thead>
                        <tr>
                            <th class="col-8"></th>
                            <th class="col-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-2">
                <table class="table table-striped table-dark" id="bottomtable">
                    <thead>
                        <tr>
                            <th class="col-8"></th>
                            <th class="col-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="modal" tabindex="-1" role="dialog" id="mymodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Message window</h5>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>