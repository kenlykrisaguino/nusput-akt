<tr>
                              <th>
                              <select class="form-control select2" name="kode_akun" id="kode_akun" >
                                <option value="">Pilih Akun</option>
                              <?php
                              $query = "SELECT * FROM akun WHERE status = 1";
                              $result = $konektor->query($query);
                              $num_result = $result->num_rows;
                              if ($num_result > 0) {
                                  while ($data = $result->fetch_assoc()) {
                                      $kode_akun = $data['kode_akun'];
                                      $akun = $data['nama_akun'];
                                      $saldo_normal = $data['saldo_normal'];
                              ?>
                          <option value="<?= $kode_akun ?>" data-bank="<?= $akun ?>" data-saldo-normal="<?= $saldo_normal ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                              <?php
                              }}
?>
                              </select>
                              </th>
                            <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun" id="akun" readonly>
                            <input type="hidden" class="form-control col-sm-4" id="saldo_normal" readonly>

                              <th>
                              <select class="form-control select2" name="kode_jenjang" id="kode_jenjang" required="">
                                        <option value="">Pilih Jenjang</option>
                                      <?php
                                      $query = "SELECT * FROM master_jenjang";
                                      $result = $konektor->query($query);
                                      $num_result = $result->num_rows;
                                      if ($num_result > 0) {
                                        while ($data = $result->fetch_assoc()) {
                                            $kode_jenjang = $data['kode_jenjang'];
                                            $nama_jenjang = $data['nama_jenjang'];
                                      ?>
                                        <option value="<?= $kode_jenjang ?>" data-name="<?= $nama_jenjang ?>"><?= $kode_jenjang . ' → ' . $nama_jenjang ?></option>
                                      <?php
                                        }}
                                      ?>
                                        </select>
                                        <input type="hidden" class="form-control col-sm-4" id="nama_jenjang" readonly>
                                      </div>
                              </th>

                            <th><input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Input Keterangan"></th>
                            <th><input style="text-align:center" type="text" class="form-control" name="saldo" id="saldo" oninput="formatNumber(this); calculateTotal();" ></th>
                            </tr>

                            <tr>
                              <th>
                              <select class="form-control select2" name="kode_akun" id="kode_akun" >
                                <option value="">Pilih Akun</option>
                              <?php
                              $query = "SELECT * FROM akun WHERE status = 1";
                              $result = $konektor->query($query);
                              $num_result = $result->num_rows;
                              if ($num_result > 0) {
                                  while ($data = $result->fetch_assoc()) {
                                      $kode_akun = $data['kode_akun'];
                                      $akun = $data['nama_akun'];
                                      $saldo_normal = $data['saldo_normal'];
                              ?>
                          <option value="<?= $kode_akun ?>" data-bank="<?= $akun ?>" data-saldo-normal="<?= $saldo_normal ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                              <?php
                              }}
?>
                              </select>
                              </th>
                            <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun" id="akun" readonly>
                            <input type="hidden" class="form-control col-sm-4" id="saldo_normal" readonly>
                              <th>
                              <select class="form-control select2" name="kode_jenjang" id="kode_jenjang" required="">
                                        <option value="">Pilih Jenjang</option>
                                      <?php
                                      $query = "SELECT * FROM master_jenjang";
                                      $result = $konektor->query($query);
                                      $num_result = $result->num_rows;
                                      if ($num_result > 0) {
                                        while ($data = $result->fetch_assoc()) {
                                            $kode_jenjang = $data['kode_jenjang'];
                                            $nama_jenjang = $data['nama_jenjang'];
                                      ?>
                                        <option value="<?= $kode_jenjang ?>" data-name="<?= $nama_jenjang ?>"><?= $kode_jenjang . ' → ' . $nama_jenjang ?></option>
                                      <?php
                                        }}
                                      ?>
                                        </select>
                                        <input type="hidden" class="form-control col-sm-4" id="nama_jenjang" readonly>
                                      </div>
                              </th>

                            <th><input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Input Keterangan"></th>
                            <th><input style="text-align:center" type="text" class="form-control" name="saldo" id="saldo" oninput="formatNumber(this); calculateTotal();" ></th>
                            </tr>

                            <tr>
                              <th>
                              <select class="form-control select2" name="kode_akun" id="kode_akun" >
                                <option value="">Pilih Akun</option>
                              <?php
                              $query = "SELECT * FROM akun WHERE status = 1";
                              $result = $konektor->query($query);
                              $num_result = $result->num_rows;
                              if ($num_result > 0) {
                                  while ($data = $result->fetch_assoc()) {
                                      $kode_akun = $data['kode_akun'];
                                      $akun = $data['nama_akun'];
                                      $saldo_normal = $data['saldo_normal'];
                              ?>
                          <option value="<?= $kode_akun ?>" data-bank="<?= $akun ?>" data-saldo-normal="<?= $saldo_normal ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                              <?php
                              }}
