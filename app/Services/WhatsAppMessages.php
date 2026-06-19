<?php

namespace App\Services;

class WhatsAppMessages
{
    public static function forStatus(string $status, string $patientName): string
    {
        $name = trim($patientName);

        return match ($status) {

            'booking_created' =>
                "🏥 *Infinity HealthCare*\n\n" .
                "Dear *{$name}*,\n\n" .
                "Your lab booking has been *successfully confirmed!* ✅\n\n" .
                "Our team will visit your home shortly for sample collection.\n\n" .
                "For any queries, feel free to contact us.\n\n" .
                "Thank you 🙏",

            'Phlebotomist Assigned' =>
                "🏥 *Infinity HealthCare*\n\n" .
                "Dear *{$name}*,\n\n" .
                "A *phlebotomist has been assigned* for your booking. 👨‍⚕️\n\n" .
                "They will be arriving at your location shortly.\n" .
                "Please make sure you are available.\n\n" .
                "Thank you 🙏",

            'Arrived' =>
                "🏥 *Infinity HealthCare*\n\n" .
                "Dear *{$name}*,\n\n" .
                "Our phlebotomist has *arrived at your doorstep!* 🚪\n\n" .
                "Kindly open the door to proceed with sample collection.\n\n" .
                "Thank you 🙏",

            'Sample Collected' =>
                "🏥 *Infinity HealthCare*\n\n" .
                "Dear *{$name}*,\n\n" .
                "Your sample has been *successfully collected.* 🧪✅\n\n" .
                "We have started processing your tests.\n" .
                "You will be notified as soon as your report is ready.\n\n" .
                "Thank you 🙏",

            'Report Ready' =>
                "🏥 *Infinity HealthCare*\n\n" .
                "Dear *{$name}*,\n\n" .
                "Great news! 🎉 Your *lab report is now ready.*\n\n" .
                "Please contact us to receive your report.\n\n" .
                "Thank you 🙏",

            default =>
                "🏥 *Infinity HealthCare*\n\n" .
                "Dear *{$name}*,\n\n" .
                "Your booking status has been updated to: *{$status}*\n\n" .
                "Thank you 🙏",
        };
    }
}