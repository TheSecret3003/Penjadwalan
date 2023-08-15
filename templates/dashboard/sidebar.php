<?php  
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
         $url = "https://";   
    else  
         $url = "http://";   
    // Append the host(domain name, ip) to the URL.   
    $url.= $_SERVER['HTTP_HOST'];   
    
    // Append the requested resource location to the URL   
    $url.= $_SERVER['REQUEST_URI'];    
      
    $menu = '';
    if (str_contains($url, 'letter')) {
        $menu = 'menu-open';
    }
  ?> 


<html>
    
    <head>
    <link href="css/app.css" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DPRD Buleleng</title>
    <link rel="icon" type="image/png" id="favicon"href="img/buleleng.png"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.js"></script>  

    <!-- Google Font: Source Sans Pro -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.js"></script>  
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <script src="https://use.fontawesome.com/5bb81504e3.js"></script>
    <script src="https://kit.fontawesome.com/f00f878d48.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        />
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <a class="nav-link btn btn-danger text-white py-2 px-3 ms-0 ms-md-3 btn-sm" aria-current="page" href="<?= url() . '/logout.php'; ?>">Logout</a>
    </ul>
  </nav>
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style = "background-color:#010336">
    <a href="#" class="brand-link">
        <img src="img/buleleng.png" alt="DPRD" class="brand-image img-circle elevation-3"
                style="opacity: .8">
        <span class="brand-text font-weight-light" style="font-family: Bremen">DPRD Buleleng</span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="img/stock_people.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= auth()['user']['username']; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item has-treeview <?php echo $menu ?>">
                <a class="nav-link" style="color:#FFFFFF">
                    <i class="nav-icon fas fa-envelope-open"></i>
                    <p>
                    Arsip Surat
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                    <a href="<?= url() . '/view_letter.php'; ?>" class="nav-link <?php echo (str_contains($url, 'view')) ? "active":"" ;?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Lihat Surat Masuk</p>
                    </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                    <a href="<?= url() . '/add_letter.php'; ?>" class="nav-link <?php echo (str_contains($url, 'add')) ? "active":"" ;?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Tambah Surat</p>
                    </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-treeview">
                <a href="<?= url() . '/schedule.php'; ?>" class="nav-link <?php echo (str_contains($url, 'schedule')) ? "active":"" ;?>">
                    <i class="nav-icon fas fa-calendar"></i>
                    <p>
                    Jadwal Kegiatan
                    </p>
                </a>
            </li>
        </ul>
      </nav>
    </div>
  </aside>


  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>
    </body>
</html>
<script src="app.js"></script>