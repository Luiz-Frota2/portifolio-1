<?php

namespace App\Controllers;

use App\Core\Controller;

class DashboardController extends Controller {
    
    public function index() {
        // Simple auth check inline for now, or use middleware
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('login');
        }

        $this->view('dashboard/index', [
            'title' => 'Dashboard'
        ]);
    }
}
