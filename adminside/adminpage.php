<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vanilla DataTables CRUD</title>

    <link rel="stylesheet" href="bootstrapmin.css">
    <link rel="stylesheet" href="vanilla-datatables.css">
    <link rel="stylesheet" href="Admin.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="vanilla-datatables.js"></script>
    <style>
        html, body{
            min-height:100%;
            width:100%;
        }
    </style>
</head>
<body>
        <nav class="adminnav">
            <h1>JMCYK Admin Page</h1>
        </nav>

        <div class="container">
            <h1>Welcome Admin</h1>
            <br>
            <p>Manage Your Employees Here</p>
        </div>
    <div class="container">
        <h2 class="text-center">Manage Your Employees Here:</h2>
        <div class="row">
            <div>
                <div class="container-fluid">
                    <div class="card shadow rounded-0">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div><b>Member List</b></div>
                                <div class="col-auto">
                                    <button type="button" id="add_new" class="btn btn-sm btn-primary bg-gradient rounded-0"><i class="fa-solid fa-plus-square"></i> Add New</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body rounded-0">
                            <div class="container-fluid">
                                <table id="memberTable" class="table table-stripped table-bordered">
                                    <colgroup>
                                        <col width="auto">
                                        <col width="auto">
                                        <col width="auto">
                                        <col width="auto">
                                        <col width="auto">
                                        <col width="auto">
                                        <col width="auto">
                                        <col width="15%">
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th class="text-center">User Type</th>
                                            <th class="text-center">ID</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Phone</th>
                                            <th class="text-center">Username</th>
                                            <th class="text-center">Password</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Member Form Modal -->
    <div class="modal fade" id="memberFormModal" aria-labelledby="memberFormModal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable rounded-0">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h1 class="modal-title fs-5"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body rounded-0">
                    <div class="container-fluid-hidden">
                        <form action="" id="member-form">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control-hidden rounded-0" name="name" id="name" required="required">
                            </div>
                            <div class="mb-3">
                                <label for="contact" class="form-label">Email</label>
                                <input type="text" class="form-control-hidden rounded-0" name="contact" id="contact" required="required">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Phone</label>
                                <input type="text" class="form-control-hidden rounded-0" name="address" id="address"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">User Type</label>
                                <input type="text" class="form-control-hidden rounded-0" name="name" id="name" required="required">
                            </div>
                            <div class="mb-3">
                                <label for="ID" class="form-label">ID</label>
                                <input type="text" class="form-control-hidden rounded-0" name="ID" id="ID" required="required">
                            </div>
                            <div class="mb-3">
                                <label for="Username" class="form-label">Username</label>
                                <input type="text" class="form-control-hidden rounded-0" name="Username" id="Username" required="required"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="Password" class="form-label">Password</label>
                                <input type="text" class="form-control-hidden rounded-0" name="Password" id="Password" required="required">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="member-form" class="btn btn-primary btn-sm rounded-0">Save</button>
                    <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Member Form Modal -->
    <script src="app.js"></script>
</body>
</html>