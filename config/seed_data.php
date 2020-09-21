<?php
 
// Database seeder data
 
return [
    'document_types' => ['Contract', 'License Agreement', 'EULA', 'Other'],
    'task_statuses' => ['Черновик', 'В работе', 'Выполнен', 'Отменен'],
    'task_types' => ['Задание', 'Собрание', 'Уведомление'],
    'contact_status' => ['Менеджер', 'Работник', 'Закрытый'],
    'settings' => ['crm_email' => 'noreply@crm-site.loc', 'enable_email_notification' => 1],
    'permissions' => [
        'create_contact', 'edit_contact', 'delete_contact', 'list_contacts', 'view_contact', 'assign_contact',
        'create_document', 'edit_document', 'delete_document', 'list_documents', 'view_document', 'assign_document',
        'create_task', 'edit_task', 'delete_task', 'list_tasks', 'view_task', 'assign_task', 'update_task_status', 
        'edit_profile', 'compose_email', 'list_emails', 'view_email', 'toggle_important_email', 'trash_email', 'send_email',
        'reply_email', 'forward_email', 'show_email_notifications', 'show_calendar'
    ],
    'mailbox_folders' => array(
        array("title"=>"Входящие", "icon" => "fa fa-inbox"),
        array("title"=>"Отправлено", "icon" => "fa fa-envelope-o"),
        array("title"=>"Черновик", "icon" => "fa fa-file-text-o"),
        array("title"=>"Корзина", "icon" => "fa fa-trash-o")
    )
];