<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function getPoints(Request $request)
    {
        $user = $request->user();
        return response()->json(['points' => $user->points ?? 0]);
    }

    public function getRewards()
    {
        // Örnek sabit veriler, veritabanı tablosu ile değiştirilebilir
        $rewards = [
            ['id' => 1, 'title' => 'Ücretsiz Kahve', 'points' => 100],
            ['id' => 2, 'title' => 'Tatlı İkramı', 'points' => 200],
        ];

        return response()->json(['rewards' => $rewards]);
    }

    public function redeemReward(Request $request)
    {
        $request->validate([
            'reward_id' => 'required|integer',
        ]);

        $user = $request->user();
        $rewardId = $request->reward_id;

        // Örnek: rewardlar sabit, ileride DB'den çekilebilir
        $rewards = collect([
            ['id' => 1, 'points' => 100],
            ['id' => 2, 'points' => 200],
        ]);

        $reward = $rewards->firstWhere('id', $rewardId);

        if (!$reward) {
            return response()->json(['message' => 'Ödül bulunamadı.'], 404);
        }

        if (($user->points ?? 0) < $reward['points']) {
            return response()->json(['message' => 'Yetersiz puan.'], 400);
        }

        // Puan düş
        $user->points -= $reward['points'];
        $user->save();

        return response()->json(['message' => 'Ödül başarıyla kullanıldı.', 'new_points' => $user->points]);
    }
}