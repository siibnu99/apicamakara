<?php

namespace App\Libraries;

/**
 * UUID Class
 *
 * This implements the abilities to create UUID's for CodeIgniter.
 * Code has been borrowed from the followinf comments on php.net
 * and has been optimized for CodeIgniter use.
 * http://www.php.net/manual/en/function.uniqid.php#94959
 *
 * @category Libraries
 * @author Dan Storm
 * @link http://catalystcode.net/
 * @license GNU LPGL
 * @version 2.1 
 */

use \Firebase\JWT\JWT;

class Tokenjwt
{

    public function privateKey()
    {
        $privateKey = <<<EOD
            -----BEGIN RSA PRIVATE KEY-----
            MIICXAIBAAKBgQC8kGa1pSjbSYZVebtTRBLxBz5H4i2p/llLCrEeQhta5kaQu/Rn
            vuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t0tyazyZ8JXw+KgXTxldMPEL9
            5+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4ehde/zUxo6UvS7UrBQIDAQAB
            AoGAb/MXV46XxCFRxNuB8LyAtmLDgi/xRnTAlMHjSACddwkyKem8//8eZtw9fzxz
            bWZ/1/doQOuHBGYZU8aDzzj59FZ78dyzNFoF91hbvZKkg+6wGyd/LrGVEB+Xre0J
            Nil0GReM2AHDNZUYRv+HYJPIOrB0CRczLQsgFJ8K6aAD6F0CQQDzbpjYdx10qgK1
            cP59UHiHjPZYC0loEsk7s+hUmT3QHerAQJMZWC11Qrn2N+ybwwNblDKv+s5qgMQ5
            5tNoQ9IfAkEAxkyffU6ythpg/H0Ixe1I2rd0GbF05biIzO/i77Det3n4YsJVlDck
            ZkcvY3SK2iRIL4c9yY6hlIhs+K9wXTtGWwJBAO9Dskl48mO7woPR9uD22jDpNSwe
            k90OMepTjzSvlhjbfuPN1IdhqvSJTDychRwn1kIJ7LQZgQ8fVz9OCFZ/6qMCQGOb
            qaGwHmUK6xzpUbbacnYrIM6nLSkXgOAwv7XXCojvY614ILTK3iXiLBOxPu5Eu13k
            eUz9sHyD6vkgZzjtxXECQAkp4Xerf5TGfQXGXhxIX52yH+N2LtujCdkQZjXAsGdm
            B2zNzvrlgRmgBrklMTrMYgm1NPcW+bRLGcwgW2PTvNM=
            -----END RSA PRIVATE KEY-----
            EOD;
        return $privateKey;
    }
    public function getToken($data)
    {
        $secret_key = $this->privateKey();
        $issuer_claim = "Kediri_Cerdas"; // this can be the servername. Example: https://domain.com
        $audience_claim = "Kediri_Cerdas";
        $issuedat_claim = time(); // issued at
        $notbefore_claim = $issuedat_claim; //not before in seconds
        $expire_claim = $issuedat_claim + (10 * 60 * 60); // expire time in seconds
        $token = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "nbf" => $notbefore_claim,
            "exp" => $expire_claim,
            "data" => $data
        );
        $token = JWT::encode($token, $secret_key);
        return $token;
    }
    public function checkToken($authHeader)
    {

        if ($authHeader == null) {
            $output = [
                'message' => 'Access denied',
                'status' => 401
            ];
            return $output;
        }

        $secret_key = $this->privateKey();

        $token = null;

        $arr = explode(" ", $authHeader);

        $token = $arr[1];

        if ($token) {

            try {

                $decoded = JWT::decode($token, $secret_key, array('HS256'));

                // Access is granted. Add code of the operation here 
                if ($decoded) {
                    // response true
                    $output = [
                        'message' => 'Access granted',
                        'data' => $decoded,
                        'status' => 200
                    ];
                    return $output;
                }
            } catch (\Exception $e) {

                $output = [
                    'message' => 'Access denied',
                    "error" => $e->getMessage(),
                    'status' => 401
                ];
                return $output;
            }
        }
    }
}
