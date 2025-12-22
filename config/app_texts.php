<?php

return [
    'reservation' => [
        'success' => 'Reserva solicitada correctamente. Recibirás confirmación por email.',
        'duplicate_error' => 'Ya tienes una reserva pendiente o confirmada para este día y hora.',
        'spam_detected' => 'Spam detectado',
        'feedback' => [
            'expired_title' => 'Enlace Caducado',
            'expired_message' => 'Esta solicitud ha caducado y ya no se puede procesar.',
            'handled_title' => 'Ya Gestionada',
            'handled_message' => 'Esta reserva ya ha sido gestionada (:status).',
            'confirmed_title' => 'Reserva Confirmada',
            'confirmed_message' => 'La reserva ha sido confirmada correctamente. Se ha enviado un correo al cliente.',
            'rejected_title' => 'Reserva Rechazada',
            'rejected_message' => 'La reserva ha sido rechazada correctamente. Se ha enviado un correo al cliente.',
            'back_to_home' => 'Volver al inicio',
        ],
    ],
    'order' => [
        'success' => '¡Pedido recibido correctamente!',
        'spam_detected' => 'Spam detectado',
    ],
    'emails' => [
        'reservation_request' => [
            'subject' => 'Nueva Solicitud de Reserva',
            'title' => 'Solicitud de Reserva',
            'intro' => 'Hola Admin, tienes una nueva solicitud de reserva pendiente.',
            'labels' => [
                'client' => 'Cliente',
                'email' => 'Email',
                'phone' => 'Teléfono',
                'persons' => 'Personas',
                'date' => 'Fecha',
                'time' => 'Hora',
                'intolerances' => 'Intolerancias / Notas:',
            ],
            'buttons' => [
                'accept' => 'Aceptar',
                'reject' => 'Rechazar',
            ],
            'expiry' => 'Estos enlaces caducan en 24 horas (:date).',
            'footer' => 'Gestión de Reservas.',
        ],
        'reservation_action' => [
            'subject_confirmed' => 'Reserva Confirmada',
            'subject_rejected' => 'Reserva No Disponible',
            'title_confirmed' => 'Reserva Confirmada',
            'title_rejected' => 'Reserva No Disponible',
            'message_confirmed' => 'Hola :name,<br>Tu reserva ha sido confirmada con éxito. ¡Te esperamos!',
            'message_rejected' => 'Hola :name,<br>Lo sentimos, pero no podemos confirmar tu reserva para la fecha solicitada debido a falta de disponibilidad.',
            'message_rejected_sub' => 'Te invitamos a probar otra fecha u hora llamándonos directamente.',
            'labels' => [
                'day' => 'Día',
                'time' => 'Hora',
                'persons' => 'Personas',
                'address' => 'Dirección',
            ],
            'calendar_intro' => 'Añádelo a tu calendario:',
            'contact_button' => 'Contactar Restaurante',
            'footer' => 'Todos los derechos reservados.',
        ],
        'order_summary' => [
            'subject' => 'Nuevo Pedido Recibido',
            'title' => 'Nuevo Pedido a Domicilio',
            'sections' => [
                'client_data' => 'Datos del Cliente',
                'order_details' => 'Detalle del Pedido',
            ],
            'labels' => [
                'name' => 'Nombre',
                'email' => 'Email',
                'phone' => 'Teléfono',
                'address' => 'Dirección de Entrega',
                'payment_method' => 'Método de Pago',
                'product' => 'Producto',
                'quantity' => 'Cant.',
                'id' => 'ID',
                'total' => 'Total Estimado',
            ],
            'payment_methods' => [
                'card' => 'Tarjeta (Datáfono)',
                'cash' => 'Efectivo',
            ],
            'footer' => 'Restaurant App.',
        ],
        'reservation_client_receipt' => [
            'subject' => 'Hemos recibido tu solicitud de reserva',
            'title' => 'Reserva Recibida',
            'intro' => 'Hola :name,<br>Hemos recibido correctamente tu solicitud de reserva. En cuanto el restaurante la confirme, recibirás un correo de confirmación.',
            'labels' => [
                'date' => 'Fecha',
                'time' => 'Hora',
                'persons' => 'Personas',
            ],
            'footer' => 'Gracias por confiar en nosotros.',
        ],
        'order_client_receipt' => [
            'subject' => 'Resumen de tu pedido',
            'title' => 'Pedido Recibido',
            'intro' => 'Hola :name,<br>¡Gracias por tu pedido! Aquí tienes un resumen de lo que has pedido. Recibirás una confirmación cuando el restaurante empiece a prepararlo.',
            'sections' => [
                'details' => 'Detalles del Pedido',
                'summary' => 'Resumen del Pedido',
            ],
            'labels' => [
                'address' => 'Dirección de entrega',
                'payment' => 'Método de pago',
                'total' => 'Total del pedido',
            ],
            'footer' => '¡Disfruta de tu comida!',
        ]
    ],
    'calendar' => [
        'event_title' => 'Reserva Restaurante',
        'event_description' => "Reserva confirmada para :persons personas.\nNombre: :name",
        'ics_description' => 'Reserva confirmada para :persons personas.',
    ],
    'ui' => [
        'welcome' => [
            'reservation_card_title' => 'Reserva Mesa',
            'reservation_card_description' => 'Endpoint para la gestión de reservas con confirmación por correo y validación de tokens.',
            'delivery_card_title' => 'Comandas a Domicilio',
            'delivery_card_description' => 'Endpoint para la recepción de pedidos con cálculo de totales y notificaciones al administrador.',
            'status_checking' => 'Comprobando sistema...',
            'status_operational' => 'Sistema operativo',
            'status_unavailable' => 'Sistema no disponible',
            'status_api_error' => 'Error en la API',
        ],
    ],
];
