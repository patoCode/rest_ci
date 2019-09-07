<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row m-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header alert-info">
                        <h3>SIGN IN</h3>
                    </div>
                    <div class="card-body">                        

                        <!-- Default form register -->
                        <form class="text-center border border-light p-5" action="<?php echo base_url()?>Usuario/add" method="POST">
                            

                            <div class="form-row mb-4">
                                <div class="col">
                                    <!-- First name -->
                                    <input type="text" name="nombre" class="form-control" placeholder="Nombre(s)">
                                </div>
                                <div class="col">
                                    <!-- Last name -->
                                    <input type="text" name="apellido" class="form-control" placeholder="Apellido(s)">
                                </div>
                            </div>

                            <!-- E-mail -->
                            <input type="text" name="email" class="form-control mb-4" placeholder="E-mail">

                            <!-- usernae -->
                            <input type="text" name="username" class="form-control mb-4" placeholder="Nombre de Usuario">

                            <!-- Password -->
                            <input type="password" name="password" class="form-control" placeholder="Password">
                            <small id="defaultRegisterFormPasswordHelpBlock" class="form-text text-muted mb-4">
                                Mas de 8 caracteres
                            </small>

                            <!-- Phone number -->
                            <input type="text" name="telefono" class="form-control" placeholder="Numero de telefono">
                            <small id="defaultRegisterFormPhoneHelpBlock" class="form-text text-muted mb-4">
                                Telefono
                            </small>

                            <!-- Sign up button -->
                            <button class="btn btn-success my-4 btn-block" type="submit">Log in</button>

                        </form>
                        <!-- Default form register -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>