?>
                              </select>
                              </th>
                            <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun" id="akun" readonly>
                            <input type="hidden" class="form-control col-sm-4" id="saldo_normal" readonly>
                              <th>
                              <select class="form-control select2" name="kode_jenjang" id="kode_jenjang" required="">
                                        <option value="">Pilih Jenjang</option>
                                      <?php
                                      $query = "SELECT * FROM master_jenjang";
                                      $result = $konektor->query($query);
                                      $num_result = $result->num_rows;
                                      if ($num_result > 0) {
                                        while ($data = $result->fetch_assoc()) {
                                            $kode_jenjang = $data['kode_jenjang'];
                                            $nama_jenjang = $data['nama_jenjang'];
                                      ?>
                                        <option value="<?= $kode_jenjang ?>" data-name="<?= $nama_jenjang ?>"><?= $kode_jenjang . ' → ' . $nama_jenjang ?></option>
                                      <?php
                                        }}
                                      ?>
                                        </select>
                                        <input type="hidden" class="form-control col-sm-4" id="nama_jenjang" readonly>
                                      </div>
 
                              </th>

                            <th><input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Input Keterangan"></th>
                            <th><input style="text-align:center" type="text" class="form-control" name="saldo" id="saldo" oninput="formatNumber(this); calculateTotal();" ></th>
                            </tr>

                            <tr>
                              <th>
                              <select class="form-control select2" name="kode_akun" id="kode_akun" >
                                <option value="">Pilih Akun</option>
                              <?php
                              $query = "SELECT * FROM akun WHERE status = 1";
                              $result = $konektor->query($query);
                              $num_result = $result->num_rows;
                              if ($num_result > 0) {
                                  while ($data = $result->fetch_assoc()) {
                                      $kode_akun = $data['kode_akun'];
                                      $akun = $data['nama_akun'];
                                      $saldo_normal = $data['saldo_normal'];
                              ?>
                          <option value="<?= $kode_akun ?>" data-bank="<?= $akun ?>" data-saldo-normal="<?= $saldo_normal ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                              <?php
                              }}
?>
                              </select>
                              </th>
                            <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun" id="akun" readonly>
                            <input type="hidden" class="form-control col-sm-4" id="saldo_normal" readonly>

                              <th>
                              <select class="form-control select2" name="kode_jenjang" id="kode_jenjang" required="">
                                        <option value="">Pilih Jenjang</option>
                                      <?php
                                      $query = "SELECT * FROM master_jenjang";
                                      $result = $konektor->query($query);
                                      $num_result = $result->num_rows;
                                      if ($num_result > 0) {
                                        while ($data = $result->fetch_assoc()) {
                                            $kode_jenjang = $data['kode_jenjang'];
                                            $nama_jenjang = $data['nama_jenjang'];
                                      ?>
                                        <option value="<?= $kode_jenjang ?>" data-name="<?= $nama_jenjang ?>"><?= $kode_jenjang . ' → ' . $nama_jenjang ?></option>
                                      <?php
                                        }}
                                      ?>
                                        </select>
                                        <input type="hidden" class="form-control col-sm-4" id="nama_jenjang" readonly>
                                      </div>


                            <th><input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Input Keterangan"></th>
                            <th><input style="text-align:center" type="text" class="form-control" name="saldo" id="saldo" oninput="formatNumber(this); calculateTotal();" ></th>
                            </tr>

                            <tr>
                              <th>
                              <select class="form-control select2" name="kode_akun" id="kode_akun" >
                                <option value="">Pilih Akun</option>
                              <?php
                              $query = "SELECT * FROM akun WHERE status = 1";
                              $result = $konektor->query($query);
                              $num_result = $result->num_rows;
                              if ($num_result > 0) {
                                  while ($data = $result->fetch_assoc()) {
                                      $kode_akun = $data['kode_akun'];
                                      $akun = $data['nama_akun'];
                                      $saldo_normal = $data['saldo_normal'];
                              ?>
                          <option value="<?= $kode_akun ?>" data-bank="<?= $akun ?>" data-saldo-normal="<?= $saldo_normal ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                              <?php
                              }}
