<?php

namespace App\Controllers;

use App\Models\ProdiModel;
use Exception;
use Pusher\Pusher;

class Test extends BaseController
{
    public function index()
    {
        d(FCPATH);
        return view('test/index');
    }
    public function test()
    {

        $transaction_details = array(
            'order_id'    => time(),
            'gross_amount'  => 200000
        );

        // Populate items
        $items = array(
            array(
                'id'       => 'item1',
                'price'    => 100000,
                'quantity' => 1,
                'name'     => 'Adidas f50'
            ),
            array(
                'id'       => 'item2',
                'price'    => 50000,
                'quantity' => 2,
                'name'     => 'Nike N90'
            )
        );

        // Populate customer's billing address
        $billing_address = array(
            'first_name'   => "Andri",
            'last_name'    => "Setiawan",
            'address'      => "Karet Belakang 15A, Setiabudi.",
            'city'         => "Jakarta",
            'postal_code'  => "51161",
            'phone'        => "081322311801",
            'country_code' => 'IDN'
        );

        // Populate customer's shipping address
        $shipping_address = array(
            'first_name'   => "John",
            'last_name'    => "Watson",
            'address'      => "Bakerstreet 221B.",
            'city'         => "Jakarta",
            'postal_code'  => "51162",
            'phone'        => "081322311801",
            'country_code' => 'IDN'
        );

        // Populate customer's info
        $customer_details = array(
            'first_name'       => "Andri",
            'last_name'        => "Setiawan",
            'email'            => "andri@setiawan.com",
            'phone'            => "081322311801",
            'billing_address'  => $billing_address,
            'shipping_address' => $shipping_address
        );

        // Token ID from checkout page
        $token_id = 'asdlpsaldplaspdlpsadlp';

        // Transaction data to be sent
        $transaction_data = array(
            'payment_type' => 'gopay',
            'credit_card'  => array(
                'token_id'      => $token_id,
                // 'bank'          => 'bni', // optional acquiring bank, must be the same bank with get-token bank
                'save_token_id' => isset($_POST['save_cc'])
            ),
            'transaction_details' => $transaction_details,
            'item_details'        => $items,
            'customer_details'    => $customer_details
        );

        try {
            $response =  \Midtrans\CoreApi::charge($transaction_data);
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }

        // Success
        if ($response->transaction_status == 'capture') {
            echo "<p>Transaksi berhasil.</p>";
            echo "<p>Status transaksi untuk order id $response->order_id: " .
                "$response->transaction_status</p>";

            echo "<h3>Detail transaksi:</h3>";
            echo "<pre>";
            var_dump($response);
            echo "</pre>";
        }
        // Deny
        else if ($response->transaction_status == 'deny') {
            echo "<p>Transaksi ditolak.</p>";
            echo "<p>Status transaksi untuk order id .$response->order_id: " .
                "$response->transaction_status</p>";
            echo "<h3>Detail transaksi:</h3>";
            echo "<pre>";
            var_dump($response);
            echo "</pre>";
        }
        // Challenge
        else if ($response->transaction_status == 'challenge') {
            echo "<p>Transaksi challenge.</p>";
            echo "<p>Status transaksi untuk order id $response->order_id: " .
                "$response->transaction_status</p>";

            echo "<h3>Detail transaksi:</h3>";
            echo "<pre>";
            var_dump($response);
            echo "</pre>";
        }
        // Error
        else {
            echo "<p>Terjadi kesalahan pada data transaksi yang dikirim.</p>";
            echo "<p>Status message: [$response->status_code] " .
                "$response->status_message</p>";

            echo "<pre>";
            var_dump($response);
            echo "</pre>";
        }

        echo "<hr>";
        echo "<h3>Request</h3>";
        echo "<pre>";
        var_dump($response);
        echo "</pre>";
    }
}
