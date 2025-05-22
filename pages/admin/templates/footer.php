    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    <footer class="footer">
        <!-- <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021. Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
        </div>
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Distributed by <a href="https://www.themewagon.com/" target="_blank">Themewagon</a></span>
        </div> -->
    </footer>
    <!-- partial -->
    </div>
    <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../assets/vendors/chart.js/Chart.min.js"></script>
    <script src="vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <script src="js/dataTables.select.min.js"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/hoverable-collapse.js"></script>
    <script src="../assets/js/template.js"></script>
    <script src="../assets/js/settings.js"></script>
    <script src="../assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="../assets/js/file-upload.js"></script>
    <script src="../assets/js/typeahead.js"></script>
    <script src="../assets/js/select2"></script>
    <script src="../assets/js/dashboard.js"></script>
    <script src="../assets/js/Chart.roundedBarCharts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const activateButtons = document.querySelectorAll('.activate-btn');

        activateButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault(); // hindari default action

            const userId = this.getAttribute('data-id');

            Swal.fire({
            title: 'Yakin ingin aktivasi akun ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, aktivasi!',
            cancelButtonText: 'Batal'
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `aktivasi_akun.php?activate=${userId}`;
            }
            });
        });
        });
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const activateButtons = document.querySelectorAll('.deactivate-btn');

        activateButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault(); // hindari default action

            const userId = this.getAttribute('data-id');

            Swal.fire({
            title: 'Yakin ingin menonaktifkan akun ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Nonaktifkan!',
            cancelButtonText: 'Batal'
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `nonaktifkan_akun.php?activate=${userId}`;
            }
            });
        });
        });
    });
    </script>
    <!-- End custom js for this page-->

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-user-btn');

        deleteButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const userId = this.getAttribute('data-id');

            Swal.fire({
            title: 'Yakin ingin menghapus pengguna ini?',
            text: "Tindakan ini tidak dapat dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `list_akun.php?delete=${userId}`;
            }
            });
        });
        });
    });
    </script>
    <!-- End custom js for this page-->
    </body>

    </html>