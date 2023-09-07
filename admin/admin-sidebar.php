<aside class="sidebar">
  <ul class="sidebar-main-list">
    <li class="main-menu">
      <a href="index.php" class="btn btn-ghost btn-small <?php if(basename($_SERVER['PHP_SELF'])=="index.php") {
          echo "make-btn-full";
      } ?>">Dashboard</a>
    </li>
    <li class="main-menu">
      <input type="checkbox" id="toggle1" class="cb-toggle">
      <label for="toggle1">
        <a class="btn btn-ghost btn-small <?php if(basename($_SERVER['PHP_SELF'])=="main-category.php"||basename($_SERVER['PHP_SELF'])=="sub-category.php") {
            echo "make-btn-full";
        }?>">Category</a>
        <svg xmlns=" http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="chev-down">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
      </label>
      <ul class="sidebar-sub-list">
        <li class="sub-menu">
          <a href="main-category.php" class="btn btn-ghost btn-tiny sub-link <?php if(basename($_SERVER['PHP_SELF'])=="main-category.php") {
              echo "make-btn-full";
          } ?>">Main category</a>
        </li>
        <li class="sub-menu">
          <a href="sub-category.php" class="btn btn-ghost btn-tiny sub-link <?php if(basename($_SERVER['PHP_SELF'])=="sub-category.php") {
              echo "make-btn-full";
          }?>">Sub category</a>
        </li>
      </ul>
    </li>

    <li class="main-menu">
      <a href="products.php" class="btn btn-ghost btn-small <?php if(basename($_SERVER['PHP_SELF'])=="products.php" || basename($_SERVER['PHP_SELF'])=="add-product.php" || basename($_SERVER['PHP_SELF'])=="edit-product.php") {
          echo "make-btn-full";
      }?>">Products</a>
    </li>

    <li class="main-menu">
      <a href="orders.php" class="btn btn-ghost btn-small <?php if(basename($_SERVER['PHP_SELF'])=="orders.php" || basename($_SERVER['PHP_SELF'])=="order-details.php") {
          echo "make-btn-full";
      }?>">Manage orders</a>
    </li>
    <li class="main-menu">
      <input type="checkbox" id="toggle2" class="cb-toggle">
      <label for="toggle2">
        <a class="btn btn-ghost btn-small <?php if(basename($_SERVER['PHP_SELF'])=="edit-discount.php"||basename($_SERVER['PHP_SELF'])=="edit-shipping-fee.php") {
            echo "make-btn-full";
        }?>">Discount & shipping</a>
        <svg xmlns=" http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="chev-down">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
      </label>
      <ul class="sidebar-sub-list">
        <li class="sub-menu">
          <a href="edit-discount.php" class="btn btn-ghost btn-tiny sub-link <?php if(basename($_SERVER['PHP_SELF'])=="edit-discount.php") {
              echo "make-btn-full";
          }?>">Update discount</a>
        </li>
        <li class="sub-menu">
          <a href="edit-shipping-fee.php" class="btn btn-ghost btn-tiny sub-link <?php if(basename($_SERVER['PHP_SELF'])=="edit-shipping-fee.php") {
              echo "make-btn-full";
          }?>">Update shipping fee</a>
        </li>
      </ul>
    </li>

    <li class="main-menu">
      <a href="customers.php" class="btn btn-ghost btn-small <?php if(basename($_SERVER['PHP_SELF'])=="customers.php") echo "make-btn-full";?>">Customers</a>
    </li>

    <li class="main-menu">
      <a href="customer-messages.php" class="btn btn-ghost btn-small <?php if(basename($_SERVER['PHP_SELF'])=="customer-messages.php") echo "make-btn-full";?>">Customer Messages</a>
    </li>
  </ul>
</aside>
