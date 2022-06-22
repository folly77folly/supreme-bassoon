<?php
namespace App\Service;

use App\Models\User;
use App\Models\Coupon;
use App\Models\CouponUsed;
use App\Exceptions\ApiResponseException;
 
class CouponService{

    public function __construct(protected string $couponCode)
    {
          $this->couponCode = $couponCode;
    }

    public function getDiscountAmount(object $user, $amount=null):float
    {
       $coupon =  Coupon::active()->where('coupon_code', $this->couponCode)->first();
       
       if(!$coupon){
        return 0;
       }
       
       //check Validity date of coupon
       if(!$this->checkCouponValidity($coupon)){
        throw new ApiResponseException("This Coupon is only valid between {$coupon->start_date} and {$coupon->end_date}");
    };
       //check if coupon has email
       if(!$this->emailToUseCoupon($coupon, $user)){
            throw new ApiResponseException('Your email address is not assigned to this coupon');
       };

       //check if the coupon usage is exhausted
       if (($coupon->coupon_use_count) > $coupon->usage_limit){
            throw new ApiResponseException('The Limit for this coupon is reached');
       };

       $couponAmount = match($coupon->coupon_type_id ){
            1 => $coupon->min_amount,
            2 => ($coupon->min_amount/100) * $amount,
            default => 0,
       };

       return round($couponAmount, 2);
       
    }

    public function emailToUseCoupon(Coupon $coupon, User $user)
    {
        // dd($coupon);
        if(count($coupon->emails_to_enjoy) == 0 ){
            return false;
        };

        if(in_array(needle: $user->email, haystack: $coupon->emails_to_enjoy)){
            return true;
        }
        return false;

    }

    public function checkCouponValidity(Coupon $coupon)
    {
        if($coupon->start_date > now() ){
            return false;
        };

        if(now() > $coupon->end_date ){
            return false;
        };
        return true;

    }
    public function checkCouponStatus(Coupon $coupon)
    {
        if(!$coupon->active  ){
            return false;
        };
        return true;

    }

    public function recordUsedCoupon(User $user, $amount){
        $coupon =  Coupon::active()->where('coupon_code', $this->couponCode)->first();
        $data = [
            'user_id' => $user->id,
            'coupon_id' => $coupon->id,
            'coupon_code' => $coupon->coupon_code,
            'amount' => $amount,
            
        ];
        CouponUsed::create($data);
    }
}
