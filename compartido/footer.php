<script src="assets/vendors/js/vendor.bundle.base.js"></script>
<script src="assets/vendors/select2/select2.min.js"></script>
<script src="assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
<script src="assets/vendors/chart.js/Chart.min.js"></script>
<script src="assets/vendors/moment/moment.min.js"></script>
<script src="assets/vendors/daterangepicker/daterangepicker.js"></script>
<script src="assets/vendors/chartist/chartist.min.js"></script>

<script src="assets/js/off-canvas.js"></script>

<script src="assets/js/typeahead.js"></script>
<script src="assets/js/select2.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
    function onReady(callback) {
        var intervalID = window.setInterval(checkReady, 1000);

        function checkReady() {
            if (document.getElementsByTagName('body')[0] !== undefined) {
                window.clearInterval(intervalID);
                callback.call(this);
            }
        }
    }

    function show(id, value) {
        document.getElementById(id).style.display = value ? 'block' : 'none';
    }

    onReady(function () {
        show('page', true);
        show('loading', false);
    });


    (function () {
        var footer = document.createElement('div');
        footer.style.color = 'rgb(255, 255, 255)';
        footer.style.float = 'left';
        footer.style.position = 'fixed';
        footer.style.bottom = '0px';
        footer.style.left = '0px';
        footer.style.right = '0px';
        footer.style.padding = '10px';
        footer.style.background = 'rgb(0, 0, 0)';
        footer.style.textAlign = 'center';
        footer.style.zIndex = '1000';
        footer.innerHTML = '<div><span id="untels">UNTELS</span> | SISTEMA DE GESTION DE ESTUDIANTES</div>';
        document.body.appendChild(footer);

        var untels = document.getElementById('untels');
        untels.style.transition = 'color 2s';
        untels.style.color = 'rgb(255, 0, 0)';
    })();

</script>

</body>

</html>