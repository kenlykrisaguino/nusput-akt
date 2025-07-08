<div class="container-fluid">
    <div class="card shadow mb-2">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Cetak Bukti Pembalik Kasbon</h3>
                </div>
                <div class="row">
                <div class="col-md-12">
                <div class="card card-primary">
                  </div>   
                <form action="?page=transaksi_kasbon&aksi=export" method="POST">
                <div class="card-body">
                <label for=""><b>No Transaksi</b></label>
                  <div class="form-group">
                  <div class="form-line">
                    <input type="number" name="no_transaksi" id="no_transaksi" class="form-control" required=""/>	 
                  </div>
                  </div>

                  <div class="form-group" style="display: none;">
                      <div class="form-line">
                          <select name="jenis_transaksi" id="jenis_transaksi" class="form-control" required>
                              <option value="Penerimaan">Penerimaan</option>
                              <option value="Pengeluaran">Pengeluaran</option>
                          </select>
                      </div>
                  </div>

                    <div class="col-sm-1">
                        <button type="submit" class="btn btn-primary">Cetak</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

