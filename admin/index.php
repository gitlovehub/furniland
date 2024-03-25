<?php
session_start();

require_once '../commons/env.php';
require_once '../commons/helper.php';
require_once '../commons/connect-db.php';
require_once '../commons/model.php';

// require file trong controllers và models
require_file(PATH_CONTROLLER_ADMIN);
require_file(PATH_MODEL_ADMIN);

// Điều hướng
$act = $_GET["act"] ?? '/';

// Kiểm tra xem admin đã đăng nhập chưa
middleware_auth_check($act);

match ($act) {
    '/' => dashboard(),
    'dashboard' => dashboard(),

    // Authentication
    'login'  => authLogin(),
    'logout' => authLogout(),

    // CRUD Category
    'create-category'        => createCategory(),
    'category-list'          => CategoryList(),
    'update-category'        => updateCategory($_GET["id"]),
    'delete-category'        => deleteCategory($_GET["id"]),
    'category-bin'           => categoryBin(),
    'update-status-category' => updateCategoryStatus($_GET["id"], $_GET["value"]),

    // CRU Product
    'create-product'        => createProduct(),
    'product-list'          => productList(),
    'update-product'        => updateProduct($_GET["id"]),
    'product-bin'           => productBin(),
    'update-status-product' => updateProductStatus($_GET["id"], $_GET["value"]),
    'add-gallery'           => addGallery($_GET["id"]),
    'delete-image'          => deleteImage($_GET["id"], $_GET["back"]),
    

    // Review
    'manage-reviews' => manageReviews(),

    // Account
    'admin-list'             => adminList(),
    'customer-list'          => customerList(),
    'customer-bin'           => customerBin(),
    'update-status-customer' => updateCustomerStatus($_GET["id"], $_GET["value"]),

    // Order
    'order-list'    => orderList(),
    'order-details' => orderDetails($_GET["id"]),


};

require_once '../commons/disconnect-db.php';
?>