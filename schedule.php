<?php
require 'connection.php';
require 'global.php';
require 'templates/dashboard/header.php';
require 'templates/dashboard/sidebar.php';

guardAuth();

$current = date("d-m-Y h:i:sa");

// echo $current;

$sqlQuerySearch = '';

$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';

if (isset($_POST['search']) && $keyword) {
    $sqlQuerySearch = " AND nama_kegiatan LIKE '%$keyword%' OR tempat_kegiatan LIKE '%$keyword%' OR asal_surat LIKE '%$keyword%'";
}

$sql = "SELECT * FROM surat WHERE waktu_kegiatan >= DATE(NOW())" . $sqlQuerySearch;
$surat = query($sql)->fetch_all(MYSQLI_ASSOC);
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Daftar Surat</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Daftar Data surat</div>
                    <div class="card-body">
                        <?php require 'templates/alert.php' ?>
                        <form action="" class="py-2" method="post">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Cari Surat..." name="keyword" value="<?= $keyword ?>" />
                                <button class="btn btn-outline-primary" type="submit" name="search" value="1">Cari</button>
                            </div>
                        </form>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Kegiatan</th>
                                    <th scope="col">Asal Surat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $limit = 10;
                                    $page = isset($_GET['page'])?(int)$_GET['page'] : 1;
                                    $first_page = ($page>1) ? ($page * $limit) - $limit : 0;	

                                    $previous = $page - 1;
                                    $next = $page + 1;

                                    $data_amount = sizeof($surat);
                                    $total_page = ceil($data_amount / $limit);

                                    
                                    for ($i = 0; $i < sizeof($surat); $i++) {
                                        $date = formatDate($surat[$i]['waktu_kegiatan'], 'd F Y H:i');
                                        $kegiatan = 'Acara : '.$surat[$i]['nama_kegiatan'].'<br>'.'Waktu : '.$date.'<br>'.'Tempat : '.$surat[$i]['tempat_kegiatan'];
                                        $surat[$i]['kegiatan'] = $kegiatan;
                                        
                                    }

                                    $data_surat = array_slice($surat,$first_page, $limit);

                                    $no = $first_page+1;
                                    
                                ?>
                                <?php foreach ($surat as $bk) : ?>
                                    <tr>
                                        <th scope="row"><?= $no++; ?></th>
                                        <td><?php echo $bk['kegiatan']; ?></td>
                                        <td><?= $bk['asal_surat']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination justify-content-center">
                                <li class="page-item">
                                    <a class="page-link" <?php if($page > 1){ echo "href='?page=$previous'"; } ?>>Previous</a>
                                </li>
                                <?php 
                                for($x=1;$x<=$total_page;$x++){
                                    ?> 
                                    <li class="page-item"><a class="page-link" href="?page=<?php echo $x ?>"><?php echo $x; ?></a></li>
                                    <?php
                                }
                                ?>				
                                <li class="page-item">
                                    <a  class="page-link" <?php if($page < $total_page) { echo "href='?page=$next'"; } ?>>Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </section>
</div>

<?php
require 'mysql-footer.php';
require 'templates/dashboard/footer.php';
?>