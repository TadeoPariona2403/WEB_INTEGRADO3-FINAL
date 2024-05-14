<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://www.paypal.com/sdk/js?client-id=AZcWlp_ybBU9TIAPQRw1wUiDxZt5OMrGbBpUiqcz619eD6Ky-pwKfKqsIEUuhPuI38Lq5xRiNSE0RMIX
    &currency=USD" data-sdk-integration-source="button-factory"></script>
</head>
<body>
<div id="smart-button-container">
    <div style="text-align: center;">
        <div id="paypal-button-container"></div>
    </div>
</div>

<script>
    function initPayPalButton() {
        paypal.Buttons({
            style: {
                shape: 'rect',
                color: 'gold',
                layout: 'vertical',
                label: 'pay',
            },

            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{"description":"LA DESCRIPCION DE TU PRODUCTO","amount":{"currency_code":"USD","value":13}}]
                });
            },

            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {
                    // Full available details
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                    window.location.href = 'LA URL DE TU PAGINA DE GRACIAS';
                });
            },

            onError: function(err) {
                console.log(err);
            }
        }).render('#paypal-button-container');
    }
    initPayPalButton();
</script>

</body>
</html>


