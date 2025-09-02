<?php
// app/Http/Controllers/USSDController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use App\Models\Investment;

class USSDController extends Controller
{
    /**
     * Handle incoming USSD requests.
     */
    public function handle(Request $request)
    {
        $msisdn = $request->input('msisdn'); // User phone number
        $text = $request->input('text');     // USSD input sequence

        // Split text into menu levels
        $textArray = explode('*', $text);
        $level = count($textArray);

        $response = "";

        switch ($level) {
            case 1:
                // Main menu
                $response = "CON Welcome to NGOMBILAND\n";
                $response .= "1. Search Property\n";
                $response .= "2. My Favorites\n";
                $response .= "3. My Investments\n";
                $response .= "4. My Wallet\n";
                $response .= "5. Notifications\n";
                $response .= "6. Support\n";
                break;

            case 2:
                switch ($textArray[1]) {
                    case '1':
                        // Search Property menu
                        $response = "CON Enter property type or location:";
                        break;
                    case '3':
                        // Show user investments
                        $user = User::where('phone', $msisdn)->first();
                        $investments = Investment::where('user_id', $user->id)->get();
                        $response = "END Your Investments:\n";
                        foreach ($investments as $inv) {
                            $response .= "{$inv->property->title}: {$inv->amount} FCFA\n";
                        }
                        break;
                    case '4':
                        // Wallet balance
                        $user = User::where('phone', $msisdn)->first();
                        $response = "END Your wallet balance is: {$user->wallet_balance} FCFA";
                        break;
                    default:
                        $response = "END Invalid option.";
                        break;
                }
                break;

            default:
                $response = "END Invalid input.";
                break;
        }

        return response($response)->header('Content-Type', 'text/plain');
    }
}
// app/Http/Controllers/CrowdfundingController.php