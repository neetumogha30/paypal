<?php
require 'config.php';
require 'class/paypalExpress.php';
?>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>

<div id="paypal-button"></div>
<script>

      paypal.Button.render({
            
            env: 'sandbox',
           
            // PayPal Client IDs - replace with your own
            // Create a PayPal app: https://developer.paypal.com/developer/applications/create
            client: {
                sandbox:    '<?php echo PayPal_CLIENT_ID; ?>',                
            },
            // Show the buyer a 'Pay Now' button in the checkout flow
            commit: true,
            // payment() is called when the button is clicked
            payment: function(data, actions) {
                
                // Make a call to the REST api to create the payment
                return actions.payment.create({
                    payment: {
                        transactions: [
                            {
                                amount: { total: '1', currency: 'INR' },
                                item_list:{shipping_address:{recipient_name:'neetu mogha',country_code:'IN'}}
                                
                            }
                        ]
                    }
                });
            },
            // onAuthorize() is called when the buyer approves the payment
            onAuthorize: function(data, actions) {
                // Make a call to the REST api to execute the payment
                return actions.payment.execute().then(function() {
                    console.log('Payment Complete!');
                    console.log(data);
                    window.location = "process.php?paymentID="+data.paymentID+"&payerID="+data.payerID+"&token="+data.paymentToken+"&pid=1234";
                });
            }
        }, '#paypal-button');
    </script>