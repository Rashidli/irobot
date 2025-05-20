<?php

namespace App\Enum;

enum OrderStatus : string
{
    case Ordered = 'ordered';
    case Prepared = 'prepared';
    case DeliveredToCourier = 'delivered_to_courier';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';

    public static function label(string $value): string
    {
        return match ($value) {
            self::Ordered->value => 'Sifariş verildi',
            self::Prepared->value => 'Hazırlanır',
            self::DeliveredToCourier->value => 'Kuryerə verildi',
            self::Delivered->value => 'Çatdırıldı',
            self::Cancelled->value => 'Ləğv edildi',
            default => 'Naməlum status',
        };
    }

    public static function color(string $value): string
    {
        return match ($value) {
            self::Ordered->value => 'table-warning',
            self::Prepared->value => 'table-info',
            self::DeliveredToCourier->value => 'table-primary',
            self::Delivered->value => 'table-success',
            self::Cancelled->value => 'table-danger',
            default => '',
        };
    }
}
