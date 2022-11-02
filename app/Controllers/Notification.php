<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Notification extends BaseController
{
    public function getNotification()
    {
        if ($this->request->isAJAX()) {
            $notificationModel = new \App\Models\NotificationModel();
            $notification = $notificationModel
                ->where(['id_user' => session()->get('log_id'), 'is_read' => 0])
                ->orderBy('id', 'DESC')
                ->findAll();
            $data = [
                'notification' => $notification,
                'count' => count($notification),
            ];
            return $this->response->setJSON($data);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function markAsRead()
    {
        $notificationModel = new \App\Models\NotificationModel();

        // Update by id user
        $notificationModel->where('id_user', session()->get('log_id'))
            ->set(['is_read' => 1])
            ->update();
        return redirect()->to(previous_url());
    }
}
