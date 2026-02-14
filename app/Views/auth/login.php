<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ERP Corporativo</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body class="login-body">

    <div class="login-card card">
        <div class="login-header">
            <h4>ERP ELÉTRICA</h4>
            <small>Acesso Restrito</small>
        </div>
        <div class="card-body p-4">
            
            <?php if(isset($error)): ?>
                <div class="alert alert-danger py-2">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form action="/login" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="admin@erp.com">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-corporate">Entrar</button>
                </div>
            </form>
        </div>
        <div class="card-footer text-center text-muted bg-white border-top-0 pb-4">
            <small>&copy; <?= date('Y') ?> ERP System v1.0</small>
        </div>
    </div>

</body>
</html>
