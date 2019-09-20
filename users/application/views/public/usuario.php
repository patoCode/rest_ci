<?php $this->load->view('commons/header'); ?>
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
                                    <input type="hidden" name="id" class="form-control" placeholder="Nombre(s)" value="<?php if($user != null) echo $user->id;?>">
                                    <input type="text" name="nombre" class="form-control" placeholder="Nombre(s)"  value="<?php if($user != null)  echo $user->nombre;?>">
                                </div>
                                <div class="col">
                                    <!-- Last name -->
                                    <input type="text" name="apellido" class="form-control" placeholder="Apellido(s)" value="<?php  if($user != null) echo $user->apellido;?>">
                                </div>
                            </div>

                            <!-- E-mail -->
                            <input type="text" name="email" class="form-control mb-4" placeholder="E-mail"  value="<?php if($user != null)  echo $user->email;?>">

                            <!-- usernae -->
                            <input type="text" name="username" class="form-control mb-4" placeholder="Nombre de Usuario"  value="<?php  if($user != null) echo $user->username;?>">

                            <!-- Password -->
                            <input type="password" name="password" class="form-control" placeholder="Password" value="<?php  if($user != null) echo $user->password;?>">
                            <small id="defaultRegisterFormPasswordHelpBlock" class="form-text text-muted mb-4">
                                Mas de 8 caracteres
                            </small>

                            <!-- Phone number -->
                            <input type="text" name="telefono" class="form-control" placeholder="Numero de telefono" value="<?php  if($user != null) echo $user->telefono;?>"> 
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