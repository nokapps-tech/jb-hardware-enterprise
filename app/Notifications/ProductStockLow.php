<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Support\Facades\Auth;

class ProductStockLow extends Notification
{
    protected Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'low_stock',
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'quantity' => $this->product->quantity,
            'threshold' => $this->product->threshold,
            'message' => "{$this->product->name} stock is low ({$this->product->quantity}/{$this->product->threshold})",
            'url' => route('products.show', $this->product->id),
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
