<aside class="sidebar">
  <div class="center-text margin-bottom-sm">
    <h2 class="heading-tertiary">Dashboard</h2>
  </div>
  <ul class="sidebar-main-list">
    <li>
      <a href="dashboard.php?update_profile" class="btn btn-ghost btn-small <?php if(isset($_REQUEST["update_profile"])|| empty($_REQUEST)) {
          echo "make-btn-full";
      } ?>">Update profile</a>
    </li>
    <li>
      <a href="dashboard.php?update_address" class="btn btn-ghost btn-small <?php if(isset($_REQUEST["update_address"])) {
          echo "make-btn-full";
      }?>">Update address</a>
    </li>
    <li>
      <a href="dashboard.php?update_password" class="btn btn-ghost btn-small <?php if(isset($_REQUEST["update_password"])) {
          echo "make-btn-full";
      }?>">Update password</a>
    </li>
    <li>
      <a href="dashboard.php?order_history" class="btn btn-ghost btn-small <?php if(isset($_REQUEST["order_history"])) {
          echo "make-btn-full";
      }?>" >Order history</a>
    </li>
  </ul>
</aside>