?>
                              </select>
                              </th>
                            <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun" id="akun" readonly>
                            <input type="hidden" class="form-control col-sm-4" id="saldo_normal" readonly>

                              <th>
                              <select class="form-control select2" name="kode_jenjang" id="kode_jenjang" required="">
                                        <option value="">Pilih Jenjang</option>
                                      <?php
                                      $query = "SELECT * FROM master_jenjang";
                                      $result = $konektor->query($query);
                                      $num_result = $result->num_rows;
                                      if ($num_result > 0) {
                                        while ($data = $result->fetch_assoc()) {
                                            $kode_jenjang = $data['kode_jenjang'];
                                            $nama_jenjang = $data['nama_jenjang'];
                                      ?>
                                        <option value="<?= $kode_jenjang ?>" data-name="<?= $nama_jenjang ?>"><?= $kode_jenjang . ' → ' . $nama_jenjang ?></option>
                                      <?php
                                        }}
                                      ?>
                                        </select>
                                        <input type="hidden" class="form-control col-sm-4" id="nama_jenjang" readonly>
                                      </div>

                              </th>

                            <th><input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Input Keterangan"></th>
                            <th><input style="text-align:center" type="text" class="form-control" name="saldo" id="saldo" oninput="formatNumber(this); calculateTotal();" ></th>
                            </tr>

                            <tr>
                              <th>
                              <select class="form-control select2" name="kode_akun" id="kode_akun" >
                                <option value="">Pilih Akun</option>
                              <?php
                              $query = "SELECT * FROM akun WHERE status = 1";
                              $result = $konektor->query($query);
                              $num_result = $result->num_rows;
                              if ($num_result > 0) {
                                  while ($data = $result->fetch_assoc()) {
                                      $kode_akun = $data['kode_akun'];
                                      $akun = $data['nama_akun'];
                                      $saldo_normal = $data['saldo_normal'];
                              ?>
                          <option value="<?= $kode_akun ?>" data-bank="<?= $akun ?>" data-saldo-normal="<?= $saldo_normal ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                              <?php
                              }}
?>
                              </select>
                              </th>
                            <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun" id="akun" readonly>
                            <input type="hidden" class="form-control col-sm-4" id="saldo_normal" readonly>

                              <th>
                              <select class="form-control select2" name="kode_jenjang" id="kode_jenjang" required="">
                                        <option value="">Pilih Jenjang</option>
                                      <?php
                                      $query = "SELECT * FROM master_jenjang";
                                      $result = $konektor->query($query);
                                      $num_result = $result->num_rows;
                                      if ($num_result > 0) {
                                        while ($data = $result->fetch_assoc()) {
                                            $kode_jenjang = $data['kode_jenjang'];
                                            $nama_jenjang = $data['nama_jenjang'];
                                      ?>
                                        <option value="<?= $kode_jenjang ?>" data-name="<?= $nama_jenjang ?>"><?= $kode_jenjang . ' → ' . $nama_jenjang ?></option>
                                      <?php
                                        }}
                                      ?>
                                        </select>
                                        <input type="hidden" class="form-control col-sm-4" id="nama_jenjang" readonly>
                                      </div>


                            <th><input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Input Keterangan"></th>
                            <th><input style="text-align:center" type="text" class="form-control" name="saldo" id="saldo" oninput="formatNumber(this); calculateTotal();" ></th>
                            </tr>

                            <tr>
                              <th>
                              <select class="form-control select2" name="kode_akun" id="kode_akun" >
                                <option value="">Pilih Akun</option>
                              <?php
                              $query = "SELECT * FROM akun WHERE status = 1";
                              $result = $konektor->query($query);
                              $num_result = $result->num_rows;
                              if ($num_result > 0) {
                                  while ($data = $result->fetch_assoc()) {
                                      $kode_akun = $data['kode_akun'];
                                      $akun = $data['nama_akun'];
                                      $saldo_normal = $data['saldo_normal'];
                              ?>
                          <option value="<?= $kode_akun ?>" data-bank="<?= $akun ?>" data-saldo-normal="<?= $saldo_normal ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                              <?php
                              }}
