        </div>
        <!-- End Content Wrapper -->
    </main>
    <!-- End Main Content -->

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
        });

        // Highlight current nav link
        document.querySelectorAll('.sidebar-nav .nav-link').forEach(function(link) {
            if (link.href === window.location.href || link.href === window.location.origin + window.location.pathname) {
                link.classList.add('active');
            }
        });
    </script>
</body>
</html>
