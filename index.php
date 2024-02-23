<?php
// https://github.com/bitcart/whmcs-plugin/blob/master/modules/gateways/bitcartcheckout.php
// https://github.com/bitcart/bitcart-fossbilling/blob/master/Bitcart/Bitcart.php

use App\Helpers\ExtensionHelper;

public function BitCart_getConfig()
    {
        return [
            [
                'name' => 'bitcart_api_endpoint',
                'friendlyName' => 'Bitcart domain name',
                'type' => 'text',
                'description' => 'Your Bitcart instance\'s Merchants API URL.',
                'required' => true,
            ],
            [
                'name' => 'bitcart_store',
                'friendlyName' => 'Bitcart store id',
                'type' => 'text',
                'description' => 'Store ID of your Bitcart Store.',
                'required' => true,
            ],
            [
                'name'=>'bitcart_admin_url',
                'friendlyName' => 'Admin URL',
                'type' => 'text',
                'description' => 'Your Bitcart instance\'s Admin Panel URL.',
                'required' => true,
            ],
        ];
    }

public function Bitcart_pay($total, $products, $orderId) 
{

}

protected function _generateForm($invoiceID)
    {
        $htmlOutput = '<button name = "bitcart-payment" class = "btn btn-success btn-sm" onclick = "showModal();return false;">Pay now</button>';
        $htmlOutput .= '<script src="' . $this->config['admin_url'] . '/modal/bitcart.js" type="text/javascript"></script>';
        $htmlOutput .= '<script type=\'text/javascript\'>';
        $htmlOutput .= 'function showModal() {';
        $htmlOutput .= 'bitcart.showInvoice(\'' . $invoiceID . '\');';
        $htmlOutput .= '}
                        </script>
                        </form>';
        return $htmlOutput;
}
