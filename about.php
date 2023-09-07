<?php $title = "KushadeviAgro - About"?>
<?php require_once("header.php") ?>
<section class="section-about">
  <div class="about container grid-gap-lg grid-2-cols">
    <img
      src="img/about.png"
      class="about-img"
      alt="Collage of comany staff image"
    />
    <article class="about-text-box">
      <div class="center-text margin-bottom-md">
        <h2 class="heading-secondary">Our story</h2>
        <span class="underline"></span>
      </div>
      <p class="about-text">
        Since its inception in 2017, our firm has established itself as a reliable supplier for high-quality plants and seeds in Nepal. Gardening enthusiasts in the past had difficulty obtaining dependable suppliers for their requirements. We addressed this by handpicking superior specimens and meticulously evaluating seeds, resulting in the establishment of a network that today encompasses more than 30 districts. With a diverse selection, curated to thrive in various climates, we bring convenience to gardening enthusiasts who no longer need to search tirelessly. Join us in transforming your gardening experience, nurturing vibrant, healthy plants that flourish in your own backyard.
      </p>
    </article>
  </div>
</section>
<?php if(isset($_SESSION["search"])) {
    unset($_SESSION["search"]);
} ?>
<?php if(isset($_SESSION["category"])) {
    unset($_SESSION["category"]);
} ?>
<?php if(isset($_SESSION["sub_category"])) {
    unset($_SESSION["sub_category"]);
} ?>
<?php require_once("footer.php") ?>
