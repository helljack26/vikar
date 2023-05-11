<?
include('../includes/links.php');

require("../pay/LiqPay.php");

	$liqpay = new LiqPay($public_key, $private_key);
	$data = array();
	$data['form'] = $liqpay->cnb_form(array(
		'version'       => '3',
		'amount'        => $total_price,
		'currency'      => 'UAH',
		'description'   => 'Сплата за товар на суму - ' . $total_price,
		'order_id'      => $newOrderId,
		'language'		=> 'ua',
		'type'			=> 'donate',
		'result_url'	=> 'https://vikar.center/thanks.php',
		'server_url'	=> 'https://vikar.center/my-cart.php',
		'action' 		=> 'pay',
	));
    #liq pay status  
	$liqpay2 = new LiqPay($public_key, $private_key);
    $res = $liqpay2->api("request", array(
        'action'        => 'status',
        'version'       => '3',
        'order_id'      => $newOrderId
        ));
    #end liq pay
	$pay_status = $res->result;
    if ($pay_status == 'error') {
		$pay_result = $data['form'];
        echo($pay_result);
    ?>
<style>
	form {
		display: none !important;
	}
</style>

<script type="text/javascript">
	$('form').submit();
</script>
<? } ?>