?>
                              </select>
                              </th>
                            <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun" id="akun" readonly>
                            <input type="hidden" class="form-control col-sm-4" id="saldo_normal" readonly>
       
                              <th>
                              <select class="form-control select2" name="kode_jenjang" id="kode_jenjang" required="">
                                        <option value="">Pilih Jenjang</option>
                                      <?php
                                      $query = "SELECT * FROM master_jenjang";
                                      $result = $konektor->query($query);
                                      $num_result = $result->num_rows;
                                      if ($num_result > 0) {
                                        while ($data = $result->fetch_assoc()) {
                                            $kode_jenjang = $data['kode_jenjang'];
                                            $nama_jenjang = $data['nama_jenjang'];
                                      ?>
                                        <option value="<?= $kode_jenjang ?>" data-name="<?= $nama_jenjang ?>"><?= $kode_jenjang . ' → ' . $nama_jenjang ?></option>
                                      <?php
                                        }}
                                      ?>
                                        </select>
                                        <input type="hidden" class="form-control col-sm-4" id="nama_jenjang" readonly>
                                      </div>
    
                              </th>

                            <th><input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Input Keterangan"></th>
                            <th><input style="text-align:center" type="text" class="form-control" name="saldo" id="saldo" oninput="formatNumber(this); calculateTotal();" ></th>
                            </tr>

                            <tr>
                              <th>
                              <select class="form-control select2" name="kode_akun" id="kode_akun" >
                                <option value="">Pilih Akun</option>
                              <?php
                              $query = "SELECT * FROM akun WHERE status = 1";
                              $result = $konektor->query($query);
                              $num_result = $result->num_rows;
                              if ($num_result > 0) {
                                  while ($data = $result->fetch_assoc()) {
                                      $kode_akun = $data['kode_akun'];
                                      $akun = $data['nama_akun'];
                                      $saldo_normal = $data['saldo_normal'];
                              ?>
                          <option value="<?= $kode_akun ?>" data-bank="<?= $akun ?>" data-saldo-normal="<?= $saldo_normal ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                              <?php
                              }}
?>
                              </select>
                              </th>
                            <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun" id="akun" readonly>
                            <input type="hidden" class="form-control col-sm-4" id="saldo_normal" readonly>
 
                              <th>
                              <select class="form-control select2" name="kode_jenjang" id="kode_jenjang" required="">
                                        <option value="">Pilih Jenjang</option>
                                      <?php
                                      $query = "SELECT * FROM master_jenjang";
                                      $result = $konektor->query($query);
                                      $num_result = $result->num_rows;
                                      if ($num_result > 0) {
                                        while ($data = $result->fetch_assoc()) {
                                            $kode_jenjang = $data['kode_jenjang'];
                                            $nama_jenjang = $data['nama_jenjang'];
                                      ?>
                                        <option value="<?= $kode_jenjang ?>" data-name="<?= $nama_jenjang ?>"><?= $kode_jenjang . ' → ' . $nama_jenjang ?></option>
                                      <?php
                                        }}
                                      ?>
                                        </select>
                                        <input type="hidden" class="form-control col-sm-4" id="nama_jenjang" readonly>
                                      </div>
 
                              </th>

                            <th><input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Input Keterangan"></th>
                            <th><input style="text-align:center" type="text" class="form-control" name="saldo" id="saldo" oninput="formatNumber(this); calculateTotal();" ></th>
                            </tr>

                            <tr>
                              <th>
                              <select class="form-control select2" name="kode_akun" id="kode_akun" >
                                <option value="">Pilih Akun</option>
                              <?php
                              $query = "SELECT * FROM akun WHERE status = 1";
                              $result = $konektor->query($query);
                              $num_result = $result->num_rows;
                              if ($num_result > 0) {
                                  while ($data = $result->fetch_assoc()) {
                                      $kode_akun = $data['kode_akun'];
                                      $akun = $data['nama_akun'];
                                      $saldo_normal = $data['saldo_normal'];
                              ?>
                          <option value="<?= $kode_akun ?>" data-bank="<?= $akun ?>" data-saldo-normal="<?= $saldo_normal ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                              <?php
                              }}
