<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Lead;
use Illuminate\Http\Request;

class ahmedController extends Controller
{
    // Postback link
    // https://collect2win.com/api/ahmed?subId=[USER_ID]&transId=[TRANSACTION_ID]&offer_name=[OFFER_NAME]&offer_type=[OFFER_TYPE]&reward=[REWARD]&reward_name=[REWARD_NAME]&reward_value=[REWARD_VALUE]&payout=[PAYOUT]&userIp=[USER_IP]&country=[COUNTRY]&status=[STATUS]&debug=[DEBUG]&signature=[SIGNATURE]

    public function callback(Request $request)
    {
        try {
            $data = $request->all();
            $this->validatePostback($data);

            // Process the postback data
            $this->increaseUserPoints($data);
            $this->saveLead($data);

        } catch (\Exception $e) {
            return response('NOT OK - Postback Failed', 400);
        }

        return response('OK - Postback Success', 200);
    }

    private function validatePostback($data)
    {
        $secret = "a407d242b237cc40caa8d044861faa5a"; // Replace with your actual secret key from Gainster Mobile Monetization

        // Check if required parameters are present
        $requiredParameters = ['subId', 'transId', 'offer_name', 'offer_type', 'reward', 'reward_name', 'reward_value', 'payout'];
        foreach ($requiredParameters as $param) {
            if (!isset($data[$param])) {
                throw new \Exception("$param is missing");
            }
        }

        // Validate Signature
        if (!isset($data['signature'])) {
            throw new \Exception('Signature is missing');
        }

        // Validate Status
        if (!isset($data['status'])) {
            throw new \Exception('Status is missing');
        }

        // Validate IP
        $clientIp = isset($data['userIp']) ? $data['userIp'] : null;

        // Check if the client IP is not empty
        if (empty($clientIp)) {

            throw new \Exception('Invalid or missing client IP');
        }



        $receivedSignature = $data['signature'];
        $expectedSignature = md5($data['subId'] . $data['transId'] . $data['reward'] . $secret);

        if ($receivedSignature !== $expectedSignature) {

            throw new \Exception('Signature validation failed');
        }

        return $data;
    }

    private function increaseUserPoints($data)
    {
        $user = User::where('id', $data['subId'])->first(); // Change 'user_id' to 'id'

        if (!$user) {
            throw new \Exception('User not found');
        }

        // Add or subtract the reward based on the status
        if ($data['status'] == 2) {
            //  2 = Chargeback, subtract reward from the user
            $reward = -abs($data['reward']);
        } else {
            //  1 = Valid, add reward to the user
            $reward = abs($data['reward']);
        }

        // Update user points
        $user->update([
            'current_points' => $user->current_points + $reward,
            'today_points' => $user->today_points + $reward,
            'total_points' => $user->total_points + $reward,
        ]);
    }


    private function saveLead($data)
    {

        if ($data['status'] == 2) {
            //  2 = Chargeback, subtract reward from the user
            $reward = -abs($data['reward']);
            $payout = -abs($data['payout']);
        } else {
            //  1 = Valid, add reward to the user
            $reward = abs($data['reward']);
            $payout = abs($data['payout']);
        }

        Lead::create([
            'user_id' => $data['subId'],
            'company' => "AdGate Reach",
            'offer_id' => $data['transId'],
            'offer_name' => $data['offer_name'],
            'offer_points' => $reward,
            'offer_payout' => $payout,
            'ip' => $data['userIp'], // Add the user's IP to the 'ip' column
        ]);
    }

}
