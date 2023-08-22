<?php
require 'connection.php';
require 'global.php';
require 'templates/dashboard/header.php';

if(auth()['user']['type'] == 'admin'){
    require 'templates/dashboard/sidebar.php';
} else {
    require 'templates/dashboard/sidebar_user.php';
}

guardAuth();

$current = date("d-m-Y h:i:sa");

// echo $current;

$sqlQuerySearch = '';

$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
$month = isset($_POST['month']) ? $_POST['month'] : date('m');
$year = isset($_POST['year']) ? $_POST['year'] : date('Y');

if (isset($_POST['search']) && $keyword) {
    $sqlQuerySearch = " AND nama_kegiatan LIKE '%$keyword%' OR tempat_kegiatan LIKE '%$keyword%' OR asal_surat LIKE '%$keyword%'";
}

$sql = "SELECT * FROM surat WHERE waktu_kegiatan >= DATE(NOW()) AND month(waktu_kegiatan)='$month' AND year(waktu_kegiatan) = '$year'" . $sqlQuerySearch;
$surat = query($sql)->fetch_all(MYSQLI_ASSOC);

?>
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
                            <div class="form-group">
                                <select name='month' style='padding:4px'>
                                        <option value="01" <?php echo ($month)=='01' ?'selected' :'' ?>>Januari</option>
                                        <option value="02" <?php echo ($month)=='02' ?'selected' :'' ?>>Februari</option>
                                        <option value="03" <?php echo ($month)=='03' ?'selected' :'' ?>>Maret</option>
                                        <option value="04" <?php echo ($month)=='04' ?'selected' :'' ?>>April</option>
                                        <option value="05" <?php echo ($month)=='05' ?'selected' :'' ?>>Mei</option>
                                        <option value="06" <?php echo ($month)=='06' ?'selected' :'' ?>>Juni</option>
                                        <option value="07" <?php echo ($month)=='07' ?'selected' :'' ?>>Juli</option>
                                        <option value="08" <?php echo ($month)=='08' ?'selected' :'' ?>>Agustus</option>
                                        <option value="09" <?php echo ($month)=='09' ?'selected' :'' ?>>September</option>
                                        <option value="10" <?php echo ($month)=='10' ?'selected' :'' ?>>Oktober</option>
                                        <option value="11" <?php echo ($month)=='11' ?'selected' :'' ?>>November</option>
                                        <option value="12" <?php echo ($month)=='12' ?'selected' :'' ?>>Desember</option>
                                </select>
                                <select name="year" style='padding:4px'>
                                    <?php
                                    $mulai= date('Y') - 5;
                                    for($i = $mulai;$i<$mulai + 10;$i++){
                                        $sel = $i == $year ? 'selected' : '';
                                        echo '<option value="'.$i.'"'.$sel.'>'.$i.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Cari Surat..." name="keyword" value="<?= $keyword ?>" />
                                <button class="btn btn-outline-primary" type="submit" name="search" value="1">Cari</button>
                            </div>
                        </form>
                        <div id="docx">
                            <div class="WordSection1">
                            <table class="table table-bordered table-striped yajra-datatable">
                                <thead>
                                    <tr>
                                        <th scope="col" class="number">No</th>
                                        <th scope="col" class="activity">Kegiatan</th>
                                        <th scope="col" class="origin">Asal Surat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php foreach ($surat as $bk) : ?>
                                        <tr>
                                            <td scope="row" class="number"><?= $no++; ?></th>
                                            <td class="activity"><?php echo $bk['kegiatan']; ?></td>
                                            <td class="origin"><?= $bk['asal_surat']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            </div>
                            
                        </div>
                        
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
                        <div class="card-footer clearfix">
                            <button class="btn btn-sm btn-info float-left" id='export'>Export to Word</button>
                            <!-- <a href="#" class="btn btn-sm btn-info float-left" id="myButton">Export to Word</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </section>
</div>

<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<script>
  $(document).ready(function(e){
    $("#myButton").click(function(e){

      $(".yajra-datatable").table2excel({

        name:"Worksheet Name",

        filename:"kegiatan",//do not include extension

        fileext:".xlsx" // file extension

      });

    });

  });

</script>
<script>
    window.export.onclick = function() {
 
 if (!window.Blob) {
    alert('Your legacy browser does not support this action.');
    return;
 }

 var html, link, blob, url, css;
 
 // EU A4 use: size: 841.95pt 595.35pt;
 // US Letter use: size:11.0in 8.5in;
 
 css = (
   '<style>' +
   'table{margin: 20px auto;border-collapse:collapse;} th.number{border:1px gray solid;width:5em;padding:2px;} th.activity{border:1px gray solid;width:25em;padding:2px;} th.origin{border:1px gray solid;width:10em;padding:2px;} td.number{border:1px gray solid;width:5em;padding:2px;text-align: center;} td.activity{border:1px gray solid;width:25em;padding:2px;} td.origin{border:1px gray solid;width:10em;padding:2px;text-align: center;} .'+
   '</style>'
 );
 
 html = window.docx.innerHTML;
 blob = new Blob(['\ufeff', css + html], {
   type: 'application/msword'
 });
 url = URL.createObjectURL(blob);
 link = document.createElement('A');
 link.href = url;
 // Set default file name. 
 // Word will append file extension - do not add an extension here.
 link.download = 'jadwal';   
 document.body.appendChild(link);
 if (navigator.msSaveOrOpenBlob ) navigator.msSaveOrOpenBlob( blob, 'jadwal.doc'); // IE10-11
         else link.click();  // other browsers
 document.body.removeChild(link);
};
    
</script>



<?php
require 'mysql-footer.php';
require 'templates/dashboard/footer.php';
?>