?>
                              </select>
                              </th>
                            <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun" id="akun" readonly>
                            <input type="hidden" class="form-control col-sm-4" id="saldo_normal" readonly>

                              <th>
                              <select class="form-control select2" name="kode_jenjang" id="kode_jenjang" required="">
                                        <option value="">Pilih Jenjang</option>
                                      <?php
                                      $query = "SELECT * FROM master_jenjang";
                                      $result = $konektor->query($query);
                                      $num_result = $result->num_rows;
                                      if ($num_result > 0) {
                                        while ($data = $result->fetch_assoc()) {
                                            $kode_jenjang = $data['kode_jenjang'];
                                            $nama_jenjang = $data['nama_jenjang'];
                                      ?>
                                        <option value="<?= $kode_jenjang ?>" data-name="<?= $nama_jenjang ?>"><?= $kode_jenjang . ' → ' . $nama_jenjang ?></option>
                                      <?php
                                        }}
                                      ?>
                                        </select>
                                        <input type="hidden" class="form-control col-sm-4" id="nama_jenjang" readonly>
                                      </div>

                              </th>

                            <th><input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Input Keterangan"></th>
                            <th><input style="text-align:center" type="text" class="form-control" name="saldo" id="saldo" oninput="formatNumber(this); calculateTotal();" ></th>
                            </tr>

                            <tr>
                              <th>
                              <select class="form-control select2" name="kode_akun" id="kode_akun" >
                                <option value="">Pilih Akun</option>
                              <?php
                              $query = "SELECT * FROM akun WHERE status = 1";
                              $result = $konektor->query($query);
                              $num_result = $result->num_rows;
                              if ($num_result > 0) {
                                  while ($data = $result->fetch_assoc()) {
                                      $kode_akun = $data['kode_akun'];
                                      $akun = $data['nama_akun'];
                                      $saldo_normal = $data['saldo_normal'];
                              ?>
                          <option value="<?= $kode_akun ?>" data-bank="<?= $akun ?>" data-saldo-normal="<?= $saldo_normal ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                              <?php
                              }}
?>
                              </select>
                              </th>
                            <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun" id="akun" readonly>
                            <input type="hidden" class="form-control col-sm-4" id="saldo_normal" readonly>

                              <th>
                              <select class="form-control select2" name="kode_jenjang" id="kode_jenjang" required="">
                                        <option value="">Pilih Jenjang</option>
                                      <?php
                                      $query = "SELECT * FROM master_jenjang";
                                      $result = $konektor->query($query);
                                      $num_result = $result->num_rows;
                                      if ($num_result > 0) {
                                        while ($data = $result->fetch_assoc()) {
                                            $kode_jenjang = $data['kode_jenjang'];
                                            $nama_jenjang = $data['nama_jenjang'];
                                      ?>
                                        <option value="<?= $kode_jenjang ?>" data-name="<?= $nama_jenjang ?>"><?= $kode_jenjang . ' → ' . $nama_jenjang ?></option>
                                      <?php
                                        }}
                                      ?>
                                        </select>
                                        <input type="hidden" class="form-control col-sm-4" id="nama_jenjang" readonly>
                                      </div>
    
                              </th>

                            <th><input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Input Keterangan"></th>
                            <th><input style="text-align:center" type="text" class="form-control" name="saldo" id="saldo" oninput="formatNumber(this); calculateTotal();" ></th>
                            </tr>

                            <tr>
                              <th>
                              <select class="form-control select2" name="kode_akun" id="kode_akun" >
                                <option value="">Pilih Akun</option>
                              <?php
                              $query = "SELECT * FROM akun WHERE status = 1";
                              $result = $konektor->query($query);
                              $num_result = $result->num_rows;
                              if ($num_result > 0) {
                                  while ($data = $result->fetch_assoc()) {
                                      $kode_akun = $data['kode_akun'];
                                      $akun = $data['nama_akun'];
                                      $saldo_normal = $data['saldo_normal'];
                              ?>
                          <option value="<?= $kode_akun ?>" data-bank="<?= $akun ?>" data-saldo-normal="<?= $saldo_normal ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                              <?php
                              }}
?>
                              </select>
                              </th>
                            <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun" id="akun" readonly>
                            <input type="hidden" class="form-control col-sm-4" id="saldo_normal" readonly>

                              <th>
                              <select class="form-control select2" name="kode_jenjang" id="kode_jenjang" required="">
                                        <option value="">Pilih Jenjang</option>
                                      <?php
                                      $query = "SELECT * FROM master_jenjang";
                                      $result = $konektor->query($query);
                                      $num_result = $result->num_rows;
                                      if ($num_result > 0) {
                                        while ($data = $result->fetch_assoc()) {
                                            $kode_jenjang = $data['kode_jenjang'];
                                            $nama_jenjang = $data['nama_jenjang'];
                                      ?>
                                        <option value="<?= $kode_jenjang ?>" data-name="<?= $nama_jenjang ?>"><?= $kode_jenjang . ' → ' . $nama_jenjang ?></option>
                                      <?php
                                        }}
                                      ?>
                                        </select>
                                        <input type="hidden" class="form-control col-sm-4" id="nama_jenjang" readonly>
                                      </div>

                              </th>

                            <th><input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Input Keterangan"></th>
                            <th><input style="text-align:center" type="text" class="form-control" name="saldo" id="saldo" oninput="formatNumber(this); calculateTotal();" ></th>
                            </tr>

                            <tr>
                              <th>
                              <select class="form-control select2" name="kode_akun" id="kode_akun" >
                                <option value="">Pilih Akun</option>
                              <?php
                              $query = "SELECT * FROM akun WHERE status = 1";
                              $result = $konektor->query($query);
                              $num_result = $result->num_rows;
                              if ($num_result > 0) {
                                  while ($data = $result->fetch_assoc()) {
                                      $kode_akun = $data['kode_akun'];
                                      $akun = $data['nama_akun'];
                                      $saldo_normal = $data['saldo_normal'];
                              ?>
                          <option value="<?= $kode_akun ?>" data-bank="<?= $akun ?>" data-saldo-normal="<?= $saldo_normal ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                              <?php
                              }}
