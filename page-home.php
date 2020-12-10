<?php
// Template name: Home
get_header(); ?>

<?php 
$img_banner = get_stylesheet_directory_uri() . '/img';
?>

<section class="slide-wrapper">
<ul class="slide">
    <li>
        <img class="slide-item" src="<?= $img_banner; ?>/banner_front.jpg">
    </li>
    <li >
        <img class="slide-item" src="<?= $img_banner; ?>/banner_front.jpg">
    </li>
</ul>
</section>


<?php


$products_slide = wc_get_products([
  'limit' => 6,
  'tag' => ['slide'],
]);


$products_new = wc_get_products([
  'limit'=> 9,
  'orderby'=>'date',
  'order'=> 'DESC',
]);

$products_sales = wc_get_products([
  'limit'=> 9,
  'meta_key'=> 'total_sales',
  'orderby'=>'meta_value_num',
  'order'=> 'DESC',
]);

$data = [];

$data['slide'] = format_products($products_slide, 'slide');
$data['lancamentos'] = format_products($products_new, 'medium');
$data['vendas'] = format_products($products_sales, 'medium');


?>
<h1 class="info-main">Destaques</h1>

<?php if(have_posts()) { while (have_posts()) { the_post(); ?>

<ul class="vantagens">
  <li>Frete Grátis</li>
  <li>Troca Fácil</li>
  <li>Até 12x</li>
</ul>

<section class="slide-wrapper-um">
  <ul class="slide-um">
    <?php foreach($data['slide'] as $product) { ?>
    <li class="slide-item-um">
      <img src="<?= $product['img']; ?>" alt="<?= $product['name']; ?>">
      <div class="slide-info">
        <span class="slide-preco"><?= $product['preco']; ?></span>
        <h2 class="slide-nome"><?= $product['name']; ?></h2>
        <a class="btn-link" href="<?= $product['link']; ?>">Ver Produto</a>
      </div>
    </li>
    <?php } ?>
  </ul>
</section>

<section class="container">
  <h1 class="subtitulo">Lançamentos</h1>
  <?php handle_moon_product_list($data['lancamentos']); ?>
</section>



<section class="container">
  <h1 class="subtitulo">Mais Vendidos</h1>
  <?php handle_moon_product_list($data['vendas']); ?>
</section>

<?php } } ?>

<?php get_footer(); ?>