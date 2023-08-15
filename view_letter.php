<?php
setlocale(LC_ALL, 'IND');
require 'connection.php';
require 'global.php';
require 'templates/dashboard/header.php';
require 'templates/dashboard/sidebar.php';

guardAuth();
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM surat WHERE id='$id'";
    $result = mysqli_query($conn, $sql);

    setFlash('alert', 'success', 'Data surat berhasil dihapus');
}

$sqlQuerySearch = '';

$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';

if (isset($_POST['search']) && $keyword) {
    $sqlQuerySearch = " WHERE nama_kegiatan LIKE '%$keyword%' OR tempat_kegiatan LIKE '%$keyword%' OR asal_surat LIKE '%$keyword%'";
}

$sql = "SELECT * FROM surat" . $sqlQuerySearch;
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
                                    <th scope="col">Nama Kegiatan</th>
                                    <th scope="col">Waktu Kegiatan</th>
                                    <th scope="col">Tempat Kegiatan</th>
                                    <th scope="col">Asal Surat</th>
                                    <th scope="col">Action</th>
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

                                    $data_surat = array_slice($surat,$first_page, $limit);

                                    $no = $first_page+1;
                                ?>
                                <?php foreach ($data_surat as $bk) : ?>
                                    <tr>
                                        <th scope="row"><?= $no++; ?></th>
                                        <td><?= $bk['nama_kegiatan']; ?></td>
                                        <td><?= formatDate($bk['waktu_kegiatan'], 'd F Y H:i'); ?></td>
                                        <td><?= $bk['tempat_kegiatan']; ?></td>
                                        <td><?= $bk['asal_surat']; ?></td>
                                        <td>
                                            <a href="edit_letter.php?id=<?= $bk['id']; ?>" class="badge text-bg-primary">edit</a>
                                            <form action="" method="post" class="d-inline-block">
                                                <input type="hidden" name="id" value="<?= $bk['id']; ?>">
                                                <button name="hapus" class="badge text-bg-danger border-0">hapus</button>
                                            </form>
                                        </td>
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