?>
                              </select>
                              </th>
                            <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun" id="akun" readonly>
                            <input type="hidden" class="form-control col-sm-4" id="saldo_normal" readonly>

                              <th>
                              <select class="form-control select2" name="kode_jenjang" id="kode_jenjang" required="">
                                        <option value="">Pilih Jenjang</option>
                                      <?php
                                      $query = "SELECT * FROM master_jenjang";
                                      $result = $konektor->query($query);
                                      $num_result = $result->num_rows;
                                      if ($num_result > 0) {
                                        while ($data = $result->fetch_assoc()) {
                                            $kode_jenjang = $data['kode_jenjang'];
                                            $nama_jenjang = $data['nama_jenjang'];
                                      ?>
                                        <option value="<?= $kode_jenjang ?>" data-name="<?= $nama_jenjang ?>"><?= $kode_jenjang . ' → ' . $nama_jenjang ?></option>
                                      <?php
                                        }}
                                      ?>
                                        </select>
                                        <input type="hidden" class="form-control col-sm-4" id="nama_jenjang" readonly>
                                      </div>
         
                              </th>

                            <th><input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Input Keterangan"></th>
                            <th><input style="text-align:center" type="text" class="form-control" name="saldo" id="saldo" oninput="formatNumber(this); calculateTotal();" ></th>
                            </tr>

                            <tr>
                              <th>
                              <select class="form-control select2" name="kode_akun" id="kode_akun" >
                                <option value="">Pilih Akun</option>
                              <?php
                              $query = "SELECT * FROM akun WHERE status = 1";
                              $result = $konektor->query($query);
                              $num_result = $result->num_rows;
                              if ($num_result > 0) {
                                  while ($data = $result->fetch_assoc()) {
                                      $kode_akun = $data['kode_akun'];
                                      $akun = $data['nama_akun'];
                                      $saldo_normal = $data['saldo_normal'];
                              ?>
                          <option value="<?= $kode_akun ?>" data-bank="<?= $akun ?>" data-saldo-normal="<?= $saldo_normal ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                              <?php
                              }}
?>
                              </select>
                              </th>
                            <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun" id="akun" readonly>
                            <input type="hidden" class="form-control col-sm-4" id="saldo_normal" readonly>

                              <th>
                              <select class="form-control select2" name="kode_jenjang" id="kode_jenjang" required="">
                                        <option value="">Pilih Jenjang</option>
                                      <?php
                                      $query = "SELECT * FROM master_jenjang";
                                      $result = $konektor->query($query);
                                      $num_result = $result->num_rows;
                                      if ($num_result > 0) {
                                        while ($data = $result->fetch_assoc()) {
                                            $kode_jenjang = $data['kode_jenjang'];
                                            $nama_jenjang = $data['nama_jenjang'];
                                      ?>
                                        <option value="<?= $kode_jenjang ?>" data-name="<?= $nama_jenjang ?>"><?= $kode_jenjang . ' → ' . $nama_jenjang ?></option>
                                      <?php
                                        }}
                                      ?>
                                        </select>
                                        <input type="hidden" class="form-control col-sm-4" id="nama_jenjang" readonly>
                                      </div>

                              </th>

                            <th><input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Input Keterangan"></th>
                            <th><input style="text-align:center" type="text" class="form-control" name="saldo" id="saldo" oninput="formatNumber(this); calculateTotal();" ></th>
                            </tr>

                            <tr>
                              <th>
                              <select class="form-control select2" name="kode_akun" id="kode_akun" >
                                <option value="">Pilih Akun</option>
                              <?php
                              $query = "SELECT * FROM akun WHERE status = 1";
                              $result = $konektor->query($query);
                              $num_result = $result->num_rows;
                              if ($num_result > 0) {
                                  while ($data = $result->fetch_assoc()) {
                                      $kode_akun = $data['kode_akun'];
                                      $akun = $data['nama_akun'];
                                      $saldo_normal = $data['saldo_normal'];
                              ?>
                          <option value="<?= $kode_akun ?>" data-bank="<?= $akun ?>" data-saldo-normal="<?= $saldo_normal ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                              <?php
                              }}
