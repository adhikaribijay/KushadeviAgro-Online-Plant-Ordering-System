<?php require_once("admin/config.php") ?>
<?php $title = "KushadeviAgro - Home" ?>
<?php require_once("header.php") ?>
<?php
//fetching featured products that is to be shown in this page
$query = "select * from t_product where p_is_featured=1 and p_is_active = 1 order by rand() limit 3";
$result = mysqli_query($conn, $query);
?>
<main>
  <section class="section-hero">
    <div class="hero container grid-gap-lg grid-2-cols">
      <div class="hero-text-box">
        <h1 class="heading-primary">
          Grow Your Farm with the Best Plants and Seeds.
        </h1>
        <p class="hero-description">
          With advanced tissue culture and nursery techniques, we ensure
          that every plant and seed is of the highest quality. Don't wait to
          transform your garden - order now and experience the exceptional
          quality for yourself!
        </p>
        <a href="shop" class="btn btn-full btn-big btn-animated">Order now</a>
      </div>
      <div class="hero-img-box">
        <img src="img/hero.png" alt="Plant collection" class="hero-img " />
      </div>
    </div>
  </section>
  <section class="section-features">
    <div class="container center-text margin-bottom-lg">
      <h2 class="heading-secondary">What makes us special!</h2>
      <span class="underline"></span>
    </div>
    <div class="container grid-gap-md grid-4-cols">
      <div class="feature-box">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="feature-icon">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
        </svg>
        <p class="heading-tertiary margin-bottom-sm">Highest possible quality</p>
        <div class="feature-text">
          We offer a wide range of plants and seeds that are carefully
          selected and tested to ensure the best possible quality. Whether
          you're looking for vegetables, herbs, or flowers, we have
          everything you need to start your garden or farm.
        </div>
      </div>
      <div class="feature-box">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="feature-icon">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
        </svg>
        <p class="heading-tertiary margin-bottom-sm">Sustainable and eco-friendly</p>
        <p class="feature-text">
          We are committed to sustainability and reducing our carbon
          footprint. That's why we offer eco-friendly products like
          compostable seed packets and organic fertilizers that are safe for
          the environment.
        </p>
      </div>
      <div class="feature-box">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="feature-icon">
          <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
        </svg>
        <h3 class="heading-tertiary margin-bottom-sm">Expert advice and support</h3>
        <p class="feature-text">
          Our team of gardening and farming experts are always here to help
          you with any questions or concerns you may have. From selecting
          the right plants for your climate to troubleshooting pest
          problems, we're here to support you every step of the way.
        </p>
      </div>
      <div class="feature-box">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="feature-icon">
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
        </svg>
        <p class="heading-tertiary margin-bottom-sm">Fast and reliable shipping</p>
        <p class="feature-text">
          We know that time is of the essence when it comes to planting and
          harvesting, which is why we offer fast and reliable shipping
          options to get your plants and seeds to you as quickly as
          possible.
        </p>
      </div>
    </div>
  </section>
  <section class="section-featured-products">
    <div class="container center-text margin-bottom-lg">
      <h2 class="heading-secondary">Featured plants</h2>
      <span class="underline"></span>
    </div>
    <div class="container grid-gap-lg grid-3-cols">
      <?php foreach ($result as $row) { ?>
        <article class="product">
          <figure class="product-image">
            <div class="product-img" style="background-image:url('shop/img/uploads/<?php echo $row['p_featured_photo']; ?>');"></div>
            <figcaption class="product-view">
              <a href="shop/product.php?id=<?php echo $row["p_id"]; ?>" class="product-view-link">View detail</a>
            </figcaption>
          </figure>
          <footer class="product-info-box">
            <p class="product-name"><?php echo $row["p_name"]; ?></p>
            <p class="product-price">Rs <?php echo $row["p_price"]; ?></p>
          </footer>
        </article>
      <?php } ?>
    </div>
    <div class="container center-text margin-top-md">
      <a href="shop" class="btn btn-full btn-big">View all plants</a>
    </div>
  </section>
</main>
<?php // with this go back and cross icon button works as expected
?>
<?php if (isset($_SESSION["search"])) {
  unset($_SESSION["search"]);
} ?>
<?php if (isset($_SESSION["category"])) {
  unset($_SESSION["category"]);
} ?>
<?php if (isset($_SESSION["sub_category"])) {
  unset($_SESSION["sub_category"]);
} ?>
<?php require_once("footer.php"); ?>
