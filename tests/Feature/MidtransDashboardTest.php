<?php

namespace Tests\Feature;

use App\Http\Controllers\Admin\DashboardController;
use App\Models\Category;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MidtransDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_webhook_updates_transaction_status_for_settlement(): void
    {
        $category = Category::create([
            'name' => 'Tech',
            'slug' => 'tech',
            'events_count' => 0,
        ]);

        $event = Event::create([
            'category_id' => $category->id,
            'title' => 'Laravel Meetup',
            'description' => 'Test event',
            'date' => now()->addDay(),
            'location' => 'Online',
            'price' => 150000,
            'stock' => 100,
        ]);

        $transaction = Transaction::create([
            'event_id' => $event->id,
            'order_id' => 'ORDER-001',
            'customer_name' => 'Budi',
            'customer_email' => 'budi@example.com',
            'customer_phone' => '081234567890',
            'total_price' => 150000,
            'status' => 'pending',
        ]);

        $response = $this->postJson('/midtrans/callback', [
            'order_id' => 'ORDER-001',
            'transaction_status' => 'settlement',
            'fraud_status' => 'accept',
        ]);

        $response->assertOk();
        $this->assertSame('settlement', $transaction->fresh()->status);
    }

    public function test_dashboard_controller_returns_summary_metrics(): void
    {
        $category = Category::create([
            'name' => 'Product',
            'slug' => 'product',
            'events_count' => 0,
        ]);

        $event = Event::create([
            'category_id' => $category->id,
            'title' => 'UI/UX Workshop',
            'description' => 'Test event',
            'date' => now()->addDay(),
            'location' => 'Online',
            'price' => 100000,
            'stock' => 100,
        ]);

        Transaction::create([
            'event_id' => $event->id,
            'order_id' => 'ORDER-002',
            'customer_name' => 'Ani',
            'customer_email' => 'ani@example.com',
            'customer_phone' => '081111111111',
            'total_price' => 100000,
            'status' => 'settlement',
        ]);

        Transaction::create([
            'event_id' => $event->id,
            'order_id' => 'ORDER-003',
            'customer_name' => 'Rina',
            'customer_email' => 'rina@example.com',
            'customer_phone' => '082222222222',
            'total_price' => 50000,
            'status' => 'pending',
        ]);

        $controller = new DashboardController();
        $view = $controller->index();

        $this->assertSame(100000, $view->getData()['totalRevenue']);
        $this->assertSame(1, $view->getData()['ticketsSold']);
        $this->assertSame(1, $view->getData()['activeEvents']);
        $this->assertSame(1, $view->getData()['pendingOrders']);
    }
}