?>
                              </select>
                              </th>
                            <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun" id="akun" readonly>
                            <input type="hidden" class="form-control col-sm-4" id="saldo_normal" readonly>

                              <th>
                              <select class="form-control select2" name="kode_jenjang" id="kode_jenjang" required="">
                                        <option value="">Pilih Jenjang</option>
                                      <?php
                                      $query = "SELECT * FROM master_jenjang";
                                      $result = $konektor->query($query);
                                      $num_result = $result->num_rows;
                                      if ($num_result > 0) {
                                        while ($data = $result->fetch_assoc()) {
                                            $kode_jenjang = $data['kode_jenjang'];
                                            $nama_jenjang = $data['nama_jenjang'];
                                      ?>
                                        <option value="<?= $kode_jenjang ?>" data-name="<?= $nama_jenjang ?>"><?= $kode_jenjang . ' → ' . $nama_jenjang ?></option>
                                      <?php
                                        }}
                                      ?>
                                        </select>
                                        <input type="hidden" class="form-control col-sm-4" id="nama_jenjang" readonly>
                                      </div>

                              </th>

                            <th><input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Input Keterangan"></th>
                            <th><input style="text-align:center" type="text" class="form-control" name="saldo" id="saldo" oninput="formatNumber(this); calculateTotal();" ></th>
                            </tr>

                            <tr>
                              <th>
                              <select class="form-control select2" name="kode_akun" id="kode_akun" >
                                <option value="">Pilih Akun</option>
                              <?php
                              $query = "SELECT * FROM akun WHERE status = 1";
                              $result = $konektor->query($query);
                              $num_result = $result->num_rows;
                              if ($num_result > 0) {
                                  while ($data = $result->fetch_assoc()) {
                                      $kode_akun = $data['kode_akun'];
                                      $akun = $data['nama_akun'];
                                      $saldo_normal = $data['saldo_normal'];
                              ?>
                          <option value="<?= $kode_akun ?>" data-bank="<?= $akun ?>" data-saldo-normal="<?= $saldo_normal ?>"><?= $kode_akun . ' → ' . $akun ?></option>
                              <?php
                              }}
