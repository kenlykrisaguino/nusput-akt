<form>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Email</label>
      <input type="email" class="form-control" id="inputEmail4">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Password</label>
      <input type="password" class="form-control" id="inputPassword4">
    </div>
  </div>
  <div class="form-group">
    <label for="inputAddress">Address</label>
    <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
  </div>
  <div class="form-group">
    <label for="inputAddress2">Address 2</label>
    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">City</label>
      <input type="text" class="form-control" id="inputCity">
    </div>
    <div class="form-group col-md-4">
      <label for="inputState">State</label>
      <select id="inputState" class="form-control">
        <option selected>Choose...</option>
        <option>...</option>
      </select>
    </div>
    <div class="form-group col-md-2">
      <label for="inputZip">Zip</label>
      <input type="text" class="form-control" id="inputZip">
    </div>
  </div>
  <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
        Check me out
      </label>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Sign in</button>
</form>



<form>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="inputEmail3">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="inputPassword3">
    </div>
  </div>
  <fieldset class="form-group">
    <div class="row">
      <legend class="col-form-label col-sm-2 pt-0">Radios</legend>
      <div class="col-sm-10">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
          <label class="form-check-label" for="gridRadios1">
            First radio
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
          <label class="form-check-label" for="gridRadios2">
            Second radio
          </label>
        </div>
        <div class="form-check disabled">
          <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios3" value="option3" disabled>
          <label class="form-check-label" for="gridRadios3">
            Third disabled radio
          </label>
        </div>
      </div>
    </div>
  </fieldset>
  <div class="form-group row">
    <div class="col-sm-2">Checkbox</div>
    <div class="col-sm-10">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="gridCheck1">
        <label class="form-check-label" for="gridCheck1">
          Example checkbox
        </label>
      </div>
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-10">
      <button type="submit" class="btn btn-primary">Sign in</button>
    </div>
  </div>
</form>

<form>
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationDefault01">First name</label>
      <input type="text" class="form-control" id="validationDefault01" value="Mark" required>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationDefault02">Last name</label>
      <input type="text" class="form-control" id="validationDefault02" value="Otto" required>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationDefaultUsername">Username</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text" id="inputGroupPrepend2">@</span>
        </div>
        <input type="text" class="form-control" id="validationDefaultUsername"  aria-describedby="inputGroupPrepend2" required>
      </div>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-6 mb-3">
      <label for="validationDefault03">City</label>
      <input type="text" class="form-control" id="validationDefault03" required>
    </div>
    <div class="col-md-3 mb-3">
      <label for="validationDefault04">State</label>
      <select class="custom-select" id="validationDefault04" required>
        <option selected disabled value="">Choose...</option>
        <option>...</option>
      </select>
    </div>
    <div class="col-md-3 mb-3">
      <label for="validationDefault05">Zip</label>
      <input type="text" class="form-control" id="validationDefault05" required>
    </div>
  </div>
  <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
      <label class="form-check-label" for="invalidCheck2">
        Agree to terms and conditions
      </label>
    </div>
  </div>
  <button class="btn btn-primary" type="submit">Submit form</button>
</form>

<!-- Versi 1: Tab Menu -->
<ul class="nav nav-tabs" id="dashboardTab" role="tablist">
    <li class="nav-item"><a class="nav-link active" id="master-tab" data-toggle="tab" href="#master" role="tab">Data Master</a></li>
    <li class="nav-item"><a class="nav-link" id="transaksi-tab" data-toggle="tab" href="#transaksi" role="tab">Transaksi</a></li>
    <li class="nav-item"><a class="nav-link" id="laporan-tab" data-toggle="tab" href="#laporan" role="tab">Laporan Keuangan</a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane fade show active" id="master" role="tabpanel">
        <div class="row">
            <!-- Isi Data Master -->
        </div>
    </div>
    <div class="tab-pane fade" id="transaksi" role="tabpanel">
        <div class="row">
            <!-- Isi Transaksi -->
        </div>
    </div>
    <div class="tab-pane fade" id="laporan" role="tabpanel">
        <div class="row">
            <!-- Isi Laporan Keuangan -->
        </div>
    </div>
</div>

<!-- Versi 2: Accordion -->
<div class="accordion" id="dashboardAccordion">
    <div class="card">
        <div class="card-header" id="headingMaster">
            <h2 class="mb-0"><button class="btn btn-link" data-toggle="collapse" data-target="#collapseMaster">Data Master</button></h2>
        </div>
        <div id="collapseMaster" class="collapse show" data-parent="#dashboardAccordion">
            <div class="card-body"> <!-- Isi Data Master --> </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingTransaksi">
            <h2 class="mb-0"><button class="btn btn-link" data-toggle="collapse" data-target="#collapseTransaksi">Transaksi</button></h2>
        </div>
        <div id="collapseTransaksi" class="collapse" data-parent="#dashboardAccordion">
            <div class="card-body"> <!-- Isi Transaksi --> </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingLaporan">
            <h2 class="mb-0"><button class="btn btn-link" data-toggle="collapse" data-target="#collapseLaporan">Laporan Keuangan</button></h2>
        </div>
        <div id="collapseLaporan" class="collapse" data-parent="#dashboardAccordion">
            <div class="card-body"> <!-- Isi Laporan Keuangan --> </div>
        </div>
    </div>
</div>

<!-- Versi 3: Judul Pemisah -->
<h3>Data Master</h3>
<div class="row"> <!-- Isi Data Master --> </div>
<h3>Transaksi</h3>
<div class="row"> <!-- Isi Transaksi --> </div>
<h3>Laporan Keuangan</h3>
<div class="row"> <!-- Isi Laporan Keuangan --> </div>


<div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card shadow-sm border-left-primary p-3">
                    <a href="?page=jenjang" class="text-decoration-none text-dark">
                        <div class="card-body text-center">
                            <i class="fas fa-folder card-icon text-primary"></i>
                            <h5 class="mt-3">Data Master Jenjang</h5>
                        </div>
                    </a>
                </div>
            </div>