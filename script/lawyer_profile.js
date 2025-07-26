let fee_amount = document.getElementById('fee_amount').innerHTML;
        let fee_text = document.getElementById('fee_text');

        if (fee_amount > 0) {
                fee_text.textContent = 'Pay for Consulatation';
                var dataToTransfer = fee_text.getAttribute('data-transfer');
                var additionalData = fee_text.getAttribute('data-additional');

                fee_text.href = './user_consultation_info_bkash.php?data=' + encodeURIComponent(dataToTransfer) + '&additionalData=' + encodeURIComponent(additionalData);

            }else{
                fee_text.textContent = 'Free for Consultation';
                var dataToTransfer = fee_text.getAttribute('data-transfer');
                fee_text.href = './user_consultation_info.php?data=' + encodeURIComponent(dataToTransfer);
            }

            //loader
            document.addEventListener('DOMContentLoaded', function () {
    // Show the preloader when a link is clicked
    document.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            document.getElementById('preloader').style.display = 'flex';
        });
    });

    // Hide the preloader when the new page is fully loaded
    window.addEventListener('load', function () {
        document.getElementById('preloader').style.display = 'none';
    });
});