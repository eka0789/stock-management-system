<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Request as RequestModel;
use App\Models\RequestItem;
use App\Models\User;
use App\Models\Item;

class RequestSeeder extends Seeder
{
    public function run(): void
    {
        $leaders = User::where('role', 'leader')->get();
        $items = Item::all();

        foreach ($leaders as $leader) {

            $req = RequestModel::create([
                'code' => 'REQ-' . strtoupper(uniqid()),
                'user_id' => $leader->id,
                'status' => ['pending', 'approved', 'rejected'][rand(0,2)],
                'note' => 'Auto generated request',
            ]);

            foreach ($items->random(2) as $item) {
                RequestItem::create([
                    'request_id' => $req->id,
                    'item_id' => $item->id,
                    'quantity' => rand(1,5)
                ]);
            }
        }
    }
}
