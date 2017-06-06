<script>
    $(document).ready(function () {
        axios.get('/ajax/login_status')
            .then(function (response) {
                $('#login_status').css('display', 'block');
                $('#no_login_status').css('display', 'none');
            })
            .catch(function (error) {
                $('#login_status').css('display', 'none');
                $('#no_login_status').css('display', 'block');
            });
    });
</script>