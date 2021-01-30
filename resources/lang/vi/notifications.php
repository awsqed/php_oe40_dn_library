<?php

return [

    'title' => '{0} Thông báo|[1,*] Thông báo (:count)',
    'mark-as-read' => 'Đánh dấu tất cả là đã đọc',
    'empty' => 'Không có thông báo mới',
    'new-borrow' => [
        'message' => '<strong>:fullname</strong> đã gửi một yêu cầu mượn sách có tiêu đề là <strong>:title</strong>',
        'mail' => [
            'subject' => 'Yêu cầu mượn sách mới',
            'intro' => 'Bạn có một yêu cầu mượn sách mới cần được duyệt.',
        ],
    ],
    'borrow-processed' => [
        'accepted' => [
            'message' => 'Yêu cầu mượn <strong>:title</strong> của bạn đã được <strong class="text-success">duyệt</strong>',
            'mail' => [
                'subject' => 'Yêu cầu mượn :title của bạn đã được duyệt',
                'intro' => 'Yêu cầu mượn sách của bạn đã được duyệt. Hãy ghé tiệm sách gần nhất của chúng tôi để lấy sách.',
                'outro' => 'Vui lòng nhớ trả sách **đúng hạn** hoặc không sẽ bị phạt.',
            ],
        ],
        'rejected' => [
            'message' => 'Yêu cầu mượn <strong>:title</strong> của bạn đã bị <strong class="text-danger">từ chối</strong>',
            'mail' => [
                'subject' => 'Yêu cầu mượn :title của bạn đã bị từ chối',
                'intro' => 'Yêu cầu mượn sách của bạn đã bị từ chối.',
            ],
        ],
    ],
    'new-borrows-report' => [
        'message' => 'Có <strong>:count</strong> yêu cầu mượn sách chưa được duyệt',
        'mail' => [
            'subject' => ':count yêu cầu mượn sách mới',
            'intro' => 'Bạn có :count yêu cầu mượn sách mới cần được duyệt.',
        ],
    ],
    'mail' => [
        'hello' => 'Xin chào',
        'check-it-now' => 'Kiểm Tra Ngay',
        'regards' => 'Thân',
        'subcopy' => 'Chép và dán đường dẫn sau vào trình duyệt nếu bạn không thấy được nút bấm',
    ],

];
