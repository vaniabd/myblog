<?php include "includes/config.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Блог IT_Минималиста!</title>

  <!-- Bootstrap Grid -->
  <link rel="stylesheet" type="text/css" href="/media/assets/bootstrap-grid-only/css/grid12.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

  <!-- Custom -->
  <link rel="stylesheet" type="text/css" href="/media/css/style.css">
</head>
<body>

  <div id="wrapper">

   <?php include "includes/header.php"; ?>
    <?php
	$article = mysqli_query($connection, "SELECT * FROM `articles` 
	WHERE `id` = " . (int) $_GET['id']);
	if( mysqli_num_rows($article) <= 0)
	{
		?>
		 <div id="content">
      <div class="container">
        <div class="row">
          <section class="content__left col-md-8">
            <div class="block">
              
              <h3>Стаття не знайдена!</h3>
              <div class="block__content">
                <div class="full-text">
					Сторінка, яку Ви запитуєте не знайдена!                </div>
              </div>
            </div>

         </section>
          <section class="content__right col-md-4">
            <?php include "includes/sidebar.php"; ?>
          </section>
        </div>
      </div>
    </div>
		<?php
	} else 
	{
		$art = mysqli_fetch_assoc($article);
		mysqli_query($connection, "UPDATE `articles` SET `views` = `views` + 1 WHERE `id` = " . (int) $art['id']);
		?>
		 <div id="content">
      <div class="container">
        <div class="row">
          <section class="content__left col-md-8">
            <div class="block">
              <a><?php echo $art['views']; ?> Переглядів</a>
              <h3><?php echo $art['title']; ?></h3>
              <div class="block__content">
			  <img src="/static/images/<?php echo $art['image'];?>" style="max-width: 100%;">
                <div class="full-text"><?php echo $art['text']; ?></div>
              </div>
            </div>
			
			
           <div class="block">
		    <a href="#comment-add-form"> Додати свій </a>
              <h3>Коментарі</h3>
              <div class="block__content">
                <div class="articles articles__vertical">

                 <?php 
         $comments = mysqli_query($connection, "SELECT * FROM `comments` WHERE `articles_id` = " . (int) $art['id']
		 . " ORDER BY `id` DESC");
		 if( mysqli_num_rows($comments) <= 0)
		 {
			 echo "Немає коментарів!";
		 }
       
		   while($comment = mysqli_fetch_assoc($comments))
		   {
			 ?>
			   <article class="article">
                    <div class="article__image" style="background-image: url(https://www.gravatar.com/avatar/<?php echo md5($comment['email']); ?>?s=125);"></div>
                    <div class="article__info">
                      <a href="/article.php?id=<?php echo $comment['articles_id'];?>"><?php echo $comment['author']; ?></a>
                      <div class="article__info__meta"></div>
                      <div class="article__info__preview"><?php echo $comment['text']; ?></div>
                    </div>
                  </article>
			   
			   <?php
		   }
		   ?>

                </div>
              </div>
            </div>

         <div id="comment-add-form" class="block">
		  <h3>Додати коментар</h3>
		 <div class="block__content">
		   <form class="form" method="POST" action="/article.php?id=<?php echo $art['id']; ?>#comment-add-form">
		   <?php
		     if( isset($_POST['do_post']) )
			 {
				 $errors = array();
				 if( $_POST['name'] == '')
				 {
					 $errors[] = 'Введіть ім_я!';
				 }
				  if( $_POST['nickname'] == '')
				 {
					 $errors[] = 'Введіть Ваш нікнейм!';
				 }
				  if( $_POST['email'] == '')
				 {
					 $errors[] = 'Введіть Email!';
				 }
				  if( $_POST['text'] == '')
				 {
					 $errors[] = 'Введіть текст коментаря!';
				 }
				 if( empty($errors) )
				 {
					 //ДОДАТИ КОМЕНТАР
					
                    /* echo '////////';
					echo "INSERT INTO `comments` (`author`,`nickname`,`email`,`text`,
					 `pubdate`,`articles_id`) VALUES ('" . mysqli_real_escape_string ($connection, $_POST['name'])."', '". mysqli_real_escape_string ($connection, $_POST['nickname'])."', 
					 '".mysqli_real_escape_string ($connection, $_POST['email'])."', '".$_POST['text']."', NOW(), '".$art['id']."')";
					 exit();*/
					 
					 mysqli_query($connection, "INSERT INTO `comments` (`author`,`nickname`,`email`,`text`,
					 `pubdate`,`articles_id`) VALUES ('". mysqli_real_escape_string ($connection, $_POST['name'])."',
					 '".mysqli_real_escape_string ($connection, $_POST['nickname'])."', 
					 '".mysqli_real_escape_string ($connection, $_POST['email'])."', '".$_POST['text']."', NOW(), '".$art['id']."')");
					 
					  echo '<span style="color: green; font-weight: bold;
					 margin-bottom: 10px; display: block;">Коментар 
					 доданий успішно!</span>';
					 
				 }else
				 {
					 //ВИВЕСТИ ПОМИЛКУ
					 echo '<span style="color: red; font-weight:bold;
					 margin-bottom: 10px;">' . $errors['0'] . '<hr>' .
					 '</span>';
				 }
				 
			 }
		   ?>
		    <div class="form__group">
			 <div class="row">
			  <div class="col-md-4">
			   <input type="text" name="name" class="form__control"
			     placeholder="Ім'я" value="<?php echo $_POST['name']; ?>"> 
			   </div>
			  <div class="col-md-4">
             <input type="text" name="nickname" class="form__control"
              placeholder="Нікнейм" value="<?php echo $_POST['nickname']; ?>" >
             </div>
             <div class="col-md-4">
             <input type="text" name="email"  class="form__control"
             placeholder="Email (не відображатиметься)" value="<?php echo $_POST['email']; ?>" >
            </div>
		   </div>
		  </div>
		  <div class="form__group">
		  <textarea class="form__control" name="text" placeholder="
		  Текст коментаря ..." > <?php echo $_POST['text']; ?> </textarea>
		  </div>
		  <div class="form__group">
		  <input type="submit" name="do_post" value="Додати коментар" class="form__control">
		  </div>
	    </form>
	  </div>
	</div>
		 
         </section>
          <section class="content__right col-md-4">
            <?php include "includes/sidebar.php"; ?>
          </section>
        </div>
      </div>
    </div>
		<?php
	}
	?>
   
    <?php include "includes/footer.php"; ?>

  </div>

</body>
</html>