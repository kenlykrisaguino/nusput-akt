<div class="container-fluid">
    <div class="card shadow mb-2">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Transaksi Pembalik</h3>
        </div>

        <div class="card-body">
        <form action="export_kasbon.php" method="POST">
                <div class="form-group row">
                <label for="akun_kas" class="col-sm-2"><b>Kode Akun</b></label>
    <select name="akun_kas" id="akun_kas" class="form-control col-sm-3">
        <!-- Option 1 -->
        <option value="kode_1">Kode Akun 1</option>
        <!-- Option 2 -->
        <option value="kode_2">Kode Akun 2</option>
        <!-- Add more options as needed -->
    </select>
                    <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>


    <div class="row">
        <!-- First Form -->
        <div class="col-md-6">
            <div class="form-group">
                <form action="process_form1.php" method="POST">
                    <!-- Form fields for the first form -->
                    <div class="form-group">
                        <!-- Example input field -->
                        <label for="field1">Field 1</label>
                        <input type="text" name="field1" class="form-control" required>
                    </div>
                    <!-- Add more form fields as needed -->
                </form>
            </div>
        </div>

        <!-- Second Form -->
        <div class="col-md-6">
            <div class="form-group">
                <form action="process_form2.php" method="POST">
                    <!-- Form fields for the second form -->
                    <div class="form-group">
                        <!-- Example input field -->
                        <label for="field2">Field 2</label>
                        <input type="text" name="field2" class="form-control" required>
                    </div>
                    <!-- Add more form fields as needed -->
                </form>
            </div>
        </div>
</div>

            </form>
