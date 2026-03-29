<?php

namespace App\Helpers;

class StatusHelper
{
    /**
     * Get Indonesian status label for contact messages
     */
    public static function getContactStatusLabel($status)
    {
        $statusLabels = [
            'new' => 'Baru',
            'read' => 'Dibaca',
            'replied' => 'Dibalas',
            'spam' => 'Spam'
        ];

        return $statusLabels[$status] ?? strtoupper($status);
    }

    /**
     * Get Indonesian status label for services
     */
    public static function getServiceStatusLabel($status)
    {
        $statusLabels = [
            'available' => 'Tersedia',
            'unavailable' => 'Tidak Tersedia'
        ];

        return $statusLabels[$status] ?? strtoupper($status);
    }

    /**
     * Get Indonesian status label for products
     */
    public static function getProductStatusLabel($status)
    {
        $statusLabels = [
            'active' => 'Aktif',
            'inactive' => 'Nonaktif'
        ];

        return $statusLabels[$status] ?? strtoupper($status);
    }
}
