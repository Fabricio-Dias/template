<?php
// Template name: Home
get_header(); ?>

<?php 
$img_banner = get_stylesheet_directory_uri() . '/img';
?>

<section class="slide-wrapper">
<ul class="slide">
    <li>
        <img class="slide-item" src="<?= $img_banner; ?>/banner_bemvindo.jpg">
    </li>
    <li >
        <img class="slide-item" src="<?= $img_banner; ?>/banner_jogos.jpg">
    </li>
</ul>
</section>


<?php
function format_products($products, $img_size) {
  $products_final = [];
  foreach($products as $product) {
    $products_final[] = [
      'name' => $product->get_name(),
      'preco' => $product->get_price_html(),
      'link' => $product->get_permalink(),
      'img' => wp_get_attachment_image_src($product->get_image_id(), $img_size)[0],
    ];
  }
  return $products_final;
}

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

$home_id = get_the_ID();
$categoria_esquerda = get_post_meta($home_id, 'board_games', true);
$categoria_direita = get_post_meta($home_id, 'promocoes', true);

function get_product_category_data($category){
  $cat = get_term_by('slug', $category, 'product_cat');
  $cat_id = $cat-> $term_id;
  $img_id = get_term_meta($cat_id, 'thumbnail_id', true);
  return [
    'name'=> $cat->name,
    'id'=> $cat_id,
    'link'=>get_term_link($cat_id, 'product_cat'),
    'img'=> wp_get_attachment_image_src($img_id, 'slide')[0]
  ];
}

$data['categorias'][$categoria_esquerda] = get_product_category_data($categoria_esquerda);
$data['categorias'][$categoria_direita] = get_product_category_data($categoria_direita);

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
  <?php handle_moon_produc_list($data['lancamentos']); ?>
</section>

<section class="categorias-home">
  <?php foreach($data['categorias'] as $categoria) { ?>
    <a href="<?= $categoria['link'] ?>">
      <img src="<?= $categoria['img'] ?>" alt="<?= $categoria['name'] ?>">
      <span class="btn-link"><?= $categoria['name'] ?></span>
    </a>
  <?php } ?>
</section>


<section class="container">
  <h1 class="subtitulo">Mais Vendidos</h1>
  <?php handle_moon_produc_list($data['vendas']); ?>
</section>

<?php } } ?>

<?php get_footer(); ?>