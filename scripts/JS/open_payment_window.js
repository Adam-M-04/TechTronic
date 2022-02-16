window.ReloadPage = function (){location.reload()}

function open_payment_window(id)
{
    let width = 400
    let height = 600
    let left = (screen.width - width) / 2;
    let top = (screen.height - height) / 2;
    let payment_window = window.open(
        '/TechTronic/payment/index.php?id=' + id,
        'Payment Window',
        'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, ' +
        'copyhistory=no, width=' + width + ', height=' + height + ', left=' + left + ', top=' + top);
    payment_window.moveTo(left, top);
}