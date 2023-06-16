<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class QuotationController extends Controller
{
    public function getQuote(Request $request)
    {
        $parameters = [
            'age' => 29,
            'currency_id' => 'EUR',
            'startDate' => '15-05-2023',
            'endDate' => '30-05-2023',
            'JWT_TOKEN' => env('JWT_SECRET')
        ];

        if (!($parameters['JWT_TOKEN'] == env('JWT_SECRET'))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        foreach (['age', 'currency_id', 'startDate', 'endDate'] as $parameter) {
            if (!($parameters[$parameter])) {
                return response()->json(['success' => false, 'errorMessage' => 'Please submit the required parameter: ' . $parameter]);
            }
        }

        if (!in_array($parameters['currency_id'], ['EUR', 'GBP', 'USD'])) {
            return response()->json(['success' => false, 'errorMessage' => 'The selected currency is not accepted by our system']);
        }

        try {
            $tripStartDate = Carbon::createFromFormat('d-m-Y', $parameters['startDate']);
        } catch (InvalidFormatException $e) {
            return response()->json(['success' => false, 'errorMessage' => 'The starting date is not a correct date format.']);
        }

        try {
            $tripEndDate = Carbon::createFromFormat('d-m-Y', $parameters['endDate']);
        } catch (InvalidFormatException $e) {
            return response()->json(['success' => false, 'errorMessage' => 'The ending date is not a correct date format.']);
        }

        if ($tripStartDate > $tripEndDate){
            return response()->json(['errorMessage' => 'Dates are mixed']);
        }

        $tripLength = $tripStartDate->diffInDays($tripEndDate) + 1;
        $ageTotalLoad = 0;

        if ($parameters['age'] < 18 || $parameters['age'] > 70) {
            return response()->json(['success' => false, 'errorMessage' => 'Age ' . $parameters['age'] . ' is out of range 18-70 years']);
        }
        if (strval($parameters['age']) !== strval(intval($parameters['age']))) {
            return response()->json(['success' => false, 'errorMessage' => 'Age ' . $parameters['age'] . ' is not an integer']);
        }

        $quotationId = $_SESSION['quotationId'] ?? 1;
        $_SESSION['quotationId'] = $quotationId + 1;

        $ageTotalLoad += $this->getAgeRate($parameters['age']);

        $rate = 3;

        $total = $rate * $ageTotalLoad * $tripLength;

        return response()->json([
            'success' => true,
            'quotation_id' => $quotationId,
            'total' => round($total, 2),
            'currency_id' => $parameters['currency_id'],
        ]);
    }

    private function getAgeRate($age)
    {
        if ($age >= 18 && $age <= 30) {
            return 0.6;
        } elseif ($age >= 31 && $age <= 40) {
            return 0.7;
        } elseif ($age >= 41 && $age <= 50) {
            return 0.8;
        } elseif ($age >= 51 && $age <= 60) {
            return 0.9;
        } elseif ($age >= 61 && $age <= 70) {
            return 1;
        }
    }
}
