jQuery(document).ready(function ($) {
    // Test Connection Button Handler
    $('#inp-test-connection').on('click', function () {
        const statusElement = $('#inp-connection-status');
        const testButton = $('#inp-test-connection');
        let accessToken = $('#access_token').val();
        let accountID = $('#account_id').val();

                jQuery.ajax({
                    url:inp_ajax.ajaxurl , //ajax url
                    type: 'post',
                    dataType: 'json',
                    data: {
                        action: 'inp_instagram_test_connection',
                        accessToken:accessToken,
                        accountID:accountID,
                        _nonce: inp_ajax._nonce,
                    },
                    beforeSend: function () {
                        statusElement.html('در حال تست اتصال...');
                        testButton.prop('disabled', true);
                    },
                    success: function (response) {
                        if (response.success) {
                            // Actions to handle successful response --- to get success message use this template: response.message
                            statusElement.html(response.message);
                            statusElement.css('color', 'green');
                        }
                    },
                    error: function (error) {
                        if (error.error) {
                            // Error handling based on specific error conditions--- to get error message use this template: error.responseJSON.message
                            statusElement.html(error.responseJSON.message);
                            statusElement.css('color', 'red');
                        }
                    },
                    complete: function () {
                        // Actions to perform after the AJAX request completes (regardless of success or failure)
                        testButton.prop('disabled', false);
                    },
                });

    });

});