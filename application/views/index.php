  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <img src="<?php echo base_url(); ?>/assets/img/apple-touch-icon-60x60.png"> 
      </div>
      <a style="color:#ffffff;" class="navbar-brand" href="#">Sistema de Gestión de Oficios del CSEIIO / Acceso</a>
    </div>
  </nav>

<br><br><br><br>
<div class="container">
  <div class="row">
    <div class="col-sm-6 col-md-4 col-md-offset-4">
      <h1 class="text-center login-title">Bienvenid@s</h1>
     
     <div class="account-wall">
        <img class="profile-img" src="<?php echo base_url(); ?>/assets/img/user.png" alt="">

        <form class="form-signin"  method="POST" action="">
          <input type="text" name="user" class="form-control" placeholder="Ingresa tu usuario" required autofocus>
          <input type="password" name="password" class="form-control" placeholder="Ingresa tu password" required>
         <br>
          <button class="btn btn-success btn-block" type="submit"> Ingresar</button>
          <br>
          <div>

            <?php
            $invalido = $this->session->flashdata('invalido');

            if($invalido) { ?>
              <strong>
                 <div class="alert alert-danger" style="text-aling:center; color:#4A4949"  role="alert"><?php echo $invalido ?></div>
              </strong>
            
            <?php } 
             if (validation_errors()) { ?>
               <strong>
                 <div class="alert alert-warning" style="text-aling:center; color:#4A4949"  role="alert"><?php echo validation_errors(); ?></div>
               </strong>
             <?php }  ?>   
            
            </div>
          </form>
        </div>
     </div>
    </div>
  </div>