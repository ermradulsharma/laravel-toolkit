<?php

namespace Skywalker\Support\Security\ZeroTrust;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;

class TrustEngine
{
    /**
     * Calculate the trust score for a given user or request context.
     *
     * @param  mixed  $user
     * @param  array  $options
     * @return float Score between 0.0 and 1.0
     */
    public function calculateScore($user, array $options = [])
    {
        $config = Config::get('toolkit.security.zero_trust', [
            'enabled' => true,
            'factors' => [
                'is_vpn' => -0.3,
                'outside_working_hours' => -0.2,
                'recognized_device' => +0.4,
                'unrecognized_device' => -0.2,
            ],
        ]);

        if (! ($config['enabled'] ?? true)) {
            return 1.0;
        }

        $score = 1.0;
        $factors = $config['factors'] ?? [];

        // 1. IP / Network Factor
        $ip = Request::ip();
        if ($this->isVpn($ip)) {
            $score += ($factors['is_vpn'] ?? -0.3);
        }

        // 2. Temporal Factor
        if ($this->isOutsideWorkingHours()) {
            $score += ($factors['outside_working_hours'] ?? -0.2);
        }

        // 3. User Identity / Device Factor
        if ($user && method_exists($user, 'isRecognizedDevice')) {
            if (! $user->isRecognizedDevice()) {
                $score += ($factors['unrecognized_device'] ?? -0.2);
            } else {
                $score += ($factors['recognized_device'] ?? 0.1);
            }
        }

        return (float) max(0.0, min(1.0, $score));
    }

    /**
     * Determine if an IP is likely a VPN or proxy.
     *
     * @param  string  $ip
     * @return bool
     */
    protected function isVpn($ip)
    {
        // Placeholder for advanced detection logic (e.g., GeoIP/Proxy Check)
        return false;
    }

    /**
     * Determine if current time is outside standard working hours.
     *
     * @return bool
     */
    protected function isOutsideWorkingHours()
    {
        $now = Carbon::now();

        // Standard 9-6 working hours
        return $now->hour < 9 || $now->hour > 18;
    }
}
