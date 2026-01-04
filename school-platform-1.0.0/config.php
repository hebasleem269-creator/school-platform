<?php
// ملف إعدادات school-platform

return [
    // بيانات المستخدم الافتراضي
    'default_user' => [
        'username' => 'admin',
        'password' => '1234', // تقدري تغيريها لاحقًا
        'role'     => 'administrator'
    ],

    // إعدادات الرفع
    'upload' => [
        'path' => __DIR__ . '/uploads/', // مجلد الرفع
        'max_size' => 5 * 1024 * 1024,   // الحجم المسموح (5MB)
        'allowed_types' => ['jpg', 'png', 'pdf', 'mp4']
    ],

    // إعدادات عامة
    'site' => [
        'name' => 'School Platform',
        'language' => 'ar',
        'timezone' => 'Africa/Cairo'
    ]
];
