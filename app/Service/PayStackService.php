<?php
namespace App\Service;

use Illuminate\Support\Facades\Http;

class PayStackService{
    public $payStackSecretKey;
    public $payStackBaseUrl;
     
    public function __construct(){
        $this->payStackSecretKey = env('PAYSTACK_SECRET_KEY');
        $this->payStackBaseUrl = env('PAYSTACK_BASE_URL');
    }

    private function withAuthorization()
    {
        // $response =  Http::withHeaders([
        //     'Authorization' => "Bearer {$this->payStackSecretKey}"
        // ]);
        // return $response;
        return Http::withToken($this->payStackSecretKey);
    }

    private function withOutAuthorization()
    {
        // return Http::get([
        //     'Authorization' => 'Bearer '. $this->payStackSecretKey
        // ]);
        return Http::withToken($this->payStackSecretKey);
    }

    public function verifyReference($reference)
    {
        $response =  $this->withAuthorization()->get($this->payStackBaseUrl.'/transaction/verify/'.$reference);

        $arrayResponse = $response->json();
        if(array_key_exists('data', $arrayResponse)){

            if($arrayResponse['data']['status'] == true){
                return true;
            }
        }
        return false;
    }


}