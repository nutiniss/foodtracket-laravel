<?php

namespace App\Http\Controllers;

use App\Models\ShoppingListItem;
use Illuminate\Support\Facades\Auth;

class ShoppingListItemController extends Controller
{
    public function toggle(ShoppingListItem $shoppingListItem)
    {
        if ($shoppingListItem->shoppingList->user_id !== Auth::id()) {
            abort(403);
        }

        $shoppingListItem->update([
            'is_bought' => ! $shoppingListItem->is_bought,
        ]);

        return back();
    }
}