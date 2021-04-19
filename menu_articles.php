<?php
require "includes/config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $config['title']; ?></title>

  <!-- Bootstrap Grid -->
  <link rel="stylesheet" type="text/css" href="/media/assets/bootstrap-grid-only/css/grid12.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

  <!-- Custom -->
  <link rel="stylesheet" type="text/css" href="/media/css/style.css">
</head>
<body>

 

    <?php include "includes/header.php"; ?>

    <div id="content">
      <div class="container">
        <div class="row">
          <section class="content__left col-md-8">
            
            
            

            <div class="block">
              <a href="/articles.php?categorie=1">Всі записи</a>
			  
			  
			  <?php 
		$categories_q_test= mysqli_query($connection, "SELECT * FROM `articles_categories` WHERE `id` = " . (int)$_GET['categorie']);
		$categories_test = array();
		while( $cat_test = mysqli_fetch_assoc($categories_q_test))
			
		{
			$categories_test[] = $cat_test;
		}
			
      
			   
			   foreach( $categories_test as $cat_test )
			   {
			   ?>
			   <h3><?php echo $cat_test['title']; ?></h3>
			   <?php
			   
			   }
			  ?>
              
			  
			  
			  
              
              <div class="block__content">
                <div class="articles articles__horizontal">

                  <?php 
         $articles = mysqli_query($connection, "SELECT * FROM `articles` WHERE `categorie_id` = " . (int)$_GET['categorie'] . " ORDER BY `id` DESC LIMIT 10");
       
		   while($art = mysqli_fetch_assoc($articles))
		   {
			 ?>
			   <article class="article">
                    <div class="article__image" style="background-image: url(/static/images/<?php echo $art['image'];?>);"></div>
                    <div class="article__info">
                      <a href="/article.php?id=<?php echo $art['id'];?>"><?php echo $art['title']; ?></a>
                      <div class="article__info__meta">
					  
					   <?php 
					   
					   $art_cat = false;
					   foreach( $categories as $cat )
					   {
						   if( $cat['id'] == $art['categorie_id'] )
						   {
							   $art_cat = $cat;
							   break;
						   }
					   }
					   ?>
					   
                        <small>Категорія: <a href="/articles.php?categorie=<?php echo $art_cat['id']; ?>"><?php echo $art_cat['title']; ?></a></small>
                      </div>
                      <div class="article__info__preview"><?php echo mb_substr(strip_tags($art['text']), 0, 100, 'utf-8') . ' ...'; ?>
					  </div>
                    </div>
                  </article>
			   
			   <?php
			   
		   }
		   ?>

                </div>
              </div>
            </div>
          </section>
          <section class="content__right col-md-4">
            
			<?php include "includes/sidebar.php"; ?>
			
			
          </section>
        </div>
      </div>
    </div>

    <?php include "includes/footer.php"; ?>

  

</body>
</html>