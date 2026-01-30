<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\PurchaseRequest;

class PrSubmittedNotification extends Notification
{
    use Queueable;

    public $purchaseRequest;

    public function __construct(PurchaseRequest $purchaseRequest)
    {
        $this->purchaseRequest = $purchaseRequest;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'pr_id' => $this->purchaseRequest->id,
            'pr_number' => $this->purchaseRequest->pr_number,
            'requester_name' => $this->purchaseRequest->user->name,
            'message' => "PR Baru {$this->purchaseRequest->pr_number} telah diajukan oleh {$this->purchaseRequest->user->name}.",
            'type' => 'new_pr',
            'url' => route('purchase-requests.show', $this->purchaseRequest->id),
        ];
    }

}
