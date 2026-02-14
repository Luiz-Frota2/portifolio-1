<?php
require_once __DIR__ . '/../config/database.php';

// Disable time limit for heavy seeding
set_time_limit(0);

echo "<h1>ERP Installation - Setup</h1>";

try {
    $pdo = Database::connect();
    
    // --- 1. Drop Tables if Exist ---
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    $tables = ['users', 'stores', 'products', 'categories', 'customers', 'sales', 'sale_items', 'stock_movements', 'financial_accounts', 'financial_transactions'];
    foreach ($tables as $table) {
        $pdo->exec("DROP TABLE IF EXISTS $table");
        echo "Dropped table: $table <br>";
    }
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

    // --- 2. Create Tables ---
    
    // Stores (Filiais)
    $sql_stores = "CREATE TABLE stores (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        address VARCHAR(255),
        phone VARCHAR(20),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    $pdo->exec($sql_stores);
    echo "Created table: stores <br>";

    // Users
    $sql_users = "CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        store_id INT,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'manager', 'seller', 'cashier') NOT NULL DEFAULT 'seller',
        active BOOLEAN DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (store_id) REFERENCES stores(id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    $pdo->exec($sql_users);
    echo "Created table: users <br>";

    // Categories
    $sql_categories = "CREATE TABLE categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        description TEXT
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    $pdo->exec($sql_categories);
    echo "Created table: categories <br>";

    // Products
    $sql_products = "CREATE TABLE products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        category_id INT,
        code VARCHAR(50) UNIQUE,
        barcode VARCHAR(50),
        name VARCHAR(200) NOT NULL,
        description TEXT,
        price_cost DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        price_sell DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        min_stock INT DEFAULT 5,
        image_url VARCHAR(255),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (category_id) REFERENCES categories(id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    $pdo->exec($sql_products);
    echo "Created table: products <br>";

    // Stock Movements (Individual per store)
    $sql_stock = "CREATE TABLE stock_movements (
        id INT AUTO_INCREMENT PRIMARY KEY,
        store_id INT NOT NULL,
        product_id INT NOT NULL,
        type ENUM('in', 'out', 'transfer', 'adjustment') NOT NULL,
        quantity INT NOT NULL,
        current_balance INT NOT NULL,
        reason VARCHAR(255),
        user_id INT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (store_id) REFERENCES stores(id),
        FOREIGN KEY (product_id) REFERENCES products(id),
        FOREIGN KEY (user_id) REFERENCES users(id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    $pdo->exec($sql_stock);
    echo "Created table: stock_movements <br>";

    // Customers
    $sql_customers = "CREATE TABLE customers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        document VARCHAR(20) UNIQUE, -- CPF/CNPJ
        email VARCHAR(100),
        phone VARCHAR(20),
        address VARCHAR(255),
        type ENUM('person', 'company') DEFAULT 'person',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    $pdo->exec($sql_customers);
    echo "Created table: customers <br>";

    // --- 3. Seed Data ---

    // Seed Stores
    $pdo->exec("INSERT INTO stores (name, address, phone) VALUES 
        ('Matriz - Centro', 'Av. Central, 1000', '(11) 9999-0001'),
        ('Filial - Zona Norte', 'Rua do Norte, 500', '(11) 9999-0002')");
    echo "Seeded: Stores <br>";

    // Seed Users
    $password = password_hash('123456', PASSWORD_DEFAULT);
    $pdo->exec("INSERT INTO users (store_id, name, email, password, role) VALUES 
        (1, 'Administrador', 'admin@erp.com', '$password', 'admin'),
        (1, 'Gerente Matriz', 'gerente@erp.com', '$password', 'manager'),
        (1, 'Vendedor 01', 'vendedor@erp.com', '$password', 'seller'),
        (2, 'Caixa Filial', 'caixa@erp.com', '$password', 'cashier')");
    echo "Seeded: Users <br>";

    // Seed Categories
    $pdo->exec("INSERT INTO categories (name) VALUES 
        ('Fios e Cabos'), ('Iluminação'), ('Tomadas e Interruptores'), ('Ferramentas'), ('Disjuntores')");
    
    // Seed Products (50 fake products)
    $stmt = $pdo->prepare("INSERT INTO products (category_id, code, barcode, name, price_cost, price_sell, min_stock) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    $products = [
        [1, 'CAB001', '7890001', 'Cabo Flexível 2.5mm Preto', 1.50, 3.20, 100],
        [1, 'CAB002', '7890002', 'Cabo Flexível 2.5mm Vermelho', 1.50, 3.20, 100],
        [1, 'CAB003', '7890003', 'Cabo Flexível 2.5mm Azul', 1.50, 3.20, 100],
        [2, 'LAMP01', '7890004', 'Lâmpada LED 9W Branca', 5.00, 12.90, 50],
        [2, 'LAMP02', '7890005', 'Lâmpada LED 12W Branca', 7.00, 15.90, 50],
        [3, 'TOM001', '7890006', 'Tomada 10A Branca', 3.00, 8.50, 30],
        [3, 'INT001', '7890007', 'Interruptor Simples Branco', 4.00, 9.90, 30],
        [4, 'ALIC01', '7890008', 'Alicate Universal 8"', 25.00, 45.90, 10],
        [5, 'DISJ01', '7890009', 'Disjuntor Unipolar 20A', 8.00, 18.00, 20],
        [5, 'DISJ02', '7890010', 'Disjuntor Bipolar 40A', 15.00, 35.00, 15]
    ];
    
    // Generate more products to reach ~50
    for($i=11; $i<=50; $i++) {
        $cat = rand(1, 5);
        $cost = rand(10, 100);
        $sell = $cost * 2.2; // 120% markup
        $products[] = [$cat, "PROD$i", "78900$i", "Produto Elétrico Genérico $i", $cost, $sell, 10];
    }

    foreach ($products as $p) {
        $stmt->execute($p);
    }
    echo "Seeded: 50 Products <br>";

    // Seed Customers
    $pdo->exec("INSERT INTO customers (name, document, email, phone) VALUES 
        ('João da Silva', '12345678901', 'joao@gmail.com', '(11) 90000-0000'),
        ('Construtora ABC', '00123456000100', 'contato@abc.com', '(11) 3000-0000')");
    echo "Seeded: Customers <br>";

    // Seed Stock (Initial balance)
    $stmtStock = $pdo->prepare("INSERT INTO stock_movements (store_id, product_id, type, quantity, current_balance, reason, user_id) VALUES (?, ?, 'in', ?, ?, 'Estoque Inicial', 1)");
    
    // Add 100 units of each product to Store 1 and 50 units to Store 2
    for($p=1; $p<=50; $p++) {
        $stmtStock->execute([1, $p, 100, 100]);
        $stmtStock->execute([2, $p, 50, 50]);
    }
    echo "Seeded: Initial Stock <br>";

    echo "<h3>Installation Complete Successfully!</h3>";
    echo "<p>Use: <strong>admin@erp.com</strong> / <strong>123456</strong></p>";

} catch (PDOException $e) {
    echo "<h3>Error: " . $e->getMessage() . "</h3>";
}
