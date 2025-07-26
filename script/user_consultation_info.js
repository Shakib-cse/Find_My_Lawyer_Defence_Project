var receivedData = new URLSearchParams(window.location.search).get('data');

        let hidden_lawyer_email = document.getElementById('hidden_lawyer_email');
        hidden_lawyer_email.value = receivedData;

        //loader
        document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            document.getElementById('preloader').style.display = 'flex';
        });
    });

    window.addEventListener('load', function () {
        document.getElementById('preloader').style.display = 'none';
    });
});




