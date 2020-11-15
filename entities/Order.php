<?php

namespace entities;

class Order
{
    private int $id;
    private DeliveryInfo $delivery_info;
    private int $id_user;
    private string $order_status;
    private string $payment_status;

}