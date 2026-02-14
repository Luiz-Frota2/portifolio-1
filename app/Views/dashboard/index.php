<?php ob_start(); ?>

<div class="row">
    <div class="col-12 mb-4">
        <h2>Visão Geral</h2>
        <p class="text-muted">Bem-vindo ao sistema de gestão.</p>
    </div>
</div>

<div class="row g-4">
    <!-- Card 1 -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted text-uppercase mb-2">Vendas Hoje</h6>
                <div class="d-flex align-items-center">
                    <div class="h3 mb-0 me-3">R$ 0,00</div>
                    <span class="badge bg-success">+0%</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card 2 -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted text-uppercase mb-2">Pedidos</h6>
                <div class="d-flex align-items-center">
                    <div class="h3 mb-0 me-3">0</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted text-uppercase mb-2">Produtos Críticos</h6>
                <div class="d-flex align-items-center">
                    <div class="h3 mb-0 me-3 text-warning">5</div>
                    <small>Estoque Baixo</small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
include __DIR__ . '/../layouts/admin.php';
?>
