<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ProductStockLow extends Notification
{
    use Queueable;

    protected Product $product;

    /**
     * Create a new notification instance.
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Product Stock Alert')
                    ->line("The product {$this->product->name} has reached its threshold of {$this->product->threshold}. Current stock: {$this->product->quantity}.")
                    ->action('View Product', url("/products/{$this->product->id}"));
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'quantity' => $this->product->quantity,
            'threshold' => $this->product->threshold,
            'message' => "{$this->product->name} stock is low (Quantity: {$this->product->quantity}, Threshold: {$this->product->threshold})",
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'quantity' => $this->product->quantity,
            'threshold' => $this->product->threshold,
        ];
    }
}
