<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\UserRequest;
use Illuminate\Support\Facades\Auth;

class MatchController extends Controller
{
    public function index()
    {
        $myProfile = Profile::where('user_id', Auth::id())
            ->first();

        if (!$myProfile || !$myProfile->gender) {
            return redirect()->route('profile.create')
                ->with('error', 'Create your profile first.');
        }

        /* MY GENDER */
        $myGender = ucfirst(strtolower($myProfile->gender));
        $targetGender = $myGender === 'Male' ? 'Female' : 'Male';

        /*  GET ALL REQUEST RELATIONS */
        $relations = UserRequest::where(function ($q) use ($myProfile) {
            $q->where('sender_id', $myProfile->id)
                ->orWhere('receiver_id', $myProfile->id);
        })->get();

        /* GET PROFILES */
        $profiles = Profile::where('visibility', 'public')
            ->where('user_id', '!=', Auth::id())
            ->whereNotNull('gender')
            ->whereHas('user', function ($q) {
                $q->where('status', '!=', 'banned');
            })
            ->where('is_active', 1)
            ->where('gender', $targetGender)
            ->get();

        /* ATTACH REQUEST STATUS */
        $profiles = $profiles->map(function ($profile) use ($relations, $myProfile) {

            $profile->requestStatus = 'none'; // default

            foreach ($relations as $relation) {

                if (
                    ($relation->sender_id == $myProfile->id && $relation->receiver_id == $profile->id) ||
                    ($relation->sender_id == $profile->id && $relation->receiver_id == $myProfile->id)
                ) {
                    if ($relation->is_blocked) {
                        $profile->requestStatus = 'blocked';
                    } elseif ($relation->is_accepted) {
                        $profile->requestStatus = 'friends';
                    } elseif ($relation->is_rejected) {
                        $profile->requestStatus = 'rejected';
                    } elseif ($relation->is_pending) {
                        $profile->requestStatus =
                            $relation->sender_id == $myProfile->id ? 'sent' : 'received';
                    }

                    break;
                }
            }

            return $profile;
        });

        /* CALCULATE MATCH SCORE */
        $matches = [];

        foreach ($profiles as $profile) {

            // ❌ Skip blocked users
            if ($profile->requestStatus === 'blocked') {
                continue;
            }

            $score = $this->calculateMatch($myProfile, $profile);

            if ($score >= 40) {
                $matches[] = [
                    'profile' => $profile,
                    'score' => $score
                ];
            }
        }

        /* SORT BY SCORE */
        usort($matches, fn($a, $b) => $b['score'] <=> $a['score']);

        return view('matches.show-matches', compact('matches'));
    }

    /* MATCH SCORE LOGIC */

    private function calculateMatch($me, $candidate)
    {
        $score = 0;

        /* AGE (20%) */
        if (
            isset($me->preferences['age_min'], $me->preferences['age_max']) &&
            $candidate->age >= $me->preferences['age_min'] &&
            $candidate->age <= $me->preferences['age_max']
        ) {
            $score += 20;
        }

        /* RELIGION (20%) */
        if (
            empty($me->preferences['religion']) ||
            $me->preferences['religion'] === $candidate->religion
        ) {
            $score += 20;
        }

        /* CASTE (10%) */
        if (
            empty($me->preferences['cast']) ||
            $me->preferences['cast'] === $candidate->community
        ) {
            $score += 10;
        }

        /* MARITAL STATUS (10%) */
        if (
            empty($me->preferences['marital_status']) ||
            in_array($candidate->marital_status, (array) $me->preferences['marital_status'])
        ) {
            $score += 10;
        }

        /* PROFESSION (15%) */
        if (
            empty($me->preferences['profession']) ||
            in_array($candidate->profession, (array) $me->preferences['profession'])
        ) {
            $score += 15;
        }

        /* PERSONALITY (15%) */
        if (
            !empty($me->preferences['personality']) &&
            !empty($candidate->preferences['personality'])
        ) {
            $common = array_intersect(
                (array) $me->preferences['personality'],
                (array) $candidate->preferences['personality']
            );

            if (count($common) > 0) {
                $score += 15;
            }
        }

        /* LOCATION (10%) */
        if (
            !empty($me->preferences['location']) &&
            $me->preferences['location'][0] === $candidate->country &&
            $me->preferences['location'][1] === $candidate->state &&
            $me->preferences['location'][2] === $candidate->city
        ) {
            $score += 10;
        }

        return $score;
    }
}
