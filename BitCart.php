<?php
// https://github.com/bitcart/whmcs-plugin/blob/master/modules/gateways/bitcartcheckout.php
// https://github.com/bitcart/bitcart-fossbilling/blob/master/Bitcart/Bitcart.php

namespace App\Extensions\Gateways\BitCart;

use App\Classes\Extensions\Gateway;
use App\Helpers\ExtensionHelper;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class BitCart extends Gateway
{
    /**
    * Get the extension metadata
    *
    * @return array
    */
    public function getMetadata()
    {
        return [
            'display_name' => 'BitCart',
            'version' => '0.0.1',
            'author' => '0ut0f.space',
            'website' => 'https://0ut0f.space',
        ];
    }

    /**
     * Get all the configuration for the extension
     *
     * @return array
     */
    public function getConfig()
    {
        return [
          [
            'name' => 'api_endpoint',
            'friendlyName' => 'BitCart API endpoint',
            'type' => 'text',
            'required' => true,
           ],
           [
                'name' => 'store_id',
                'friendlyName' => 'BitCart store id',
                'type' => 'text',
                'required' => true,
           ],
           [
                'name'=>'admin_url',
                'friendlyName' => 'BitCart admin URL',
                'type' => 'text',
                'required' => true,
           ],
        ];
    }

    /**
     * Get the URL to redirect to
     *
     * @param int $total
     * @param array $products
     * @param int $invoiceId
     */
    public function pay($total, $products, $invoiceId)
    {
        $payment_url = $this->get_payment_url($invoiceId,$total);
        return $payment_url;
    }

    public function get_payment_url ($invoiceId, $amount) {
        $api_domain = ExtensionHelper::getConfig('Bitcart', 'api_endpoint');
        $admin_domain = ExtensionHelper::getConfig('Bitcart','admin_url');
        $params = array(
            'price' => number_format($amount, 2, '.', ''),
            'store_id' => ExtensionHelper::getConfig('Bitcart','store_id'),
            'currency' => ExtensionHelper::getCurrency(),
            'buyer_email' => auth()->user()->email,
            'redirect_url' => route('clients.invoice.show', $invoiceId),
            'notification_url' => url('/extensions/bitcart/webhook'),
            'order_id' => $invoiceId,
        );
        $invoice = $this->send_request(sprintf('%s/%s', $api_domain, 'invoices/order_id/' . urlencode($invoiceId)), $params);
        return $admin_domain . '/i/' . $invoice->id;
    }

    public function send_request($url, $data, $post = 1)
    {
        $post_fields = json_encode($data);

        $request_headers = array();
        $request_headers[] = 'Content-Type: application/json';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, $post);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        curl_close($ch);

        return json_decode($result);
    }

     public function webhook(Request $request)
     {
         $body = $request->getContent();
         $data = json_decode($body, true);
         $invoiceId = $data['id'];
         $status = $data['status'];
         if ($status == 'complete') {
            ExtensionHelper::paymentDone($invoiceId,'BitCart',null);
         }
     }
}
