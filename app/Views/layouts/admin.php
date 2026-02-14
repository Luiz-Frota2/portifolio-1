<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'ERP' ?></title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column flex-shrink-0" id="sidebar" style="width: 250px;">
        <div class="brand">
            <i class="bi bi-lightning-charge-fill me-2"></i> ERP ELÉTRICA
        </div>
        
        <ul class="nav nav-pills flex-column mb-auto mt-3">
            <li class="nav-item">
                <a href="/dashboard" class="nav-link <?= ($_SERVER['REQUEST_URI'] == '/dashboard') ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            
            <li class="nav-item">
                <a href="/vendas" class="nav-link">
                    <i class="bi bi-cart"></i> Vendas
                </a>
            </li>

            <li class="nav-item">
                <a href="/produtos" class="nav-link">
                    <i class="bi bi-box-seam"></i> Produtos
                </a>
            </li>

            <li class="nav-item">
                <a href="/clientes" class="nav-link">
                    <i class="bi bi-people"></i> Clientes
                </a>
            </li>

            <li class="nav-item">
                <a href="/financeiro" class="nav-link">
                    <i class="bi bi-cash-coin"></i> Financeiro
                </a>
            </li>

            <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <li class="nav-item">
                <a href="/config" class="nav-link">
                    <i class="bi bi-gear"></i> Configurações
                </a>
            </li>
            <?php endif; ?>
        </ul>

        <div class="border-top p-3">
            <div class="d-flex align-items-center mb-2">
                <div class="flex-grow-1 small fw-bold">
                    <?= $_SESSION['user_name'] ?? 'Usuário' ?>
                </div>
            </div>
            <a href="/logout" class="btn btn-sm btn-outline-danger w-100">
                <i class="bi bi-box-arrow-right"></i> Sair
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 d-flex flex-column" style="height: 100vh; overflow-y: auto;">
        <!-- Topbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4" style="height: 60px;">
            <div class="container-fluid">
                <button class="btn btn-link text-dark" id="sidebarToggle">
                    <i class="bi bi-list fs-4"></i>
                </button>
                
                <div class="ms-auto d-flex align-items-center gap-3">
                    <div class="badge bg-secondary">
                        <?= ucfirst($_SESSION['user_role'] ?? 'Guest') ?>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="p-4">
            <?php if(isset($content)) echo $content; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Simple toggle implementation
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        const sidebar = document.getElementById('sidebar');
        if (sidebar.style.marginLeft === '-250px') {
            sidebar.style.marginLeft = '0';
        } else {
            sidebar.style.marginLeft = '-250px';
        }
    });

    // Make it responsive initially
    if (window.innerWidth < 768) {
        document.getElementById('sidebar').style.marginLeft = '-250px';
    }
</script>
</body>
</html>
