<?php
    /* 
        Author: TJ Navarro-barber
        File Name: Encryption.php
        Function: encrypts and decrypts data
    */
    class data{
        private $secretKey = "791FSRBvfWU8IY2VFeoo76AdQjLvoUNVZBkeYXhE3ZbA6TKPHAkM6cf9wl1QpNzMM0yJWsslXnGvhmJ49qHLpDmvgOFq6bwDC8SXjBedQID9n0rqlfzojID1LEIWBZx8";
        private $cipher = "aes-128-cbc";
        
        public function encrypt($input)
        {
            $key = $this->secretKey;
            $plaintext = $input;
            $ivlen = openssl_cipher_iv_length($cipher = $this->cipher);
            $iv = openssl_random_pseudo_bytes($ivlen);
            $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
            $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
            $ciphertext = base64_encode($iv . $hmac . $ciphertext_raw);
            return $ciphertext;
        }
        public function decrypt($input)
        {
            $key = $this->secretKey;
            $c = base64_decode($input);
            $ivlen = openssl_cipher_iv_length($cipher = $this->cipher);
            $iv = substr($c, 0, $ivlen);
            $hmac = substr($c, $ivlen, $sha2len = 32);
            $ciphertext_raw = substr($c, $ivlen + $sha2len);
            $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
            $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
            if (hash_equals($hmac, $calcmac))
            {
                return $original_plaintext;
            }
            $ivlen = openssl_cipher_iv_length($this->cipher);
            $iv = openssl_random_pseudo_bytes($ivlen);
            return openssl_decrypt($input, $this->cipher, $this->secretKey, 0, $iv);
        }
    }
    
    function generateID($length = 16) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