?>
                              </select>
                              </th>
                            <input style="text-align:center" type="hidden" class="form-control col-sm-4" name="akun" id="akun" readonly>
                            <input type="hidden" class="form-control col-sm-4" id="saldo_normal" readonly>
             
                              <th>
                              <select class="form-control select2" name="kode_jenjang" id="kode_jenjang" required="">
                                        <option value="">Pilih Jenjang</option>
                                      <?php
                                      $query = "SELECT * FROM master_jenjang";
                                      $result = $konektor->query($query);
                                      $num_result = $result->num_rows;
                                      if ($num_result > 0) {
                                        while ($data = $result->fetch_assoc()) {
                                            $kode_jenjang = $data['kode_jenjang'];
                                            $nama_jenjang = $data['nama_jenjang'];
                                      ?>
                                        <option value="<?= $kode_jenjang ?>" data-name="<?= $nama_jenjang ?>"><?= $kode_jenjang . ' → ' . $nama_jenjang ?></option>
                                      <?php
                                        }}
                                      ?>
                                        </select>
                                        <input type="hidden" class="form-control col-sm-4" id="nama_jenjang" readonly>
                                      </div>
                              </th>

                            <th><input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Input Keterangan"></th>
                            <th><input style="text-align:center" type="text" class="form-control" name="saldo" id="saldo" oninput="formatNumber(this); calculateTotal();" ></th>
                            </tr>

                            <div class="container-fluid">
    <div class="card shadow mb-2">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Laporan Tunggakan Kasbon</h3>
        </div>

        <div class="card shadow mb-">
            <div class="card-header py-2">
                <a href="page/jenjang/export.php" class="btn btn-success">Export ke Excel</a>
            </div>
        </div>

        <div class="card-body">
        <form action="index.php/page=tunggakan" method="GET">
                <div class="form-group row">
                    <label for="periode_start" class="col-sm-2 col-form-label">Periode Mulai</label>
                    <div class="col-sm-3">
                    <input type="date" class="form-control" name="periode_start" id="periode_start">
                    </div>
                    <label for="periode_end" class="col-sm-2 col-form-label">Periode Akhir</label>
                    <div class="col-sm-3">
                    <input type="date" class="form-control" name="periode_end" id="periode_end">
                    </div>
                    <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Jenis Transaksi</th>
                            <th>No Bukti</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Kode Akun</th>
                            <th>Debit</th>
                            <th>Kredit</th>
                            <th>Saldo</th>
                            <th>No Kasbon</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php						
                        if (isset($_GET['periode_start']) && isset($_GET['periode_end'])) {
                            $periode_start = $_GET['periode_start'];
                            $periode_end = $_GET['periode_end'];
                            $sql = $konektor->query("SELECT * FROM transaksi_bank WHERE tanggal BETWEEN '$periode_start' AND '$periode_end'");
                        } else {
                            $sql = $konektor->query("SELECT * FROM transaksi_bank");
                        }                        

                        while ($data = $sql->fetch_assoc()) {
                            $jenisTransaksi = $data['jenis_transaksi'];
                            $rowClass = ($jenisTransaksi == 'Penerimaan') ? 'table-secondary' : 'table-light';

                            if ($data['status'] == 1 && !empty($data['no_kasbon'])) {
                                ?>
                                <tr class="<?php echo $rowClass; ?>">
                                    <td><?php echo $data['jenis_transaksi'] ?></td>
                                    <td><?php echo $data['no_transaksi'] ?></td>
                                    <td><?php echo $data['tanggal'] ?></td>
                                    <td><?php echo $data['keterangan'] ?></td>
                                    <td><?php echo $data['kode_akun'] ?></td>
                                    <td>Rp. <?= number_format($data['kredit'], 0, ',', '.'); ?></td>
                                    <td>Rp. <?= number_format($data['debit'], 0, ',', '.'); ?></td>
                                    <td>Aktif</td>
                                    <td><?php echo $data['no_kasbon'] ?></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<div class="container-fluid">
    <div class="card shadow mb-2">
    </div>


    <div class="container-fluid">
	<div class="card shadow mb-2">
	<div class="card-header py-3">
		<h3 class="m-0 font-weight-bold text-primary">Laporan Laba Rugi</h3>
	</div>

	<div class="card shadow mb-">
	<div class="card-header py-2">
	</h3>	
	</div>

    <div class="card-body">
    <div class="form-group Row">
    <select name="bulan" class="form-control show-tick" required="">
        <option value="">Pilih Bulan</option>
        <option value="01" <?= (@$bln == '01') ? 'selected' : '' ?>>Januari</option>
        <option value="02" <?= (@$bln == '02') ? 'selected' : '' ?>>Februari</option>
        <option value="02" <?= (@$bln == '02') ? 'selected' : '' ?>>Februari</option>
        <option value="03" <?= (@$bln == '03') ? 'selected' : '' ?>>Maret</option>
        <option value="04" <?= (@$bln == '04') ? 'selected' : '' ?>>April</option>
        <option value="05" <?= (@$bln == '05') ? 'selected' : '' ?>>Mei</option>
        <option value="06" <?= (@$bln == '06') ? 'selected' : '' ?>>Juni</option>
        <option value="07" <?= (@$bln == '07') ? 'selected' : '' ?>>Juli</option>
        <option value="08" <?= (@$bln == '08') ? 'selected' : '' ?>>Agustus</option>
        <option value="09" <?= (@$bln == '09') ? 'selected' : '' ?>>September</option>
        <option value="10" <?= (@$bln == '10') ? 'selected' : '' ?>>Oktober</option>
        <option value="11" <?= (@$bln == '11') ? 'selected' : '' ?>>November</option>
        <option value="12" <?= (@$bln == '12') ? 'selected' : '' ?>>Desember</option>
    </select>
    <br>
    <select name="tahun" class="form-control show-tick" required="">
        <option value="">Pilih Tahun</option>
        <?php
            $currentYear = date('Y');
            for ($i = $currentYear; $i >= $currentYear - 50; $i--) {
                echo '<option value="' . $i . '" ' . (@$par2 == $i ? 'selected' : '') . '>' . $i . '</option>';
            }
        ?>
    </select>
    <br>
    <div class="col-0">
        <input type="submit" name="proses" class="btn btn-primary" style="float: left" value="Proses">
    </div>
</div>
