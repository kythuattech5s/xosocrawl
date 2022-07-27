<?php
namespace vanhenry\manager\statisticals;

use App\Models\WalletTransactionType;
use App\Models\WithdrawalRequest;
use App\Models\WithdrawalRequestStatus;

class UserStatical
{
    public static function getUserTotalCollect($user)
    {
        $userWallet = $user->getWallet();
        return $userWallet->walletHistory()->includedTheCost()->where('type',WalletTransactionType::RECHARGE_MONEY)->sum('amount');
    }
    public static function getUserTotalSpend($user)
    {
        return WithdrawalRequest::where('withdrawal_request_status_id',WithdrawalRequestStatus::STATUS_CONFIRMED)
                                    ->includedTheCost()
                                    ->sum('amount_final');
    }
}
