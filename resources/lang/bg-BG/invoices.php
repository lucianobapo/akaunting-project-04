<?php

return [

    'invoice_number'    => 'Номер на фактура',
    'invoice_date'      => 'Дата на фактура',
    'total_price'       => 'Обща цена',
    'due_date'          => 'Падежна дата',
    'order_number'      => 'Номер на поръчка',
    'bill_to'           => 'Издадена на',

    'quantity'          => 'Количество',
    'price'             => 'Цена',
    'sub_total'         => 'Междинна сума',
    'discount'          => 'Отстъпка',
    'tax_total'         => 'Общо данък',
    'total'             => 'Общо',

    'item_name'         => 'Име на артикул | Имена на артикули',

    'show_discount'     => ':discount% отстъпка',
    'add_discount'      => 'Добави отстъпка',
    'discount_desc'     => 'на междинна сума',

    'payment_due'       => 'Дължимото плащане',
    'paid'              => 'Платен',
    'histories'         => 'История',
    'payments'          => 'Плащания',
    'add_payment'       => 'Добавяне на плащане',
    'mark_paid'         => 'Отбележи като платено',
    'mark_sent'         => 'Маркирай като изпратено',
    'download_pdf'      => 'Изтегляне на PDF',
    'send_mail'         => 'Изпращане на имейл',
    'all_invoices'      => 'Вход за да видите всички фактури',

    'status' => [
        'draft'         => 'Чернова',
        'sent'          => 'Изпратено',
        'viewed'        => 'Разгледани',
        'approved'      => 'Одобрени',
        'partial'       => 'Частичен',
        'paid'          => 'Платен',
    ],

    'messages' => [
        'email_sent'     => 'И-мейла беше изпратен успешно!',
        'marked_sent'    => 'Фактурата беше изпратена успешно!',
        'email_required' => 'Няма имейл адрес за този клиент!',
        'draft'          => 'Това е <b>ЧЕРНОВА</b> фактура и няма да бъде отразена в графиките след като бъде изпратена.',

        'status' => [
            'created'   => 'Създадено на :date',
            'send'      => [
                'draft'     => 'Не е изпратено',
                'sent'      => 'Изпратено на :date',
            ],
            'paid'      => [
                'await'     => 'Очакващо плащане',
            ],
        ],
    ],

    'notification' => [
        'message'       => 'Вие получавате този имейл, защото имате предстояща фактура за плащане на стойност :amount на :customer.',
        'button'        => 'Плати сега',
    ],

];