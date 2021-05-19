<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrdersRequest;
use App\Models\Shoes;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrdersController extends Controller
{
    /**
     * @param OrdersRequest $ordersRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function processOrder(OrdersRequest $ordersRequest): JsonResponse
    {
        $update = $this->updateQuantity($ordersRequest->shoeCollection);

        $store = $this->storeOrderDetails($ordersRequest->userId, $ordersRequest->shoeCollection, $ordersRequest->grandTotal);

        if ($update && $store) {
            return response()->json([
                'success' => $store
            ]);
        }

        return response()->json([
            'success' => false
        ])->header('Access-Control-Allow-Origin', '*')->send();

    }

    /**
     * @param array $shoes
     * @return bool
     */
    private function updateQuantity(array $shoes): bool
    {
        try {
            foreach ($shoes as $shoe) {
                $findShoe = Shoes::where('id', $shoe['id'])->get()->pluck('quantity');
                $quantityLeft = $findShoe[0] - $shoe['userQuantity'];
                Shoes::where('id', $shoe['id'])->update([
                    'quantity' => $quantityLeft
                ]);
            }
        } catch (Exception $exception) {
            report($exception->getMessage());
            return false;
        }

        return true;
    }

    /**
     * @param array $shoes
     * @return array
     */
    private function getProductNames(array $shoes): array
    {
        $names = [];

        foreach ($shoes as $shoe) {
            $product = $shoe['product'];
            array_push($names, $product);
        }

        return $names;
    }

    /**
     * @param int $userId
     * @param array $shoes
     * @param int $amount
     * @return bool|array
     */
    private function storeOrderDetails(int $userId, array $shoes, int $amount) : bool|array
    {
        try {
            $userDetails = User::find($userId);
            $products = $this->getProductNames($shoes);

            DB::table('orders')->insert([
                'user_id' => $userId,
                'reference' => Str::random(7),
                'products' => implode(', ', $products),
                'amount_paid' => $amount,
                'delivery_postcode' => $userDetails->postcode,
                'delivery_address' => $userDetails->address,
                'delivery_date' => Carbon::now()->addDays(4)
            ]);
        } catch (Exception $exception) {
             report($exception->getMessage());
             return false;
        }

        return [
            'reference' => Str::random(7),
            'products' => json_encode($products),
            'amount_paid' => $amount,
            'delivery_postcode' => $userDetails->postcode,
            'delivery_address' => $userDetails->address,
            'delivery_date' => Carbon::now()->addDays(4)->format('d-m-Y')
        ];

    }
}
