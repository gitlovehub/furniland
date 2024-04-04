<section id="intro">
    <div class="grid wide pt-5">
        <nav class="breadcrumb" aria-label="breadcrumb">
            <ol class="breadcrumb fs-3 fw-semibold">
                <li class="breadcrumb-item"><a href="?act=home-page">Home</a></li>
                <li class="breadcrumb-item"><a href="?act=categories">Categories</a></li>
                <li class="breadcrumb-item active" aria-current="page">Review cart</li>
            </ol>
        </nav>

        <?php $carts = getCartByCustomer('tbl_carts', $_SESSION["user"]['id'] ?? ''); ?>

        <div class="text-center">
            <h1 class="text-uppercase my-4 pt-4">Cart</h1>
            <?php if (empty($carts)) : ?>
                <p class="mb-4">Your cart is currently empty.</p>
            <?php endif; ?>
            <span id="span">
                <a href="?act=categories" class="link-hover-0 fw-semibold">Continue shopping</a>
            </span>
        </div>

        <?php if (!empty($carts)) : ?>
            <section class="row g-5">
                <div class="col-12 col-lg-8">
                    <div class="row border-bottom py-4 hide-on-mobile">
                        <div class="col-7 fw-bold">Product</div>
                        <div class="col-3 fw-bold text-center">Quantity</div>
                        <div class="col-2 fw-bold text-end">Total</div>
                    </div>

                    <form action="?act=update-cart" class="w-100" method="post">
                        <?php foreach ($carts as $cart) : ?>
                            <div class="row mb-5">
                                <div class="col-12 col-sm-7">
                                    <div class="d-flex gap-5">
                                        <div onclick="redirectToProductDetail(<?= $cart['id_product'] ?>)" style="width: 150px;" class="cart-item-start m-0">
                                            <?php if (!empty($cart['color_thumbnail'])) : ?>
                                                <img src="<?= BASE_URL . $cart['color_thumbnail'] ?>" alt="product img" class="cart-item-img">
                                            <?php else : ?>
                                                <img src="<?= BASE_URL . $cart['thumbnail'] ?>" alt="product img" class="cart-item-img">
                                            <?php endif; ?>
                                        </div>
                                        <div class="d-flex flex-column justify-content-center gap-3 py-4">
                                            <h4 class="fs-3 fw-semibold"><?= $cart['product'] ?></h4>
                                            <?php if (!empty($cart['color'])) : ?>
                                                <span>Color:
                                                    <span class="fs-4 fw-semibold"><?= $cart['color'] ?></span>
                                                </span>
                                            <?php endif; ?>
                                            <?php $unit = $cart['price'] - ($cart['price'] * $cart['discount'] / 100); ?>
                                            <span class="fs-4 fw-bold">£<?= number_format($unit, 0, '.', ',') ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-3 d-flex">
                                    <div class="m-auto position-relative">
                                        <div class="d-flex border">
                                            <div class="cart-qty-btn fs-2 qty-minus"><span>−</span></div>
                                            <input type="text" name="productQty[<?= $cart['id_cart'] ?>]" class="cart-qty-number" value="<?= $cart['quantity'] ?>" readonly>
                                            <div class="cart-qty-btn fs-2 qty-plus"><span>+</span></div>
                                        </div>
                                        <span id="span" class="cart-remove-btn">
                                            <a class="link-hover-100" href="?act=remove-cart&id=<?= $cart['id_cart'] ?>">Remove</a>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2 d-flex">
                                    <?php
                                    $totalPrice = 0;
                                    $productPrice = ($cart['price'] - ($cart['price'] * $cart['discount'] / 100)) * $cart['quantity'];
                                    ?>
                                    <span class="my-auto ms-auto me-0 fw-bold">₤<?= number_format($productPrice, 0, '.', ',') ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <button type="submit" name="btnUpdateCart" class="btn btn-success px-4 lh-lg mt-5 fs-4 fw-semibold float-end">UPDATE CART</button>
                    </form>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="border bg-light">
                        <h3 class="fs-3 fw-bold text-center text-white bg-dark p-4">ORDER SUMMARY</h3>
                        <div class="px-4 py-5 d-flex flex-column gap-5">
                            <div class="lh-lg">
                                <div class="d-flex justify-content-between">
                                    <span class="fs-3 fw-semibold">Discount:</span>
                                    <span class="fs-3 fw-bold">₤<?= number_format($discountPrice ?? 0, 2, '.', ',') ?></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="fs-3 fw-semibold">Subtotal:</span>
                                    <?php $totalPrice = calculateTotalPrice($carts); ?>
                                    <span class="fs-3 fw-bold">₤<?= number_format($totalPrice, 2, '.', ',') ?></span>
                                </div>
                            </div>
                            <a href="?act=checkout" class="btn btn-danger fs-4 lh-lg fw-semibold w-100">CHECK OUT</a>
                            <p class="text-center">Shipping, taxes, and discount codes calculated at checkout.</p>
                            <p class="text-center fw-semibold">PAYMENT METHODS</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="momo">
                                    <img src="<?= BASE_URL ?>assets/images/momo.png" alt="" style="width: 90px;">
                                </div>
                                <div class="vnpay">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="90" height="40" viewBox="0 0 116.126 32">
                                        <g id="Group_20980" data-name="Group 20980" transform="translate(-3255.742 248.482)">
                                            <g id="Group_20974" data-name="Group 20974" transform="translate(3255.742 -248.482)">
                                                <path id="Path_45942" data-name="Path 45942" d="M3278.74-238.058l-3.042,3.042-.152.15-.967.969-.72.721-.967.967-.15.149-.421.421-.15.152h0l-1.426,1.424v0l-.15.15a6.269,6.269,0,0,1-1.4,1.055,6.364,6.364,0,0,1-.78.362,6.208,6.208,0,0,1-1.841.4,6.13,6.13,0,0,1-1.156-.032,6.2,6.2,0,0,1-2.378-.791,4.315,4.315,0,0,1-.912-.642l0,0q-.089-.086-.177-.177l-5.538-5.538-.118-.118a2.1,2.1,0,0,1-.256-.347,2.081,2.081,0,0,1-.291-1.065c0-.061,0-.122.008-.181a2.279,2.279,0,0,1,.039-.262l.024-.1.012-.041a2.154,2.154,0,0,1,.384-.727c.047-.057.1-.112.15-.167l.1-.1,5.9-5.9h0l3.575-3.575a2.128,2.128,0,0,1,2.9-.1Z" transform="translate(-3255.742 248.482)" fill="#004a9c" />
                                                <path id="Path_45943" data-name="Path 45943" d="M3322.052-150.45" transform="translate(-3311.529 166.008)" fill="none" stroke="#006d9f" stroke-miterlimit="10" stroke-width="1" />
                                                <path id="Path_45944" data-name="Path 45944" d="M3367.643-104.265" transform="translate(-3349.884 127.152)" fill="none" stroke="#006d9f" stroke-miterlimit="10" stroke-width="1" />
                                                <path id="Path_45945" data-name="Path 45945" d="M3300.855-204.256a3.342,3.342,0,0,1-1.394-.311l-1.134-1.132-.278-.275-.047-.049-.528-.528-2.642-2.672q.089.092.177.177a4.292,4.292,0,0,0,.916.644,6.2,6.2,0,0,0,2.378.791,6.13,6.13,0,0,0,1.156.032,6.206,6.206,0,0,0,1.841-.4,6.345,6.345,0,0,0,.78-.362,6.268,6.268,0,0,0,1.4-1.055l.15-.15v0l1.426-1.424h0l.149-.152.421-.421.15-.149.967-.967.72-.72.967-.969.152-.15,6.129-6.129,2.528-2.739.016-.016.136-.134a1.977,1.977,0,0,1,2.8,0l1.384,1.384h0l.045.045a2.264,2.264,0,0,0-1.693.644l-4.684,4.607-.047.057-8.151,8.021-.012-.01-3,2.949-.02.024c-.008.01-.073.083-.181.189a5.324,5.324,0,0,1-1.392.979,4.063,4.063,0,0,1-.906.307,3.639,3.639,0,0,1-.541.067Z" transform="translate(-3288.629 227.967)" fill="#e50019" />
                                                <path id="Path_45946" data-name="Path 45946" d="M3358.043-198.2l-.15.152-6.639,6.739-6.971,7.078a6.141,6.141,0,0,1-.7.6.346.346,0,0,1-.028.024c-.033.024-.067.049-.1.073l-.012.01a6.392,6.392,0,0,1-3.731,1.193,6.409,6.409,0,0,1-4.43-1.77l0,0c-.053-.045-.1-.09-.156-.138l-1.2-1.2-3.369-3.371-1.124-1.124-.158-.158a3.475,3.475,0,0,0,.553.043h.006l.15,0a3.893,3.893,0,0,0,.64-.077,4.626,4.626,0,0,0,1.036-.35,5.9,5.9,0,0,0,1.547-1.087c.1-.1.179-.185.211-.222l2.591-2.546.01.012,8.909-8.765.047-.057,4.327-4.259a1.71,1.71,0,0,1,2.154-.189l1.026,1.026a0,0,0,0,1,0,0l5.564,5.564a2.033,2.033,0,0,1,.14.154A1.98,1.98,0,0,1,3358.043-198.2Z" transform="translate(-3317.602 214.328)" fill="#e50019" />
                                                <g id="Group_20973" data-name="Group 20973" transform="translate(6.003 5.942)">
                                                    <path id="Path_45947" data-name="Path 45947" d="M3306.5-208.231a.408.408,0,0,1-.573-.006,6.769,6.769,0,0,0-9.561-.037,6.769,6.769,0,0,0-.036,9.56l2.056,2.073a.189.189,0,0,1,.035.045l-.03,0a6.13,6.13,0,0,1-1.124-.028l-1.51-1.524a7.577,7.577,0,0,1,.04-10.7,7.577,7.577,0,0,1,10.7.041l.006.006A.4.4,0,0,1,3306.5-208.231Z" transform="translate(-3293.569 211.039)" fill="#008ed4" />
                                                    <path id="Path_45948" data-name="Path 45948" d="M3385.912-182.986l-.571.571-1-1.008a.4.4,0,0,1,0-.571.4.4,0,0,1,.571,0Z" transform="translate(-3369.835 188.385)" fill="#008ed4" />
                                                    <path id="Path_45949" data-name="Path 45949" d="M3313.675-173.732l-.018.01a6.333,6.333,0,0,1-.76.354l-2.8-2.823a5.184,5.184,0,0,1-.6-6.58.4.4,0,0,1,.561-.1.4.4,0,0,1,.1.563,4.373,4.373,0,0,0,.5,5.552Z" transform="translate(-3306.209 187.404)" fill="#008ed4" />
                                                    <path id="Path_45950" data-name="Path 45950" d="M3338.075-191.327l-.014.014-.421.421-.136.134-3.15-3.174a4.358,4.358,0,0,0-4.458-1.079.4.4,0,0,1-.508-.258.4.4,0,0,1,.26-.51,5.162,5.162,0,0,1,5.278,1.278Z" transform="translate(-3323.687 198.415)" fill="#008ed4" />
                                                    <path id="Path_45951" data-name="Path 45951" d="M3331.572-176.955l-.571.571-3.156-3.182a1.986,1.986,0,0,0-2.805-.012,1.986,1.986,0,0,0-.01,2.806l2.034,2.051a.4.4,0,0,1,0,.571.4.4,0,0,1-.571,0l-2.036-2.052a2.8,2.8,0,0,1,.016-3.948,2.794,2.794,0,0,1,3.948.016Z" transform="translate(-3318.874 185.733)" fill="#008ed4" />
                                                    <path id="Path_45952" data-name="Path 45952" d="M3342.533-162.616l-.014.014-.421.421-.136.136-3.164-3.187a.4.4,0,0,1,0-.571.4.4,0,0,1,.571,0Z" transform="translate(-3331.521 173.081)" fill="#008ed4" />
                                                </g>
                                            </g>
                                            <g id="Group_20978" data-name="Group 20978" transform="translate(3300.304 -236.339)">
                                                <g id="Group_20976" data-name="Group 20976" transform="translate(0 0.091)">
                                                    <path id="Path_45953" data-name="Path 45953" d="M3536.533-171.4h3.983l3.323,9.161,2.84-7.6a.817.817,0,0,0-.114-.642c-.15-.308-.317-.615-.484-.914h2.972c-.167.615-.431,1.292-.651,1.926l-3.842,10.673a6.35,6.35,0,0,1-3.112-1.424,5.117,5.117,0,0,1-1.257-2.154l-3.209-8.124a5.789,5.789,0,0,0-.448-.906Zm15.869,4.29v6.55c0,.264.07.308.246.528l.774.976h-3.737q.3-.475.633-.923a.992.992,0,0,0,.229-.642v-9.152l-1.055-1.627h3.877l6.277,7.737v-6.172a.923.923,0,0,0-.22-.642c-.2-.308-.422-.615-.642-.914h3.737l-.774.976a.639.639,0,0,0-.229.528v11.139a5.346,5.346,0,0,1-3.912-1.952Z" transform="translate(-3536.533 171.397)" fill="#e50019" fill-rule="evenodd" />
                                                    <g id="Group_20975" data-name="Group 20975" transform="translate(26.692 0.053)">
                                                        <path id="Path_45954" data-name="Path 45954" d="M3705.538-160.659v-8.448a3,3,0,0,0-.18-1.183,1.926,1.926,0,0,0-.632-.738v-.036h5.538a4.853,4.853,0,0,1,2.511.556,2.968,2.968,0,0,1,1.255,1.311,3.653,3.653,0,0,1,.333,1.476q0,2.951-3.443,3.616l-1.191.109a6.214,6.214,0,0,0-.692-.073,2.776,2.776,0,0,0,1.846-2.779q0-2.406-1.966-2.406v8.167a2.624,2.624,0,0,0,.858,2.222v.073h-5.049v-.036A2.028,2.028,0,0,0,3705.538-160.659Z" transform="translate(-3704.726 171.065)" fill="#004a9c" />
                                                        <path id="Path_45955" data-name="Path 45955" d="M3757.57-161.586l2.557-7.25a3.926,3.926,0,0,0,.24-1.105,1.351,1.351,0,0,0-.692-1.087v-.036h4.606l3.674,9.751a6.553,6.553,0,0,0,.633,1.42,5.264,5.264,0,0,0,.918,1.029v.073h-5.732v-.073a1.238,1.238,0,0,0,.775-1.064,2.352,2.352,0,0,0-.148-.8l-.591-1.774h-3.757l-.554,1.565a5.768,5.768,0,0,0-.258,1.046.905.905,0,0,0,.175.519,2.263,2.263,0,0,0,.517.509v.073h-3.868v-.073a3.343,3.343,0,0,0,.877-1.064q.138-.291.281-.673T3757.57-161.586Zm3.031-2.664,2.591,0-1.328-3.718Z" transform="translate(-3747.918 171.065)" fill="#004a9c" />
                                                        <path id="Path_45956" data-name="Path 45956" d="M3828.541-164.322l-3.572-5.3a6.794,6.794,0,0,0-.674-.864,4.07,4.07,0,0,0-.618-.482v-.036h4.569l2.8,4.439,1.588-2.256a2.889,2.889,0,0,0,.369-.782,1.391,1.391,0,0,0,.064-.546,1.061,1.061,0,0,0-.646-.819v-.036h4.338l-4.68,6.686v3.129q0,.2.014.382t.023.319a3.38,3.38,0,0,0,.129.618,1.985,1.985,0,0,0,.7,1.055v.073h-5.224v-.073a1.766,1.766,0,0,0,.821-1.756Z" transform="translate(-3804.799 171.017)" fill="#004a9c" />
                                                    </g>
                                                </g>
                                                <g id="Group_20977" data-name="Group 20977" transform="translate(58.558)">
                                                    <path id="Path_45957" data-name="Path 45957" d="M3905.515-168.918a2.928,2.928,0,0,1,.112-.8,3.278,3.278,0,0,1,.332-.746,2.923,2.923,0,0,1,1.174-1.1,3.752,3.752,0,0,1,1.786-.405,2.8,2.8,0,0,1,.777.1,3.258,3.258,0,0,1,.72.311,2.776,2.776,0,0,1,1.062,1.1,3.762,3.762,0,0,1,.311.777,3.566,3.566,0,0,1,.1.88,3.465,3.465,0,0,1-.285,1.333,3.111,3.111,0,0,1-.816,1.152l.44.423a5.863,5.863,0,0,0,.561.47,3.5,3.5,0,0,0,.66.38,2.224,2.224,0,0,0,.755.2,2.785,2.785,0,0,1-.729.44,2.143,2.143,0,0,1-.807.151,1.815,1.815,0,0,1-.721-.151,3.665,3.665,0,0,1-.69-.371c-.229-.155-.436-.315-.621-.466l-.492-.414c-.034,0-.078,0-.134,0s-.121.013-.2.026l-.293.026a2.817,2.817,0,0,1-1.541-.444,2.994,2.994,0,0,1-1.079-1.2,3.562,3.562,0,0,1-.289-.794,3.932,3.932,0,0,1-.1-.88Zm1.747.017a2.71,2.71,0,0,0,.069.6c.035.147.086.332.164.557a2.159,2.159,0,0,0,.531.872,1.155,1.155,0,0,0,.85.341,1.049,1.049,0,0,0,.967-.518,2.54,2.54,0,0,0,.315-1.325c0-.138-.017-.362-.043-.664a4.589,4.589,0,0,0-.125-.617,3.042,3.042,0,0,0-.181-.509,1.459,1.459,0,0,0-.526-.66,1.35,1.35,0,0,0-.781-.224.976.976,0,0,0-.388.078,1.051,1.051,0,0,0-.328.216,1.507,1.507,0,0,0-.4.669,3.069,3.069,0,0,0-.125.889v.293Zm6.925.065a1.256,1.256,0,0,0,.513-.2,1.084,1.084,0,0,0,.354-.41,1.365,1.365,0,0,0,.1-.25,1.109,1.109,0,0,0,.03-.267,1.07,1.07,0,0,0-.229-.7.846.846,0,0,0-.695-.28h-.073Zm0,.488v1.713a.913.913,0,0,0,.4.867v.039H3912.1v-.039a.9.9,0,0,0,.38-.854v-4.194a2.151,2.151,0,0,0-.069-.6.772.772,0,0,0-.311-.388v-.017h3.016a2.114,2.114,0,0,1,.906.186,1.445,1.445,0,0,1,.634.557,1.3,1.3,0,0,1,.177.41,1.72,1.72,0,0,1,.064.479,1.547,1.547,0,0,1-.224.746,1.863,1.863,0,0,1-.859.716l1.2,2.015a4.022,4.022,0,0,0,.777.932l-1.048.078-.263.009h-.246a1.094,1.094,0,0,1-.561-.121,1.092,1.092,0,0,1-.38-.462Z" transform="translate(-3905.515 171.968)" fill="#e50019" fill-rule="evenodd" />
                                                </g>
                                            </g>
                                            <g id="Group_20979" data-name="Group 20979" transform="translate(3300.839 -244.132)">
                                                <path id="Path_45958" data-name="Path 45958" d="M3543.592-219.349a1.63,1.63,0,0,1-.168.776,1.4,1.4,0,0,1-.45.507,1.836,1.836,0,0,1-.654.272,3.7,3.7,0,0,1-.786.08h-.635v1.85a.143.143,0,0,1-.039.1.126.126,0,0,1-.1.043h-.714a.137.137,0,0,1-.1-.043.136.136,0,0,1-.043-.1v-4.907a.18.18,0,0,1,.061-.153.35.35,0,0,1,.168-.061,4.29,4.29,0,0,1,.643-.043h.757a3.868,3.868,0,0,1,.786.077,1.83,1.83,0,0,1,.654.266,1.376,1.376,0,0,1,.45.5,1.61,1.61,0,0,1,.168.772Zm-.986-.068a.7.7,0,0,0-.268-.62,1.429,1.429,0,0,0-.8-.183h-.5a.973.973,0,0,0-.132.007v1.689h.635a1.284,1.284,0,0,0,.825-.208.768.768,0,0,0,.247-.623Z" transform="translate(-3539.907 221.034)" fill="#008ed4" />
                                                <path id="Path_45959" data-name="Path 45959" d="M3570.8-215.879a.113.113,0,0,1-.036.089.133.133,0,0,1-.093.032h-.757a.117.117,0,0,1-.086-.036.2.2,0,0,1-.05-.086l-.328-1.357h-1.643l-.328,1.357a.2.2,0,0,1-.051.086.116.116,0,0,1-.085.036h-.757a.134.134,0,0,1-.093-.032.112.112,0,0,1-.036-.089.031.031,0,0,1,0-.014.051.051,0,0,0,0-.021l1.171-4.436a.956.956,0,0,1,.186-.389.909.909,0,0,1,.26-.216.865.865,0,0,1,.285-.1,1.87,1.87,0,0,1,.261-.021,1.867,1.867,0,0,1,.261.021.868.868,0,0,1,.286.1.913.913,0,0,1,.261.216.966.966,0,0,1,.186.389l1.171,4.436a.048.048,0,0,0,0,.021A.031.031,0,0,1,3570.8-215.879Zm-2.057-4.246a.21.21,0,0,0-.036-.087.1.1,0,0,0-.079-.024.1.1,0,0,0-.078.024.206.206,0,0,0-.036.087l-.514,2.074h1.257Z" transform="translate(-3562.244 221.072)" fill="#008ed4" />
                                                <path id="Path_45960" data-name="Path 45960" d="M3599.757-220.92a.223.223,0,0,1-.014.057l-1.085,2.478a1.264,1.264,0,0,1-.207.353.641.641,0,0,1-.228.168v2a.144.144,0,0,1-.039.1.126.126,0,0,1-.1.043h-.714a.125.125,0,0,1-.1-.043.142.142,0,0,1-.039-.1v-2a.639.639,0,0,1-.229-.168,1.27,1.27,0,0,1-.207-.353l-1.078-2.478a.223.223,0,0,1-.014-.057.109.109,0,0,1,.029-.075.109.109,0,0,1,.086-.032h.793a.118.118,0,0,1,.085.036.2.2,0,0,1,.05.079l.857,2.128a.288.288,0,0,0,.068.118.1.1,0,0,0,.054.025.1.1,0,0,0,.061-.025.288.288,0,0,0,.068-.118l.857-2.128a.2.2,0,0,1,.05-.079.117.117,0,0,1,.085-.036h.786a.121.121,0,0,1,.089.032A.1.1,0,0,1,3599.757-220.92Z" transform="translate(-3586.852 221.034)" fill="#008ed4" />
                                                <path id="Path_45961" data-name="Path 45961" d="M3633.646-215.746a.147.147,0,0,1-.086.025h-.721a.1.1,0,0,1-.083-.043.164.164,0,0,1-.032-.1v-3.321c0-.048-.007-.071-.022-.071s-.017.014-.036.043l-.686,1.364a.248.248,0,0,1-.1.089.277.277,0,0,1-.132.032h-.721a.277.277,0,0,1-.132-.032.246.246,0,0,1-.1-.089l-.693-1.364c-.019-.029-.031-.043-.035-.043s-.021.024-.021.071v3.321a.161.161,0,0,1-.032.1.1.1,0,0,1-.082.043h-.721a.146.146,0,0,1-.086-.025.094.094,0,0,1-.035-.082v-4.913a.276.276,0,0,1,.082-.2.277.277,0,0,1,.2-.082h.585a.284.284,0,0,1,.157.046.29.29,0,0,1,.107.125l1.078,2.185.043.075a.04.04,0,0,0,.035.025.042.042,0,0,0,.036-.025l.043-.075,1.078-2.185a.286.286,0,0,1,.107-.125.284.284,0,0,1,.157-.046h.586a.278.278,0,0,1,.2.082.278.278,0,0,1,.082.2v4.913A.094.094,0,0,1,3633.646-215.746Z" transform="translate(-3614.943 221.034)" fill="#008ed4" />
                                                <path id="Path_45962" data-name="Path 45962" d="M3671.229-215.874a.231.231,0,0,1-.111.043l-.189.033q-.1.018-.257.033t-.371.014h-.539a3.536,3.536,0,0,1-.65-.056,1.3,1.3,0,0,1-.521-.214,1.075,1.075,0,0,1-.35-.438,1.767,1.767,0,0,1-.128-.729v-2.446a1.767,1.767,0,0,1,.128-.729,1.075,1.075,0,0,1,.35-.438,1.3,1.3,0,0,1,.521-.214,3.534,3.534,0,0,1,.65-.056h.539q.218,0,.371.014t.257.033l.189.033a.233.233,0,0,1,.111.044.144.144,0,0,1,.032.109v.464a.137.137,0,0,1-.043.1.137.137,0,0,1-.1.043h-1.457a.624.624,0,0,0-.439.122.641.641,0,0,0-.125.459v.73h1.936a.137.137,0,0,1,.1.043.138.138,0,0,1,.043.1v.514a.138.138,0,0,1-.043.1.137.137,0,0,1-.1.043H3669.1v.919a.7.7,0,0,0,.125.485.6.6,0,0,0,.439.128h1.457a.137.137,0,0,1,.1.043.14.14,0,0,1,.043.1v.463A.143.143,0,0,1,3671.229-215.874Z" transform="translate(-3647.766 221.072)" fill="#008ed4" />
                                                <path id="Path_45963" data-name="Path 45963" d="M3701.338-215.8a.275.275,0,0,1-.2.082h-.721a.855.855,0,0,1-.239-.032c-.074-.022-.139-.1-.2-.225l-1.585-3.478c-.019-.038-.041-.057-.064-.057s-.036.019-.036.057v3.592a.144.144,0,0,1-.039.1.126.126,0,0,1-.1.043h-.607a.137.137,0,0,1-.1-.043.137.137,0,0,1-.043-.1v-4.878a.277.277,0,0,1,.082-.2.277.277,0,0,1,.2-.082h.772a.337.337,0,0,1,.182.043.419.419,0,0,1,.132.186l1.664,3.671c.014.038.033.057.057.057s.035-.021.035-.064v-3.756a.12.12,0,0,1,.136-.136h.614a.12.12,0,0,1,.136.136v4.885A.275.275,0,0,1,3701.338-215.8Z" transform="translate(-3672.412 221.034)" fill="#008ed4" />
                                                <path id="Path_45964" data-name="Path 45964" d="M3733-220.234a.15.15,0,0,1-.1.036h-1.25v4.335a.137.137,0,0,1-.043.1.137.137,0,0,1-.1.043h-.707a.137.137,0,0,1-.1-.043.137.137,0,0,1-.043-.1V-220.2h-1.25a.152.152,0,0,1-.1-.036.115.115,0,0,1-.042-.093v-.564a.126.126,0,0,1,.042-.1.144.144,0,0,1,.1-.039h3.492a.143.143,0,0,1,.1.039.126.126,0,0,1,.043.1v.564A.115.115,0,0,1,3733-220.234Z" transform="translate(-3699.216 221.034)" fill="#008ed4" />
                                                <path id="Path_45965" data-name="Path 45965" d="M3778.142-215.871a5.538,5.538,0,0,1-.635.088q-.364.032-.921.032a2.078,2.078,0,0,1-.625-.105,1.792,1.792,0,0,1-.621-.351,1.855,1.855,0,0,1-.478-.659,2.49,2.49,0,0,1-.189-1.038v-1.009a2.582,2.582,0,0,1,.182-1.037,1.849,1.849,0,0,1,.468-.662,1.719,1.719,0,0,1,.625-.354,2.223,2.223,0,0,1,.66-.105h.5a4.052,4.052,0,0,1,.439.022q.2.022.357.044c.1.014.186.027.243.036a.147.147,0,0,1,.136.152v.486a.189.189,0,0,1-.029.116.141.141,0,0,1-.115.036h-.021a4.232,4.232,0,0,0-.622-.038h-.885a.94.94,0,0,0-.346.066.769.769,0,0,0-.3.218,1.12,1.12,0,0,0-.211.406,2.115,2.115,0,0,0-.078.621v1a2,2,0,0,0,.082.617,1.158,1.158,0,0,0,.214.4.769.769,0,0,0,.3.218.859.859,0,0,0,.322.066h.371a3.2,3.2,0,0,0,.336-.017v-1.764a.163.163,0,0,1,.039-.108.121.121,0,0,1,.1-.047h.707a.139.139,0,0,1,.1.042.134.134,0,0,1,.043.1v2.361A.155.155,0,0,1,3778.142-215.871Z" transform="translate(-3737.414 221.072)" fill="#008ed4" />
                                                <path id="Path_45966" data-name="Path 45966" d="M3809.343-215.879a.113.113,0,0,1-.036.089.133.133,0,0,1-.093.032h-.757a.117.117,0,0,1-.086-.036.2.2,0,0,1-.05-.086l-.328-1.357h-1.643l-.329,1.357a.192.192,0,0,1-.05.086.116.116,0,0,1-.085.036h-.757a.134.134,0,0,1-.093-.032.112.112,0,0,1-.036-.089.031.031,0,0,1,0-.014.051.051,0,0,0,0-.021l1.171-4.436a.953.953,0,0,1,.186-.389.906.906,0,0,1,.26-.216.865.865,0,0,1,.285-.1,1.867,1.867,0,0,1,.261-.021,1.867,1.867,0,0,1,.261.021.868.868,0,0,1,.286.1.913.913,0,0,1,.261.216.966.966,0,0,1,.186.389l1.171,4.436a.048.048,0,0,0,0,.021A.031.031,0,0,1,3809.343-215.879Zm-2.057-4.246a.213.213,0,0,0-.036-.087.1.1,0,0,0-.079-.024.1.1,0,0,0-.078.024.2.2,0,0,0-.036.087l-.514,2.074h1.257Z" transform="translate(-3762.93 221.072)" fill="#008ed4" />
                                                <path id="Path_45967" data-name="Path 45967" d="M3838.076-220.234a.152.152,0,0,1-.1.036h-1.25v4.335a.137.137,0,0,1-.042.1.138.138,0,0,1-.1.043h-.707a.137.137,0,0,1-.1-.043.138.138,0,0,1-.043-.1V-220.2h-1.25a.15.15,0,0,1-.1-.036.115.115,0,0,1-.043-.093v-.564a.126.126,0,0,1,.043-.1.143.143,0,0,1,.1-.039h3.492a.144.144,0,0,1,.1.039.127.127,0,0,1,.043.1v.564A.116.116,0,0,1,3838.076-220.234Z" transform="translate(-3787.614 221.034)" fill="#008ed4" />
                                                <path id="Path_45968" data-name="Path 45968" d="M3868.013-215.874a.232.232,0,0,1-.111.043l-.189.033q-.1.018-.257.033c-.1.01-.226.014-.371.014h-.54a3.533,3.533,0,0,1-.65-.056,1.3,1.3,0,0,1-.521-.214,1.073,1.073,0,0,1-.35-.438,1.758,1.758,0,0,1-.128-.729v-2.446a1.759,1.759,0,0,1,.128-.729,1.073,1.073,0,0,1,.35-.438,1.3,1.3,0,0,1,.521-.214,3.531,3.531,0,0,1,.65-.056h.54c.145,0,.269,0,.371.014s.188.021.257.033l.189.033a.234.234,0,0,1,.111.044.144.144,0,0,1,.032.109v.464a.137.137,0,0,1-.043.1.138.138,0,0,1-.1.043h-1.457a.624.624,0,0,0-.439.122.64.64,0,0,0-.125.459v.73h1.935a.137.137,0,0,1,.1.043.137.137,0,0,1,.043.1v.514a.137.137,0,0,1-.043.1.137.137,0,0,1-.1.043h-1.935v.919a.7.7,0,0,0,.125.485.6.6,0,0,0,.439.128h1.457a.138.138,0,0,1,.1.043.14.14,0,0,1,.043.1v.463A.143.143,0,0,1,3868.013-215.874Z" transform="translate(-3813.32 221.072)" fill="#008ed4" />
                                                <path id="Path_45969" data-name="Path 45969" d="M3897.747-220.888l-.671,4.6a.673.673,0,0,1-.208.451.7.7,0,0,1-.435.12h-.385a.527.527,0,0,1-.379-.129.914.914,0,0,1-.215-.443l-.564-2.357c-.01-.052-.024-.079-.043-.079s-.041.026-.05.079l-.564,2.357a.914.914,0,0,1-.215.443.528.528,0,0,1-.378.129h-.385a.7.7,0,0,1-.436-.12.673.673,0,0,1-.207-.451l-.671-4.6v-.025a.1.1,0,0,1,.036-.086.132.132,0,0,1,.085-.029h.757a.111.111,0,0,1,.078.035.146.146,0,0,1,.043.09l.514,4.218.011.079c0,.019.01.029.025.029s.023-.01.025-.029a.579.579,0,0,1,.018-.079l.614-2.507a.519.519,0,0,1,.129-.225.436.436,0,0,1,.322-.1h.492a.436.436,0,0,1,.322.1.519.519,0,0,1,.128.225l.614,2.507a.544.544,0,0,1,.018.079c0,.019.011.029.025.029s.022-.01.025-.029.006-.045.011-.079l.514-4.218a.147.147,0,0,1,.043-.09.112.112,0,0,1,.078-.035h.757a.133.133,0,0,1,.086.029.1.1,0,0,1,.036.086Z" transform="translate(-3836.073 221.034)" fill="#008ed4" />
                                                <path id="Path_45970" data-name="Path 45970" d="M3937.054-215.879a.113.113,0,0,1-.036.089.134.134,0,0,1-.093.032h-.757a.117.117,0,0,1-.086-.036.2.2,0,0,1-.05-.086l-.328-1.357h-1.643l-.329,1.357a.2.2,0,0,1-.05.086.116.116,0,0,1-.086.036h-.757a.133.133,0,0,1-.093-.032.112.112,0,0,1-.036-.089.031.031,0,0,1,0-.014.047.047,0,0,0,0-.021l1.171-4.436a.956.956,0,0,1,.186-.389.913.913,0,0,1,.261-.216.868.868,0,0,1,.286-.1,1.864,1.864,0,0,1,.261-.021,1.87,1.87,0,0,1,.261.021.869.869,0,0,1,.285.1.907.907,0,0,1,.261.216.966.966,0,0,1,.186.389l1.171,4.436a.048.048,0,0,0,0,.021A.028.028,0,0,1,3937.054-215.879ZM3935-220.125a.209.209,0,0,0-.036-.087.1.1,0,0,0-.078-.024.1.1,0,0,0-.079.024.206.206,0,0,0-.036.087l-.514,2.074h1.257Z" transform="translate(-3870.374 221.072)" fill="#008ed4" />
                                                <path id="Path_45971" data-name="Path 45971" d="M3966.009-220.92a.242.242,0,0,1-.014.057l-1.085,2.478a1.276,1.276,0,0,1-.207.353.642.642,0,0,1-.229.168v2a.143.143,0,0,1-.039.1.126.126,0,0,1-.1.043h-.714a.126.126,0,0,1-.1-.043.144.144,0,0,1-.039-.1v-2a.641.641,0,0,1-.229-.168,1.258,1.258,0,0,1-.207-.353l-1.079-2.478a.23.23,0,0,1-.014-.057.11.11,0,0,1,.029-.075.109.109,0,0,1,.086-.032h.793a.118.118,0,0,1,.086.036.2.2,0,0,1,.05.079l.857,2.128a.285.285,0,0,0,.068.118.1.1,0,0,0,.053.025.1.1,0,0,0,.061-.025.291.291,0,0,0,.068-.118l.857-2.128a.2.2,0,0,1,.05-.079.117.117,0,0,1,.086-.036h.785a.121.121,0,0,1,.089.032A.1.1,0,0,1,3966.009-220.92Z" transform="translate(-3894.98 221.034)" fill="#008ed4" />
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                                <div class="zalopay">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="40" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="레이어_1" viewBox="0 0 339.544 97.26" style="overflow:visible;enable-background:new 0 0 339.544 97.26;" xml:space="preserve">
                                        <g>
                                            <path style="fill:#0FA8E0;" d="M99.868,36.624c-1.334-1.362-3.028-2.047-5.088-2.047c-3.028,0-5.238,1.454-6.628,4.358   c-2.969-3.488-7.027-5.23-12.171-5.23c-6.176,0-11.372,2.384-15.58,7.148c-4.206,4.765-6.309,10.578-6.309,17.435   s2.103,12.668,6.309,17.435c4.208,4.766,9.404,7.147,15.58,7.147c5.144,0,9.202-1.742,12.171-5.232   c1.39,2.908,3.6,4.359,6.628,4.359c2.06,0,3.754-0.681,5.088-2.048c1.331-1.362,1.996-3.034,1.996-5.012v-33.3   C101.864,39.662,101.199,37.991,99.868,36.624 M85.109,66.545c-1.727,2.225-4.106,3.336-7.131,3.336   c-3.03,0-5.405-1.111-7.13-3.336c-1.724-2.228-2.588-4.979-2.588-8.258c0-3.277,0.864-6.029,2.588-8.256   c1.725-2.225,4.1-3.337,7.13-3.337c3.025,0,5.404,1.112,7.131,3.337c1.726,2.227,2.589,4.979,2.589,8.256   C87.698,61.565,86.835,64.317,85.109,66.545" />
                                            <path style="fill:#0FA8E0;" d="M117.905,79.949c-1.333,1.367-3.03,2.047-5.085,2.047c-2.061,0-3.757-0.68-5.088-2.047   c-1.334-1.364-1.999-3.037-1.999-5.013V15.344c0-1.975,0.665-3.648,1.999-5.013c1.331-1.366,3.027-2.047,5.088-2.047   c2.055,0,3.752,0.681,5.085,2.047c1.332,1.365,1.997,3.038,1.997,5.013v59.593C119.902,76.912,119.237,78.585,117.905,79.949" />
                                            <path style="fill:#0FA8E0;" d="M164.842,40.853c-4.54-4.764-10.323-7.148-17.349-7.148c-7.024,0-12.758,2.354-17.208,7.061   c-4.453,4.707-6.678,10.547-6.678,17.521c0,6.973,2.225,12.813,6.678,17.521c4.45,4.707,10.184,7.062,17.208,7.062   c7.026,0,12.809-2.382,17.349-7.147c4.36-4.651,6.54-10.462,6.54-17.435C171.382,51.313,169.203,45.503,164.842,40.853    M154.625,66.545c-1.727,2.225-4.104,3.336-7.132,3.336c-3.029,0-5.404-1.111-7.128-3.336c-1.727-2.228-2.59-4.979-2.59-8.258   c0-3.277,0.863-6.029,2.59-8.256c1.724-2.225,4.099-3.337,7.128-3.337c3.028,0,5.405,1.112,7.132,3.337   c1.726,2.227,2.586,4.979,2.586,8.256C157.211,61.565,156.352,64.317,154.625,66.545" />
                                            <path style="fill:#0FA8E0;" d="M46.249,35.354c5.004-6.458,7.509-10.809,7.509-13.048c0-5.18-3.26-7.77-9.781-7.77H9.584   c-2.702,0-4.792,0.639-6.275,1.915c-1.481,1.279-2.223,2.937-2.223,4.979c0,2.045,0.742,3.705,2.223,4.982   c1.483,1.277,3.573,1.915,6.275,1.915h23.621L2.964,67.4C0.988,69.957,0,72.223,0,74.203c0,5.68,3.756,8.521,11.265,8.521h35.477   c5.668,0,8.5-2.379,8.5-7.137c0-4.756-2.832-7.135-8.5-7.135H20.654L46.249,35.354z" />
                                            <path style="fill:#32B34A;" d="M216.824,28.195h-9.492v19.729h9.492c2.852,0,5.164-0.931,6.932-2.792s2.652-4.218,2.652-7.073   c0-2.852-0.885-5.211-2.652-7.072S219.675,28.195,216.824,28.195" />
                                            <path style="fill:#32B34A;" d="M264.18,46.75c-3.013,0-5.375,1.105-7.091,3.319c-1.715,2.215-2.574,4.95-2.574,8.21   c0,3.261,0.859,5.998,2.574,8.214c1.716,2.211,4.078,3.317,7.091,3.317c3.009,0,5.375-1.106,7.092-3.317   c1.718-2.216,2.575-4.953,2.575-8.214c0-3.26-0.857-5.995-2.575-8.21C269.555,47.854,267.189,46.75,264.18,46.75" />
                                            <path style="fill:#32B34A;" d="M331.232,0H193.625c-4.592,0-8.313,3.722-8.313,8.313v80.634c0,4.591,3.722,8.313,8.313,8.313   h108.631c-1.146-1.086-1.721-2.357-1.721-3.814c0-1.189,0.267-2.437,0.801-3.742l5.124-11.395l-14.168-35.376   c-0.416-1.009-0.623-2.108-0.623-3.297c0-1.544,0.653-2.852,1.96-3.921c1.307-1.069,2.673-1.603,4.1-1.603   c3.147,0,5.287,1.514,6.416,4.544l8.82,24.148l9.446-24.148c1.188-3.03,3.325-4.544,6.416-4.544c1.425,0,2.791,0.534,4.099,1.603   c1.305,1.069,1.961,2.377,1.961,3.921c0,1.189-0.21,2.288-0.625,3.297l-20.984,50.958c-0.574,1.424-1.266,2.545-2.071,3.369h20.026   c4.591,0,8.313-3.722,8.313-8.313V8.313C339.544,3.722,335.823,0,331.232,0 M234.039,54.252c-4.344,3.971-9.803,5.956-16.378,5.956   h-10.329v15.261c0,2.297-0.652,4.08-1.955,5.35c-1.303,1.273-2.979,1.908-5.023,1.908c-2.049,0-3.724-0.635-5.026-1.908   c-1.304-1.27-1.954-3.053-1.954-5.35V23.171c0-4.839,2.419-7.259,7.258-7.259h16.473c6.885,0,12.576,2.064,17.076,6.188   c4.496,4.127,6.745,9.478,6.745,16.053C240.924,44.792,238.628,50.156,234.039,54.252 M287.937,74.838   c0,1.966-0.662,3.628-1.985,4.984c-1.327,1.359-3.013,2.037-5.06,2.037c-3.013,0-5.211-1.442-6.593-4.336   c-2.954,3.471-6.989,5.203-12.106,5.203c-6.142,0-11.309-2.367-15.493-7.108c-4.185-4.739-6.276-10.521-6.276-17.341   c0-6.818,2.092-12.6,6.276-17.338c4.185-4.738,9.352-7.109,15.493-7.109c5.117,0,9.152,1.732,12.106,5.201   c1.382-2.888,3.58-4.334,6.593-4.334c2.047,0,3.732,0.681,5.06,2.036c1.323,1.361,1.985,3.022,1.985,4.986V74.838z" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const qtyMinusBtns = document.querySelectorAll('.qty-minus');
        const qtyPlusBtns = document.querySelectorAll('.qty-plus');
        const qtyNumberInputs = document.querySelectorAll('.cart-qty-number');

        // Đặt sự kiện khi click vào nút giảm
        qtyMinusBtns.forEach((btn, index) => {
            btn.addEventListener('click', function() {
                let currentValue = parseInt(qtyNumberInputs[index].value);
                if (currentValue > 1) {
                    qtyNumberInputs[index].value = currentValue - 1;
                }
            });
        });

        // Đặt sự kiện khi click vào nút tăng
        qtyPlusBtns.forEach((btn, index) => {
            btn.addEventListener('click', function() {
                let currentValue = parseInt(qtyNumberInputs[index].value);
                qtyNumberInputs[index].value = currentValue + 1;
            });
        });
    });
</script>