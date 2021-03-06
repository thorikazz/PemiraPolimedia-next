<?php
session_start();
if (!isset($_SESSION["login"])) {
	header("location:login.php");
	exit;
}
if ($_SESSION['status'] == 'Sudah memilih') {
	header("location:index.php");
	exit;
}
include 'koneksi.php';
include 'header.php';
?>

<body>
	<!--Preloader-->
	<div class="preloader-it">
		<div class="la-anim-1"></div>
	</div>
	<!--/Preloader-->
	<div class="wrapper theme-6-active pimary-color-pink">

		<!-- Main Content -->
		<div class="page-wrapper pa-0 ma-0 auth path">
			<div class="container-fluid">
				<!-- Title -->
				<div class="row heading-bg">
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
						<h5 class="txt-dark">Ketua & Wakil HIMA</h5>
					</div>
				</div>
				<!-- /Title -->

                <!-- Product Row One -->
                <!-- Cek jika pemilih sudah melakukan voting -->
                <?php if ($_SESSION["status"] == "Sudah memilih") { ?>
                    <?php //$cek = mysqli_query($koneksi,"SELECT * FROM voting WHERE voting_pemilih='$status'"); ?>
                    <?php //$c = mysqli_num_rows($cek); ?>
                    <?php //if($c > 0) : ?>
                        
                        <center>
                        <div class='alert alert-danger'><br>Anda sudah melakukan voting! <br> Setiap pemilih hanya bisa melakukan sekali voting.</div>
                        </center>
                        <br>
                        <h5 class="text-dark ">Kandidat Pilihan Anda</h5>
                        <hr>
                        <div class="row">

                        <?php //$data = mysqli_fetch_assoc($cek); ?>
                        <?php //$kandidat_pilihan = $data['voting_kandidat']; ?>
                        <!-- menampilkan kandidat pilihan pemilih -->
                        <?php $data = mysqli_query($koneksi,"SELECT * FROM calon_bph_mpm WHERE id='$kandidat_pilihan'") ?>
                        <?php while($d = mysqli_fetch_array($data)) : ?>
                            <div class="col-lg-3 offset-lg-4">
                            <div class="pricing-box p-2 pilih-kandidat" id="<?php echo $d['id']; ?>">
                                <h2 class="text-amount mb-4 mt-2">BPH-MPM</h2>
                                <?php if($d['foto'] == ""){ ?>
                                <img src="foto/bph_mpm/<?php echo $d['foto']; ?>" style="width: 190px;height: auto;">
                                <?php }else{ ?>
                                <img src="foto/bph_mpm/<?php echo $d['foto']; ?>" style="width: 190px;height: auto;">
                                <?php } ?>
                                <!-- <img src="assets_depan/images/starter.svg" alt="starter"> -->
                                <h6 class="font-weight-medium title-text"><?php echo $d['nama']; ?></h6>
                                <br>
                                <br>
                            </div>
                            </div>
                        <?php endwhile; ?>
                        </div>
                    <?php //endif; ?>

                <?php } else if ($_SESSION["status"] == "Belum memilih") { ?>

                <form action="aksi_voting_calon4.php" method="post">
                    
				<?php
				$kolom = 0;
				$proses = false;
				$prodi = $_SESSION['prodi'];
				if ($prodi == "Teknik Grafika" || $prodi == "Teknik Kemasan" || $prodi == "Teknik Perbaikan Mesin") : 
				$jurusan = "Teknik";
				endif; 
				
				$data_calon_ketua_dan_wakil_hima = mysqli_query($koneksi, "SELECT * FROM calon_hima WHERE prodi='$prodi' OR jurusan='$jurusan' ");
				while ($d = mysqli_fetch_array($data_calon_ketua_dan_wakil_hima)) {
				?>
					<?php $kolom++;
					if ($kolom == 1) {
						echo "<div class='row'>";
						$proses = true;
					}
					?>
					<div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
						<div class="panel panel-default card-view pa-0">
							<div class="panel-wrapper collapse in">
								<div class="panel-body pa-0">
									<article class="col-item">
										<div class="photo">
											<div class="options">
												<span class="label label-success"><?php echo $d['no_urut']; ?></span>
											</div>
											<div id="myModal<?= $d['id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button>
															<h5 class="modal-title" id="myModalLabel">
																	<?= $d['nama_ketua']; ?>
																<?php if (!empty($d['nama_wakil_1'])) : ?>
																	<?php echo ' & ';
																		echo $d['nama_wakil_1']; ?>
																<?php endif; ?>
																<?php if (!empty($d['nama_wakil_2'])) : ?>
																	<?php echo ' & ';
																		echo $d['nama_wakil_2']; ?>
																<?php endif; ?></h5>
														</div>
														<div class="modal-body">
															<img src="foto/hima/<?= $d['foto']; ?>" width="25" class="img-responsive" alt="Product Image" />
															<br>
															<p>No Urut: <?php echo $d['no_urut']; ?></p>
															<p style="font: bold;">Ketua</p>
															<p>NIM: <?php echo $d['nim_ketua']; ?></p>
															<p>Tempat Tanggal Lahir: <?php echo $d['ttl_ketua']; ?></p>
															<p>Jenis Kelamin: <?php echo $d['jenis_kelamin_ketua']; ?></p>
															<p>Semester: <?php echo $d['semester_ketua']; ?></p>
															<br>
															<p style="font: bold;">Wakil Ketua</p>
															<p>NIM: <?php echo $d['nim_wakil_1']; ?></p>
															<p>Tempat Tanggal Lahir: <?php echo $d['ttl_wakil_1']; ?></p>
															<p>Jenis Kelamin: <?php echo $d['jenis_kelamin_wakil_1']; ?></p>
															<p>Semester: <?php echo $d['semester_wakil_1']; ?></p>
															<br>
															<?php if (!empty($d['nama_wakil_2'])) : ?>
															<p style="font: bold;">Wakil Ketua</p>
															<p>NIM: <?php echo $d['nim_wakil_2']; ?></p>
															<p>Tempat Tanggal Lahir: <?php echo $d['ttl_wakil_2']; ?></p>
															<p>Jenis Kelamin: <?php echo $d['jenis_kelamin_wakil_2']; ?></p>
															<p>Semester: <?php echo $d['semester_wakil_2']; ?></p>
															<br>
															<?php endif; ?>
															<p><?php if ($d['prodi'] == "Teknik Kemasan" || $d['prodi'] == "Teknik Grafika" || $d['prodi'] == "Teknik Perbaikan Mesin") : ?>
																	<?php echo "Jurusan:"; ?>
																<?php else : ?>
																	<?php echo "Prodi:"; ?>
																<?php endif; ?>
																<?php if ($d['prodi'] == "Teknik Kemasan" || $d['prodi'] == "Teknik Grafika" || $d['prodi'] == "Teknik Perbaikan Mesin") : ?>
																	<?php echo $d['jurusan']; ?>
																<?php else : ?>
																	<?php echo $d['prodi']; ?>
																<?php endif; ?></p>														
															<p>Visi & Misi: <?php echo $d['visi_dan_misi']; ?></p>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
														</div>
													</div>
													<!-- /.modal-content -->
												</div>
												<!-- /.modal-dialog -->
											</div>
											<!-- /.modal -->
											<!-- Button trigger modal -->
											<img src="foto/hima/<?= $d['foto']; ?>" alt="default" data-toggle="modal" data-target="#myModal" class="model_img img-responsive" />
										</div>
										<div class="info">
											<h6><?= $d['nama_ketua']; ?></h6>
											<?php if (!empty($d['nama_wakil_1'])) : ?>
												<h6><?php echo ' & ';
													echo $d['nama_wakil_1']; ?></h6>
											<?php endif; ?>
											<?php if (!empty($d['nama_wakil_2'])) : ?>
												<h6><?php echo ' & ';
													echo $d['nama_wakil_2']; ?></h6>
											<?php endif; ?>
											<?php if ($d['prodi'] == "Teknik Grafika" || $d['prodi'] == "Teknik Kemasan" || $d['prodi'] == "Teknik Perbaikan Mesin") : ?>
												<span class="head-font block text-warning font-12"><?php echo $d['jurusan']; ?></span>
											<?php else : ?>
												<span class="head-font block text-warning font-12"><?php echo $d['prodi']; ?></span>
											<?php endif; ?>
                                                <center>
                                                    <input type="radio" id="centang_kandidat_<?php echo $d['id']; ?>" name="pilihan4" value="<?php echo $d['no_urut'] ?>" required="required">
                                                </center>
                                            </div>
                                        </article>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($kolom == 6) {
                            echo "</div>";
                            $proses = false;
                            $kolom = 0;
                        }
                        ?>
                    <?php } ?>
                    <?php
                    if ($proses == true) {
                        echo "</div>";
                    }
                    ?>

                <br><br>    
                <center>
                    <input type="submit" class="btn btn-success" name="voting" value="voting">
                </center>
                <?php } ?>
                <br><br>    
                </form>
			</div>
			<?php
echo $_SESSION["id"];
echo '<br>';
echo $_SESSION['nim'];
echo '<br>';
echo $_SESSION['nama_mhs'];
echo '<br>';
echo $_SESSION['prodi'];
echo '<br>';
echo $_SESSION['semester'];
echo '<br>';
echo $_SESSION['status'];
echo '<br>';
echo $_SESSION['kode_akses'];
echo '<br>';
echo $_SESSION['level'];
?>

<?php include 'footer.php'; ?>